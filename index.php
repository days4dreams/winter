<?php
/*
 * Home page. The wording is written straight into the HTML below: edit it here.
 * Photos: content_image('/images/photos/name.jpg', 'Describe the photo', ...).
 * Until a photo file with that name is in images/photos/, the placeholder shows.
 */
$title = '';   // the homepage uses the site name and tagline as its title
$description = "A one-bedroom flat in Gosforth, Newcastle, for longer stays: parking, Wi-Fi and a washer, ten minutes' walk from the Metro and the High Street.";
$overPhoto = true;
require __DIR__ . '/includes/content.php';
require __DIR__ . '/includes/head.php';
?>

<section class="hero">
  <?= content_image('/images/photos/living-room.jpg', "The living room at Winter's Nook", 'band-photo', '') ?>
  <div class="shade-over"></div>
  <div class="wrap stack">
    <h1>A place to come <em>home to</em> in Gosforth</h1>
    <p>A one-bedroom flat for longer stays, a few miles from central Newcastle, with the Metro, buses and a bustling High Street a short walk away.</p>
    <div class="btns"><a class="btn btn--fill" href="/the-flat">See the flat</a><a class="btn btn--light" href="<?= e($site['booking_url']) ?>"<?= link_attrs($site['booking_url']) ?>>Enquire</a></div>
  </div>
</section>

<section class="band torn">
  <div class="wrap split">
    <div class="stack">
      <p class="label">Your home from home</p>
      <h2>Pop the kettle on, <em>unpack properly</em> and settle in for a while.</h2>
      <p>Winter's Nook is a cheerful upstairs flat on a quiet, pedestrian-only mews street in Gosforth. A bright kitchen and bathroom, a cosy living room and a king-size bedroom with built-in wardrobes make it easy to live in, not just stay in.</p>
      <p>Park with a guest permit, work on the Wi-Fi, put a wash on and cook up a storm. Cafés, pubs, shops and the Metro are all within walking distance.</p>
      <div class="btns"><a class="btn" href="/the-flat">See the flat</a></div>
    </div>
    <div class="media">
      <div class="card-torn tilt-r"><div><?= content_image('/images/photos/bedroom.jpg', "The bedroom at Winter's Nook", '', '4/5') ?><span class="hand">Room to unpack</span></div></div>
    </div>
  </div>
</section>

<section class="band torn torn--flip" style="--band: var(--primary-light)">
  <div class="wrap features">
    <div><?= svg('illustrations/06-flag.svg', 'illustration') ?><h3 class="hand">Well connected</h3><p>Over 20 bus routes and every Metro line within ten minutes' walk. Central Newcastle is about 20 minutes away.</p></div>
    <div><?= svg('illustrations/05-sprig-leafy.svg', 'illustration') ?><h3 class="hand">Quiet street</h3><p>A pretty, car-free mews, with permit parking a minute's walk away on the next road.</p></div>
    <div><?= svg('illustrations/10-seedling.svg', 'illustration') ?><h3 class="hand">Settle in</h3><p>A full kitchen, washing machine, Wi-Fi and plenty of wardrobe space for weeks or months away.</p></div>
  </div>
</section>

<section class="band torn">
  <div class="wrap stack" style="gap: 2.5rem">
    <h2 class="centre-text">Inside <em>Winter's Nook</em></h2>
    <div class="cards">
      <article class="card">
        <?= content_image('/images/photos/kitchen.jpg', "The kitchen at Winter's Nook", '', '4/3') ?>
        <div class="card-body"><h3>The Flat</h3><p>One bedroom, a bright kitchen and bathroom, and a cosy living room for winding down.</p><a class="btn" href="/the-flat">See the flat</a></div>
      </article>
      <article class="card">
        <?= content_image('/images/photos/dining-table.jpg', 'The dining table set for two', '', '4/3') ?>
        <div class="card-body"><h3>Longer Stays</h3><p>For NHS staff, contractors, students and anyone between homes. Stay 21 nights or more and save 25%.</p><a class="btn" href="/longer-stays">Longer stays</a></div>
      </article>
      <article class="card">
        <?= content_image('/images/photos/gosforth.jpg', "The front door at Winter's Nook", '', '4/3') ?>
        <div class="card-body"><h3>The Guide</h3><p>Our favourite places to eat, shop, swim and stroll in and around Gosforth.</p><a class="btn" href="/the-guide">Read the guide</a></div>
      </article>
    </div>
  </div>
</section>

<section class="band torn-photo statement">
  <?= content_image('/images/photos/street.jpg', 'The quiet, car-free path to the front door', 'band-photo', '') ?>
  <div class="shade-over"></div>
  <div class="wrap">
    <h2>Long days away, and somewhere <em>calm to come back to.</em></h2>
    <div class="btns"><a class="btn btn--light" href="/longer-stays">Plan a longer stay</a></div>
  </div>
</section>

<section class="band" style="--band: var(--primary-light)">
  <div class="wrap overlap">
    <div class="card-torn tilt-l"><div><?= content_image('/images/photos/hosts.jpg', 'Your hosts, Lauren and David', '', '4/5') ?><span class="hand">Lauren &amp; David</span></div></div>
    <div class="stack">
      <p class="label">Meet your hosts</p>
      <h2>We're Lauren and David, and <em>we'd love to welcome you.</em></h2>
      <p>Born and raised in the North East, we travelled the world and spent several years in New Zealand before coming home in 2024.</p>
      <p>We look after Winter's Nook ourselves, from managing bookings to changing the beds, and we're always happy to help with longer stays.</p>
    </div>
  </div>
</section>

<section class="band torn torn--flip">
  <div class="wrap stack" style="gap: 2rem">
    <p class="label centre-text">Who stays at Winter's Nook</p>
    <div class="slider" id="home-slider" data-slider tabindex="0" aria-label="Who stays here (scrolls sideways)">
<?php
// The numbered slides: [title, text, button text, link, photo, photo description]
$slides = [
    ['NHS & healthcare staff', 'A calm, comfortable base close to the city, with easy Metro and bus links.', 'Longer stays', '/longer-stays', '/images/photos/slide-nhs.jpg', 'Flowers on the kitchen windowsill'],
    ['Contractors', 'Weekly or monthly stays, with permit parking and a washing machine.', 'For employers', '/longer-stays#employers', '/images/photos/slide-contractors.jpg', 'The kitchen sink and worktop'],
    ['Students & researchers', 'About ten minutes on the Metro to central Newcastle.', 'Ask a question', '/enquire', '/images/photos/slide-students.jpg', 'The sofa in the living room'],
    ['Between homes', 'Somewhere comfortable while you move, renovate or wait for completion.', 'Moving home?', '/longer-stays#employers', '/images/photos/slide-moving.jpg', 'Looking through the kitchen to the dining table'],
];
foreach ($slides as $i => [$slideTitle, $slideText, $slideButton, $slideLink, $slidePhoto, $slideAlt]):
?>
      <article class="slide">
        <?= content_image($slidePhoto, $slideAlt, '', '4/3') ?>
        <p class="slide-number"><?= sprintf('%02d.', $i + 1) ?></p>
        <h3 class="label"><?= e($slideTitle) ?></h3>
        <p><?= e($slideText) ?></p>
        <div><a class="btn btn--small" href="<?= e($slideLink) ?>"><?= e($slideButton) ?></a></div>
      </article>
<?php endforeach; ?>
    </div>
    <div class="slider-arrows" data-slider-arrows="home-slider" hidden>
      <button type="button" data-direction="-1" aria-label="Previous">&larr;</button>
      <button type="button" data-direction="1" aria-label="Next">&rarr;</button>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/review.php'; ?>
<?php include __DIR__ . '/includes/callout.php'; ?>
<?php include __DIR__ . '/includes/footer.php'; ?>
