<?php
/*
 * Longer Stays: the page for guests staying weeks or months
 * (NHS staff, contractors, students, people between homes).
 * Wording is written straight in below: edit it here.
 * The questions near the bottom come from content/faqs.md (those marked "show on: long").
 */
$title = 'Longer stays in Gosforth, Newcastle';
$description = "Monthly and weekly stays at Winter's Nook in Gosforth: a one-bedroom flat for NHS staff, contractors, students and people between homes.";
$overPhoto = true;
require __DIR__ . '/includes/content.php';
require __DIR__ . '/includes/head.php';
?>

<section class="hero hero--short hero--centre">
  <?= content_image('/images/photos/street.jpg', 'The quiet, car-free path to the front door', 'band-photo', '') ?>
  <div class="shade-over"></div>
  <div class="wrap stack centre">
    <p class="label">Weeks or months, not nights</p>
    <h1>Longer stays, <em>made easy</em></h1>
  </div>
</section>

<section class="band torn">
  <div class="wrap split">
    <div class="stack">
      <p class="label">A place to come home to</p>
      <h2>Working or studying away from home? Winter's Nook is <em>a calm, comfortable base</em> for the weeks or months ahead.</h2>
      <p>It's set up for everyday life, not just a weekend: a proper kitchen, a washing machine, Wi-Fi, a king-size bed and wardrobes you can actually unpack into. Longer stays are discounted, so the longer you stay, the more you save.</p>
      <div class="btns">
        <a class="btn btn--fill" href="/enquire">Ask about your dates</a>
        <a class="btn" href="/the-flat">See the flat</a>
      </div>
    </div>
    <div class="media">
      <div class="card-torn tilt-r"><div><?= content_image('/images/photos/armchair.jpg', 'The armchair and reading lamp', '', '4/5') ?><span class="hand">Unpack &amp; settle in</span></div></div>
    </div>
  </div>
</section>

<section class="band torn torn--flip">
  <div class="wrap stack" style="gap: 3rem">
    <h2 class="centre-text">Who it's <em>perfect</em> for</h2>
    <div class="features">
      <div><?= svg('illustrations/01-oak-leaf.svg', 'illustration') ?><h3 class="hand">NHS &amp; healthcare</h3><p>A quiet place to rest between shifts, with easy Metro and bus links across the city.</p></div>
      <div><?= svg('illustrations/09-sprig-small.svg', 'illustration') ?><h3 class="hand">Contractors</h3><p>Weekly or monthly stays, a guest parking permit and a washer for your work clothes.</p></div>
      <div><?= svg('illustrations/04-flower.svg', 'illustration') ?><h3 class="hand">Students &amp; movers</h3><p>For a term, a placement, or while you're between homes. About ten minutes to the city on the Metro.</p></div>
    </div>
  </div>
</section>

<section class="band" style="--band: var(--primary-light)">
  <div class="wrap overlap">
    <div class="card-torn tilt-l"><div><?= content_image('/images/photos/gosforth.jpg', "The front door at Winter's Nook", '', '4/5') ?><span class="hand">Gosforth life</span></div></div>
    <div class="stack">
      <p class="label">The neighbourhood</p>
      <h2>A few miles from central Newcastle, next to <em>a busy transport hub</em> and a bustling High Street.</h2>
      <p>Regent Centre Metro is about ten minutes' walk, with every Metro line and over 20 bus routes nearby. ASDA, M&amp;S and Sainsbury's are close by, and there's a Spar with a Post Office on Salters Road.</p>
      <p>The flat sits on a pretty, pedestrian-only street, so it's quiet, with permit parking a minute's walk away on the next road.</p>
    </div>
  </div>
</section>

<?php $review = 'long'; include __DIR__ . '/includes/review.php'; ?>

<?php $longFaqs = faq_list('long'); if ($longFaqs !== ''): ?>
<section class="band torn" style="--band: var(--primary-light); padding-block: 0">
  <div class="split" style="gap: 0; align-items: stretch">
    <div class="stack wrap" style="padding-block: var(--band-space); max-width: 36rem; margin-inline: auto; width: 100%">
      <p class="label">Good to know</p>
      <h2>Questions about <em>longer stays</em></h2>
      <?= $longFaqs ?>
    </div>
    <?= content_image('/images/photos/dining-table.jpg', 'The dining table set for two') ?>
  </div>
</section>
<?php endif; ?>

<?php
$calloutLabel = 'Staying a while?';
$calloutText = 'Tell us your dates and we\'ll come back with <em>our best long-stay rate.</em>';
include __DIR__ . '/includes/callout.php';
?>
<?php include __DIR__ . '/includes/footer.php'; ?>
