<?php
/**
 * The row of six photos above the footer, with a button to Instagram.
 * Change the list below: [photo, description of the photo].
 */
$instagramPhotos = [
    ['/images/photos/slide-nhs.jpg', 'Flowers on the kitchen windowsill'],
    ['/images/photos/cushions.jpg', 'Cushions on the sofa'],
    ['/images/photos/gosforth.jpg', "The front door at Winter's Nook"],
    ['/images/photos/armchair.jpg', 'The armchair and reading lamp'],
    ['/images/photos/guide-green.jpg', 'Pink flowers by the front step'],
    ['/images/photos/street.jpg', 'The quiet, car-free path to the front door'],
];
?>
<section class="instagram band torn" aria-label="Instagram">
  <div class="wrap">
    <div class="instagram-row">
<?php foreach ($instagramPhotos as [$src, $alt]): ?>
      <?= content_image($src, $alt, '', '1/1') ?>
<?php endforeach; ?>
      <a class="btn btn--paper instagram-handle" href="<?= e($site['instagram_url']) ?>"<?= link_attrs($site['instagram_url']) ?>><?= e($site['instagram_handle']) ?></a>
    </div>
  </div>
</section>
