<?php
/**
 * Site settings: the ONE place to change these details.
 * Every page reads from here, so a change here updates the whole site.
 *
 * This site was made from Autumn House (days4dreams/autumn): the same code
 * with Winter's Nook's settings, colours, logo and wording.
 */

$site = [
    'name'     => "Winter's Nook",
    'tagline'  => 'by Staying Season',
    // The homepage's title in Google and browser tabs (after the name).
    'home_title' => 'Long-stay flat in Gosforth, Newcastle',
    'url'      => 'https://winter.stayingseason.com', // no trailing slash
    'year'     => date('Y'), // updates itself every January

    // false while the site still has placeholder text: Google is asked not
    // to list it. Change to true on launch day.
    'launched' => false,

    // Where the "Book now" buttons go: Enquire for now, as Winter's Nook is
    // booked by arrangement. Change to an Amenitiz booking page if one is set up.
    'booking_url' => '/enquire',

    // Footer links still to come. '#' until they're ready.
    'staying_season_url' => '#',

    // The Enquire form's emails come "from" this address (replies go to the guest).
    // An address on the site's own domain is less likely to land in spam.
    'mail_from' => 'noreply@stayingseason.com',

    // Shown to Google in the structured data (includes/structured-data.php).
    'address' => [
        'street'   => '',          // left out until Lauren confirms
        'town'     => 'Gosforth, Newcastle upon Tyne',
        'county'   => 'Tyne and Wear',
        'postcode' => 'NE3',
        'country'  => 'GB',
    ],
    // Other places Winter's Nook is listed (Google Business Profile, Airbnb…).
    // Add each address here; Google uses them to connect the listings.
    'also_listed_at' => [
        'https://www.instagram.com/atstayingseason/',
    ],

    // Guest ratings shown under the reviews. Update them now and then
    // (and the 'as_of' month, which is shown beside them).
    // Empty for now: add them like this once there are enough reviews:
    // ['site' => 'Airbnb', 'score' => '4.9', 'out_of' => '5', 'count' => 12],
    'ratings' => [],
    'ratings_as_of' => 'November 2026',

    // The small credit at the bottom of every page.
    'credit' => ['text' => 'Site by Green Smoke Studio', 'url' => 'https://www.greensmokestudio.com/'],

    'instagram_url'    => 'https://www.instagram.com/atstayingseason/',
    'instagram_handle' => '@atstayingseason',

    // The thin bar across the very top of every page.
    // Leave 'text' empty ('') to switch it off. 'link' is optional;
    // 'link_words' are the words in 'text' that become the link.
    'announcement' => [
        'text'       => 'Staying a month or more? Ask about our long-stay rates',
        'link'       => '/enquire',
        'link_words' => 'Ask about our long-stay rates',
    ],

    // Shown on Google and when a page is shared, unless a page sets its own.
    'description'   => "Winter's Nook is a one-bedroom upstairs flat in Gosforth, Newcastle, for longer stays: a home to come back to while you work or study away.",
    'default_image' => '/images/photos/collage.jpg',
];

/** The main menu, in order. Also used for the "Explore" list in the footer. */
$menu = [
    '/'             => 'Home',
    '/faqs'         => 'FAQs',
    '/the-guide'    => 'The Guide',
    '/the-flat'     => 'The Flat',
    '/longer-stays' => 'Longer Stays',
    '/enquire'      => 'Enquire',
];

/**
 * Guide categories. The key (e.g. 'local-area') is what a post's
 * "category:" line uses, and appears in the address /the-guide?category=local-area.
 * Prefer changing only the name; changing a key means updating the posts that use it.
 */
$guideCategories = [
    'get-to-know' => 'Get to know',
    'local-area'  => 'Local area',
    'news'        => 'News',
];

/**
 * Private settings written by the publishing workflow (not in the public
 * repository): currently just the address the Enquire form sends to.
 */
$private = is_file(__DIR__ . '/private.php') ? (include __DIR__ . '/private.php') : [];
$site['enquiry_email'] = $private['enquiry_email'] ?? '';

/** Escape text before printing it into HTML. Use for anything that isn't hard-coded markup. */
function e($text)
{
    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}

/** The current page's clean path, e.g. "/the-guide/slow-weekend" (no query string, no trailing slash). */
function current_path()
{
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $path = preg_replace('#\.(php|html)$#', '', $path);
    if ($path === '/index') {
        $path = '/';
    }
    return ($path === '/') ? '/' : rtrim($path, '/');
}

/** Is this menu link the section we're in? "/the-guide" is also current on every Guide post. */
function is_current($link)
{
    $path = current_path();
    if ($link === '/') {
        return $path === '/';
    }
    return $path === $link || strpos($path, $link . '/') === 0;
}

/**
 * The announcement bar's text, with its link on just the 'link_words'
 * (or on the whole text if those words aren't found).
 */
function announcement_html($a)
{
    $text = e($a['text']);
    if (($a['link'] ?? '') === '') {
        return $text;
    }
    $open = '<a href="' . e($a['link']) . '"' . link_attrs($a['link']) . '>';
    $words = e($a['link_words'] ?? '');
    $at = ($words !== '') ? strpos($text, $words) : false;
    if ($at === false) {
        return $open . $text . '</a>';
    }
    return substr($text, 0, $at) . $open . $words . '</a>' . substr($text, $at + strlen($words));
}

/** Attributes for a link that may go to another website: those open in a new tab. */
function link_attrs($url)
{
    return preg_match('#^https?://#', $url) ? ' target="_blank" rel="noopener"' : '';
}

/**
 * Print an SVG file from /images straight into the page, so CSS can colour
 * it (logos and illustrations follow the text colour around them).
 * Areas that were white in Affinity take the background colour instead.
 */
function svg($file, $class = '', $label = '')
{
    static $count = 0;
    $path = __DIR__ . '/../images/' . $file;
    if (!preg_match('#^[a-z0-9/_-]+\.svg$#', $file) || !is_file($path)) {
        return '';
    }
    $svg = file_get_contents($path);
    $svg = substr($svg, strpos($svg, '<svg'));                       // drop the XML header
    $svg = preg_replace('/\s(serif:id|xml:space|xmlns:serif|xmlns:xlink|width|height)="[^"]*"/', '', $svg);
    $svg = str_replace(['fill:white;', 'fill:#fff;', 'fill="#fff"'], ['fill:var(--knockout);', 'fill:var(--knockout);', 'fill="var(--knockout)"'], $svg);
    // Each SVG's internal names get a unique prefix so two on one page don't clash.
    $prefix = 's' . (++$count) . '-';
    $svg = preg_replace('/\bid="([^"]+)"/', 'id="' . $prefix . '$1"', $svg);
    $svg = preg_replace('/url\(#([^)]+)\)/', 'url(#' . $prefix . '$1)', $svg);
    $svg = preg_replace('/href="#([^"]+)"/', 'href="#' . $prefix . '$1"', $svg);
    $a11y = ($label !== '') ? ' role="img" aria-label="' . e($label) . '"' : ' aria-hidden="true" focusable="false"';
    $svg = preg_replace('/<svg\b/', '<svg class="' . e($class) . '"' . $a11y, $svg, 1);
    return preg_replace('/>\s+</', '><', $svg);
}

/** The placeholder image, until real photos go in. $ratio is width/height, e.g. '4/5'. */
function placeholder($alt = '', $class = '', $ratio = '')
{
    $style = $ratio ? ' style="aspect-ratio:' . e($ratio) . '"' : '';
    return '<img src="/images/placeholder.svg" alt="' . e($alt) . '" class="photo ' . e($class) . '"' . $style . ' loading="lazy">';
}
