<?php
/*
 * The Guide: the list of posts at /the-guide, and each post at
 * /the-guide/{post}. Posts are text files in content/guide/ (see
 * _template.md there); this file only lays them out.
 * The wording at the top of The Guide page is written straight in below.
 */
require __DIR__ . '/includes/content.php';

$slug = $_GET['post'] ?? '';
$post = ($slug !== '') ? find_guide_post($slug) : null;

if ($slug !== '' && $post === null) {
    require __DIR__ . '/404.php';   // no such post (or a draft on the live site)
    return;
}

/* ---------------------------------------------------------------- */
/* One post                                                          */
/* ---------------------------------------------------------------- */
if ($post !== null):
    $title = $post['title'];
    $description = $post['summary'];
    if (preg_match('#^/images/#', $post['image']) && is_file(__DIR__ . $post['image'])) {
        $ogImage = $post['image'];
        $ogImageAlt = $post['image_alt'];
    }
    $parts = guide_post_parts($post['body']);
    require __DIR__ . '/includes/head.php';
?>

<article>
  <header class="wrap post-head">
<?php if ($post['category_name'] !== ''): ?>
    <p class="label"><a href="/the-guide?category=<?= e($post['category']) ?>"><?= e($post['category_name']) ?></a><?= $post['draft'] === true ? ' · Draft' : '' ?></p>
<?php endif; ?>
    <h1><?= markdown_line($post['title']) ?></h1>
  </header>

  <div class="wrap">
<?php if ($parts['intro'] !== ''): ?>
    <div class="post-intro prose" style="margin-top: 2rem"><?= $parts['intro'] ?></div>
<?php endif; ?>
    <div class="post-body">
<?php
    $withPhoto = 0; // sections with a photo take turns: photo left, then right
    foreach ($parts['sections'] as $section):
        $hasPhoto = ($section['image'] !== null);
        $classes = 'post-section' . ($hasPhoto ? '' : ' post-section--text') . ($hasPhoto && $withPhoto++ % 2 === 1 ? ' post-section--flip' : '');
?>
      <section class="<?= $classes ?>">
        <div class="post-section-main">
<?php if ($hasPhoto): ?>
          <?= content_image($section['image']['src'], $section['image']['alt'], 'post-photo') ?>
<?php endif; ?>
          <div class="stack">
<?php if ($section['label'] !== ''): ?>
            <p class="label"><?= e($section['label']) ?></p>
<?php endif; ?>
            <h2><?= markdown_line($section['heading']) ?></h2>
            <div class="prose"><?= $section['text'] ?></div>
          </div>
        </div>
<?php if ($section['gallery']): ?>
        <div class="post-gallery">
<?php foreach ($section['gallery'] as $photo): ?>
          <?= content_image($photo['src'], $photo['alt']) ?>
<?php endforeach; ?>
        </div>
<?php endif; ?>
      </section>
<?php endforeach; ?>
    </div>
    <p class="post-back"><a class="btn" href="/the-guide">Back to the guide</a></p>
  </div>
</article>

<?php
    $calloutLabel = 'Staying a while?';
    $calloutText = 'Fancy calling Gosforth home for a while? <em>Winter\'s Nook</em> is ready when you are.';
    include __DIR__ . '/includes/callout.php';
    include __DIR__ . '/includes/footer.php';
    return;
endif;

/* ---------------------------------------------------------------- */
/* The Guide page: every post                                        */
/* ---------------------------------------------------------------- */
// ?category=local-area shows one category; anything unknown shows every post.
$category = $_GET['category'] ?? '';
if (!isset($guideCategories[$category])) {
    $category = '';
}
$posts = ($category !== '') ? guide_posts_in($category) : guide_posts();

$ogImage = '/images/photos/gosforth.jpg';
$ogImageAlt = 'Gosforth High Street';
$title = ($category !== '') ? $guideCategories[$category] . ' | The Guide' : 'The Guide: living in Gosforth';
$description = "Our guide to Gosforth and Newcastle: getting around, where to eat and drink, shopping, keeping fit and news from Winter's Nook.";
$overPhoto = true;
require __DIR__ . '/includes/head.php';
?>

<section class="hero hero--short hero--centre">
  <?= content_image('/images/photos/gosforth.jpg', "The front door at Winter's Nook", 'band-photo', '') ?>
  <div class="shade-over"></div>
  <div class="wrap stack centre">
    <h1>The Winter's Nook <em>Guide</em></h1>
    <p>Our favourite places to eat, shop, swim and stroll in and around Gosforth, and how to get about.</p>
  </div>
</section>

<section class="band torn">
  <div class="wrap">
    <nav class="guide-categories" aria-label="Guide categories">
      <a class="btn btn--small" href="/the-guide"<?= $category === '' ? ' aria-current="page"' : '' ?>>All posts</a>
<?php foreach ($guideCategories as $key => $name): ?>
      <a class="btn btn--small" href="/the-guide?category=<?= e($key) ?>"<?= $category === $key ? ' aria-current="page"' : '' ?>><?= e($name) ?></a>
<?php endforeach; ?>
    </nav>
<?php if (!$posts): ?>
    <p class="centre-text">New posts are on their way. <a href="/the-guide">See all posts</a></p>
<?php else: ?>
    <div class="post-grid">
<?php foreach ($posts as $p): ?>
      <a class="post-card" href="<?= e($p['url']) ?>">
        <?= content_image($p['image'], $p['image_alt']) ?>
<?php if ($p['category_name'] !== ''): ?>
        <span class="label"><?= e($p['category_name']) ?><?= $p['draft'] === true ? ' · Draft' : '' ?></span>
<?php endif; ?>
        <h3><?= markdown_line($p['title']) ?></h3>
      </a>
<?php endforeach; ?>
    </div>
<?php endif; ?>
  </div>
</section>

<?php $review = 'guide'; include __DIR__ . '/includes/review.php'; ?>
<?php include __DIR__ . '/includes/callout.php'; ?>
<?php include __DIR__ . '/includes/footer.php'; ?>
