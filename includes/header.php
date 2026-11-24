<?php
/**
 * Site header: logo, menu and "Book now".
 * The menu items are set in includes/config.php ($menu).
 * On phones the menu folds into a "Menu" button (it works without JavaScript).
 */
?>
<header class="site-header">
  <div class="wrap site-header-inner">
    <a href="/" class="site-logo"<?= is_current('/') ? ' aria-current="page"' : '' ?>><?= svg('logos/primary-logo.svg', 'logo', $site['name'] . ' home') ?: '<span class="logo-text">' . e($site['name']) . '</span>' ?></a>
    <nav class="menu" aria-label="Main">
      <ul>
<?php foreach ($menu as $href => $label): ?>
        <li><a href="<?= e($href) ?>"<?= is_current($href) ? ' aria-current="page"' : '' ?>><?= e($label) ?></a></li>
<?php endforeach; ?>
      </ul>
    </nav>
    <a class="btn btn--small header-book" href="<?= e($site['booking_url']) ?>"<?= link_attrs($site['booking_url']) ?>>Book now</a>
    <details class="menu-toggle">
      <summary class="btn btn--small">Menu</summary>
      <nav class="menu-panel" aria-label="Main (mobile)">
        <ul>
<?php foreach ($menu as $href => $label): ?>
          <li><a href="<?= e($href) ?>"<?= is_current($href) ? ' aria-current="page"' : '' ?>><?= e($label) ?></a></li>
<?php endforeach; ?>
          <li><a href="<?= e($site['booking_url']) ?>"<?= link_attrs($site['booking_url']) ?>>Book now</a></li>
        </ul>
      </nav>
    </details>
  </div>
</header>
