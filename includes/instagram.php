<?php
/**
 * The row of six photos above the footer, with a button to Instagram.
 * Change the list below: [photo, description of the photo].
 * Empty paths show the placeholder until real photos are added.
 */
$instagramPhotos = array_fill(0, 6, ['', '']);
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
