<?php
/**
 * Reads the two kinds of content kept in text files in /content:
 *
 *  - Guide posts: content/guide/*.md, one file per post (see _template.md there).
 *    The file name is the web address: content/guide/slow-weekend.md appears
 *    at /the-guide/slow-weekend.
 *  - FAQs: content/faqs.md, one file holding every question (instructions inside).
 *
 * Everything else (the wording on Home, The House and so on) is written
 * straight into each page's own file.
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/lib/Parsedown.php';

const SLUG_PATTERN = '/^[a-z0-9]+(?:-[a-z0-9]+)*$/';
const CONTENT_DIR  = __DIR__ . '/../content';

/** True when previewing on your own computer (drafts are then shown, marked "Draft"). */
function is_local_preview()
{
    $host = strtolower(explode(':', $_SERVER['HTTP_HOST'] ?? '')[0]);
    return in_array($host, ['localhost', '127.0.0.1'], true);
}

/** Is this a safe address part? Checked before any file is opened, so no one can ask for files outside /content. */
function valid_slug($slug)
{
    return is_string($slug) && preg_match(SLUG_PATTERN, $slug) === 1;
}

/**
 * Split a content file into its settings (the part between the --- lines)
 * and its body. Settings are simple "name: value" lines; true/false become
 * yes/no switches. Lines starting with # are notes and are ignored.
 */
function read_content_file($path)
{
    $text = str_replace("\r\n", "\n", file_get_contents($path));
    $meta = [];
    $body = $text;

    if (preg_match('/\A---\n(.*?)\n---\n?(.*)\z/s', $text, $m)) {
        $body = $m[2];
        foreach (explode("\n", $m[1]) as $line) {
            if (trim($line) === '' || $line[0] === '#' || strpos($line, ':') === false) {
                continue;
            }
            [$key, $value] = array_map('trim', explode(':', $line, 2));
            $value = trim($value, "\"'");
            if (in_array(strtolower($value), ['true', 'yes'], true)) {
                $value = true;
            } elseif (in_array(strtolower($value), ['false', 'no'], true)) {
                $value = false;
            }
            $meta[strtolower($key)] = $value;
        }
    }
    return [$meta, $body];
}

/** Turn Markdown into HTML. Links to other websites open in a new tab. */
function markdown($text)
{
    $html = (new Parsedown())->text($text);
    return preg_replace_callback('/<a href="(https?:\/\/[^"]+)"/', function ($m) {
        global $site;
        return (strpos($m[1], $site['url']) === 0) ? $m[0] : $m[0] . ' target="_blank" rel="noopener"';
    }, $html);
}

/** Markdown for one line (a heading or title): *italic* and links, no paragraph around it. */
function markdown_line($text)
{
    return (new Parsedown())->line($text);
}

/* ------------------------------------------------------------------ */
/* Guide posts                                                         */
/* ------------------------------------------------------------------ */

/** All Guide posts, newest first. Drafts are left out on the live site. */
function guide_posts()
{
    static $posts = null;
    if ($posts !== null) {
        return $posts;
    }
    $posts = [];
    foreach (glob(CONTENT_DIR . '/guide/*.md') ?: [] as $path) {
        $slug = basename($path, '.md');
        if (!valid_slug($slug)) {
            continue; // _template.md and oddly named files are skipped
        }
        [$meta, $body] = read_content_file($path);
        $post = $meta + [
            'title' => $slug, 'date' => '', 'category' => '', 'summary' => '',
            'image' => '', 'image_alt' => '', 'draft' => false,
        ];
        global $guideCategories;
        // The category's name, e.g. "Local area"; empty if the post has none (or a misspelt one).
        $post['category_name'] = $guideCategories[$post['category']] ?? '';
        if ($post['draft'] === true && !is_local_preview()) {
            continue;
        }
        $post['slug'] = $slug;
        $post['body'] = $body;
        $post['url']  = '/the-guide/' . $slug;
        $posts[] = $post;
    }
    usort($posts, function ($a, $b) {
        return strcmp($b['date'], $a['date']);
    });
    return $posts;
}

/** Posts in one category, newest first. */
function guide_posts_in($category)
{
    return array_values(array_filter(guide_posts(), function ($p) use ($category) {
        return $p['category'] === $category;
    }));
}

/** One post, or null if it doesn't exist (or is a draft on the live site). */
function find_guide_post($slug)
{
    if (!valid_slug($slug)) {
        return null;
    }
    foreach (guide_posts() as $post) {
        if ($post['slug'] === $slug) {
            return $post;
        }
    }
    return null;
}

/**
 * Split a post's body into the parts the post layout needs:
 *   'intro'    => HTML for the text before the first ## heading (shown centred)
 *   'sections' => one per ## heading, each with:
 *       'label'   small capitals above the heading (from a #### line just before it)
 *       'heading' the heading, *italics* allowed
 *       'image'   the section's first photo, shown beside the text (or null)
 *       'text'    HTML for the rest of the section
 *       'gallery' photos written together on one line or in one paragraph,
 *                 shown as a row under the section
 * See content/guide/_template.md for how this looks when writing a post.
 */
function guide_post_parts($body)
{
    $body = str_replace("\r\n", "\n", $body);
    // "#### Friday" straight before "## Arrive" becomes the label of that section.
    $body = preg_replace('/^#### +(.+?)\s*\n+## +(.+)$/m', "## $2\x1F$1", $body);
    $chunks = preg_split('/^(?=## )/m', $body);

    $intro = '';
    if ($chunks && strpos($chunks[0], '## ') !== 0) {
        $intro = markdown(trim(array_shift($chunks)));
    }

    $imageLine = '/^\s*!\[([^\]]*)\]\(([^)\s]+)\)\s*$/';
    $sections = [];
    foreach ($chunks as $chunk) {
        [$headingLine, $rest] = array_pad(explode("\n", $chunk, 2), 2, '');
        [$heading, $label] = array_pad(explode("\x1F", substr($headingLine, 3), 2), 2, '');

        $image = null;
        $gallery = [];
        $kept = [];
        // Look at each paragraph: photo-only paragraphs are taken out of the text.
        foreach (preg_split('/\n\s*\n/', trim($rest)) as $para) {
            $lines = array_filter(array_map('trim', explode("\n", $para)), 'strlen');
            preg_match_all('/!\[([^\]]*)\]\(([^)\s]+)\)/', $para, $found, PREG_SET_ORDER);
            $onlyImages = $lines && count($found) > 0
                && trim(preg_replace('/!\[[^\]]*\]\([^)\s]+\)/', '', $para)) === '';
            if (!$onlyImages) {
                $kept[] = $para;
                continue;
            }
            $photos = array_map(function ($f) { return ['alt' => $f[1], 'src' => $f[2]]; }, $found);
            if (count($photos) === 1 && $image === null && !$gallery) {
                $image = $photos[0];
            } else {
                $gallery = array_merge($gallery, $photos);
            }
        }
        $sections[] = [
            'label'   => trim($label),
            'heading' => trim($heading),
            'image'   => $image,
            'text'    => markdown(implode("\n\n", $kept)),
            'gallery' => $gallery,
        ];
    }
    return ['intro' => $intro, 'sections' => $sections];
}

/** An <img> for a photo named in a content file, or the placeholder if the file isn't there yet. */
function content_image($src, $alt, $class = '', $ratio = '')
{
    $isLocal = is_string($src) && preg_match('#^/images/[A-Za-z0-9/_.-]+$#', $src) && is_file(__DIR__ . '/..' . $src);
    if (!$isLocal) {
        return placeholder($alt, $class, $ratio);
    }
    $style = $ratio ? ' style="aspect-ratio:' . e($ratio) . '"' : '';
    $size = @getimagesize(__DIR__ . '/..' . $src);
    $dims = $size ? ' width="' . $size[0] . '" height="' . $size[1] . '"' : '';
    // The big photo at the top of a page loads straight away; the rest load as you scroll.
    $loading = ($class === 'band-photo') ? ' fetchpriority="high"' : ' loading="lazy"';
    return '<img src="' . e($src) . '" alt="' . e($alt) . '" class="photo ' . e($class) . '"' . $style . $dims . $loading . '>';
}

/* ------------------------------------------------------------------ */
/* FAQs                                                                */
/* ------------------------------------------------------------------ */

/**
 * Every FAQ from content/faqs.md, as groups:
 *   [ ['name' => 'The House', 'questions' => [ ['question', 'answer' (HTML), 'show_on' => [...], 'id'], ... ]], ... ]
 */
function faqs()
{
    static $groups = null;
    if ($groups !== null) {
        return $groups;
    }
    $groups = [];
    $path = CONTENT_DIR . '/faqs.md';
    if (!is_file($path)) {
        return $groups;
    }
    [, $body] = read_content_file($path);

    $group = null;
    $q = null;
    $finishQuestion = function () use (&$q, &$group) {
        if ($q !== null && $group !== null) {
            $q['answer'] = markdown(trim($q['answer']));
            $group['questions'][] = $q;
        }
        $q = null;
    };
    $finishGroup = function () use (&$group, &$groups, $finishQuestion) {
        $finishQuestion();
        if ($group !== null && $group['questions']) {
            $groups[] = $group;
        }
        $group = null;
    };

    foreach (explode("\n", $body) as $line) {
        if (preg_match('/^## +(.+)$/', $line, $m)) {
            $finishGroup();
            $group = ['name' => trim($m[1]), 'questions' => []];
        } elseif (preg_match('/^### +(.+)$/', $line, $m)) {
            $finishQuestion();
            if ($group === null) {
                $group = ['name' => '', 'questions' => []];
            }
            $question = trim($m[1]);
            $q = ['question' => $question, 'answer' => '', 'show_on' => [],
                  'id' => 'faq-' . trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($question)), '-')];
        } elseif ($q !== null && $q['answer'] === '' && preg_match('/^show on: *(.*)$/i', trim($line), $m)) {
            $q['show_on'] = array_values(array_filter(array_map('trim', explode(',', strtolower($m[1])))));
        } elseif ($q !== null) {
            $q['answer'] .= $line . "\n";
        }
        // Anything before the first question (the instructions at the top) is ignored.
    }
    $finishGroup();
    return $groups;
}

/** One question that opens and closes. */
function faq_item($q)
{
    return '<details class="faq-item" id="' . e($q['id']) . '"><summary>' . e($q['question']) . '</summary>'
         . '<div class="faq-answer">' . $q['answer'] . '</div></details>';
}

/**
 * The questions marked "show on: $page" in content/faqs.md, for use on any page:
 *     <?= faq_list('long') ?>
 * Prints nothing if no questions are marked for that page.
 * $first: question ids to move to the top, e.g. ['faq-how-much-does-it-cost']
 * (a question's id is "faq-" plus its words in lower case, joined by hyphens).
 */
function faq_list($page, $first = [])
{
    $top = array_fill_keys($first, '');
    $rest = '';
    foreach (faqs() as $group) {
        foreach ($group['questions'] as $q) {
            if (in_array(strtolower($page), $q['show_on'], true)) {
                if (array_key_exists($q['id'], $top)) {
                    $top[$q['id']] = faq_item($q);
                } else {
                    $rest .= faq_item($q);
                }
            }
        }
    }
    $html = implode('', $top) . $rest;
    return $html === '' ? '' : '<div class="faq">' . $html . '</div>';
}
