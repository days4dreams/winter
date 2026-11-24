<?php
/*
 * The Flat. Wording is written straight in below: edit it here.
 * The photo grid takes any number of photos: add a line to $flatPhotos.
 */
$title = 'The Flat: a one-bedroom flat in Gosforth';
$description = "Inside Winter's Nook: a one-bedroom upstairs flat in Gosforth, Newcastle, with a king-size bed, full kitchen, washing machine and Wi-Fi.";
require __DIR__ . '/includes/content.php';
require __DIR__ . '/includes/head.php';

// The photo grid: [photo, description]. Add or remove lines freely; photos keep their own shape.
$flatPhotos = [
    ['/images/photos/living-room.jpg', 'The living room'],
    ['/images/photos/kitchen.jpg', 'The kitchen'],
    ['/images/photos/bedroom.jpg', 'The king-size bedroom'],
    ['/images/photos/wardrobes.jpg', 'The built-in wardrobes'],
    ['/images/photos/bathroom.jpg', 'The bathroom'],
    ['/images/photos/dining-table.jpg', 'The dining table set for two'],
];
?>

<header class="wrap page-head centre-text">
  <h1>A cheerful flat, <em>small</em> &amp; perfectly formed</h1>
</header>

<section class="band band--tight" style="--band: var(--primary-light); padding-block: 0">
  <div class="split" style="gap: 0; align-items: stretch">
    <div class="stack wrap" style="padding-block: var(--band-space); max-width: 36rem; margin-inline: auto">
      <p class="label">The flat</p>
      <h2>An upstairs Tyneside flat in Gosforth, with <em>a bright kitchen and bathroom</em>, one bedroom and a cosy living room.</h2>
      <p>The bedroom has a king-size bed facing a generous run of built-in wardrobes, so there's plenty of room to unpack properly. You'll find a reading lamp, hairdryer, travel iron and spare pillows too.</p>
      <p>The kitchen has an oven and hob, fridge, washing machine and everything you need to cook, with a dining table set for two. The bathroom has a shower and wall heater, with eco-friendly toiletries.</p>
      <p>Heating is electric, with a panel heater in each room. Free Wi-Fi throughout, plus books, board games and a Bluetooth speaker for evenings in.</p>
    </div>
    <?= content_image('/images/photos/bedroom.jpg', "The bedroom at Winter's Nook") ?>
  </div>
</section>

<section class="band torn">
  <div class="wrap gallery">
<?php foreach ($flatPhotos as [$src, $alt]): ?>
    <?= content_image($src, $alt, '', is_file(__DIR__ . $src) ? '' : '4/5') ?>
<?php endforeach; ?>
  </div>
</section>

<?php $flatFaqs = faq_list('flat'); if ($flatFaqs !== ''): ?>
<section class="band torn torn--flip" style="--band: var(--primary-light)">
  <div class="wrap split" style="align-items: start">
    <div class="stack">
      <p class="label">Good to know</p>
      <h2>Questions about <em>the flat</em></h2>
      <p><a href="/faqs">See all FAQs</a></p>
    </div>
    <?= $flatFaqs ?>
  </div>
</section>
<?php endif; ?>

<?php include __DIR__ . '/includes/callout.php'; ?>
<?php include __DIR__ . '/includes/footer.php'; ?>
