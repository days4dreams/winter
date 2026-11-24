<?php
/**
 * A guest review over a photo, styled like the review cards on Instagram.
 *
 * The reviews live in the list below. A page picks one by setting
 * $review = 'long'; (for example) before including this file;
 * without that, the first one is shown.
 * Wording: put the words to stress in <em>…</em>. Change the photo by
 * changing its path.
 */
$reviews = [
    // Add real guest reviews here, e.g.:
    // 'home' => [
    //     'text'  => 'Words to stress go in <em>…</em>.',
    //     'name'  => 'First name, Month Year',
    //     'photo' => '/images/photos/your-photo.jpg',
    // ],
];
$shown = $reviews[$review ?? 'home'] ?? reset($reviews);
if (!$shown) {
    return; // no reviews yet: the band isn't shown
}
?>
<section class="band torn-photo review">
  <?= content_image($shown['photo'], '', 'review-photo') ?>
  <div class="wrap">
    <figure class="review-card">
      <blockquote><?= $shown['text'] /* may contain <em> for italics */ ?></blockquote>
      <figcaption>&ndash; <?= e($shown['name']) ?></figcaption>
    </figure>
<?php if (!empty($site['ratings'])): ?>
    <ul class="ratings" aria-label="Guest ratings, <?= e($site['ratings_as_of']) ?>">
<?php foreach ($site['ratings'] as $r): ?>
      <li><span class="ratings-score"><?= e($r['score']) ?></span><span class="ratings-detail">out of <?= e($r['out_of']) ?> on <?= e($r['site']) ?><br><?= e($r['count']) ?> reviews</span></li>
<?php endforeach; ?>
    </ul>
<?php endif; ?>
  </div>
</section>
