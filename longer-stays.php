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
    <p class="label">A long weekend, week away, or month from home.</p>
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
        <a class="btn" href="#pricing">See prices</a>
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

<?php /* Linked to as /longer-stays#employers from the homepage and elsewhere. */ ?>
<section class="band torn" id="employers" style="--band: var(--primary-light)">
  <div class="wrap split">
    <div class="stack prose">
      <p class="label">For employers, agencies and home movers</p>
      <h2>Somewhere calm for your <em>staff, students and clients</em></h2>
      <p>Placing a new starter, a locum, a visiting researcher or a client between homes? Winter's Nook is a quiet, fully furnished one-bedroom flat in Gosforth, 10 minutes by Metro from central Newcastle (about 20 minutes door to door).</p>
      <p>Moving home and need somewhere to stay before you get the keys? We'd love to host you at Winter's Nook.</p>
      <ul>
        <li><strong>All bills covered:</strong> energy, water, council tax and Wi-Fi are all included, plus the essentials you'd expect, from tea and coffee to toilet roll and washing-up liquid.</li>
        <li><strong>Flexible dates:</strong> a minimum of 3 nights, starting and ending on any day. There are no same-day turnarounds, so when booking direct, guests can check in from 6am and stay until 6pm on their last day.</li>
        <li><strong>Simple payment:</strong> book online by debit or credit card with a 50% deposit, and pay the balance 21 days before arrival. Prefer to pay by invoice or bank transfer? <a href="/enquire">Send us an enquiry</a> and we'll issue the invoice or bank details.</li>
        <li><strong>Cleaning and linen:</strong> we're happy to leave guests in peace. However, for stays of over a week, we can arrange a mid-stay clean. We'll sort that out after booking.</li>
        <li><strong>Anything else:</strong> if you need details like certificates or documentation, <a href="/enquire">get in touch</a> and we'll share.</li>
      </ul>
      <div class="btns"><a class="btn btn--fill" href="/enquire">Enquire</a><a class="btn" href="#pricing">See prices</a></div>
    </div>
    <div class="media">
      <div class="card-torn tilt-r"><div><?= content_image('/images/photos/dining-table.jpg', 'The dining table set for two', '', '4/5') ?><span class="hand">Ready when they are</span></div></div>
    </div>
  </div>
</section>

<?php /* Linked to as /longer-stays#pricing. The same prices are in content/faqs.md ("How much does it cost?"): change both. */ ?>
<section class="band torn torn--flip" id="pricing">
  <div class="wrap stack" style="gap: 2.5rem">
    <div class="stack centre">
      <p class="label">Transparent pricing</p>
      <h2>3-night short breaks <em>from £275</em></h2>
      <p>It's always cheaper to book direct: save around 15%. Here's what you can expect to pay.</p>
    </div>
    <div class="features">
      <div><?= svg('illustrations/10-seedling.svg', 'illustration') ?><h3 class="hand">3 nights or more</h3><p>Short breaks from £275, starting and ending on any day.</p></div>
      <div><?= svg('illustrations/05-sprig-leafy.svg', 'illustration') ?><h3 class="hand">Save 15%</h3><p>Stay 5 nights or more. Weekly stays from £545.</p></div>
      <div><?= svg('illustrations/01-oak-leaf.svg', 'illustration') ?><h3 class="hand">Save 25%</h3><p>Stay 21 nights or more. Three-week stays from £1,445, 30-night stays from £2,000.</p></div>
    </div>
    <p class="centre-text">Longer than that? <a href="/enquire">Get in touch</a> and we'll agree a rate.</p>
  </div>
</section>

<section class="band torn" style="--band: var(--primary-light)">
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
