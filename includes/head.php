<?php
/**
 * Everything from <!DOCTYPE> to the opening <body>, plus the announcement bar
 * and the site header with the menu.
 *
 * Set these in the page BEFORE including this file:
 *   $title        Page title, e.g. "FAQs" (the site name is added automatically)
 *   $description  One or two sentences for Google and social media (about 150 characters)
 *   $overPhoto    true when the page opens with a full-width photo: the header
 *                 then sits on top of the photo in light colours
 *   $ogImage      Optional. Image for social media shares, e.g. "/images/photos/kitchen.jpg"
 *   $ogImageAlt   Optional. A description of that image
 */
require_once __DIR__ . '/config.php';

$fullTitle   = (isset($title) && $title !== '') ? $title . ' | ' . $site['name'] : $site['name'] . ' | ' . $site['home_title'];
$description = $description ?? $site['description'];
$canonical   = $site['url'] . (current_path() === '/' ? '/' : current_path());
$shareImage  = $site['url'] . ($ogImage ?? $site['default_image']);
$shareImageAlt = $ogImageAlt ?? "Winter's Nook, Gosforth";
$overPhoto   = !empty($overPhoto);
// Adding ?v= and the file's date makes browsers fetch the stylesheet again after each change.
$cssVersion  = @filemtime(__DIR__ . '/../css/style.css') ?: 1;
?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($fullTitle) ?></title>
  <meta name="description" content="<?= e($description) ?>">
<?php if (!$site['launched']): ?>
  <meta name="robots" content="noindex, nofollow"><!-- until launch: see 'launched' in includes/config.php -->
<?php endif; ?>
  <link rel="canonical" href="<?= e($canonical) ?>">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="<?= e($site['name']) ?>">
  <meta property="og:title" content="<?= e($fullTitle) ?>">
  <meta property="og:description" content="<?= e($description) ?>">
  <meta property="og:url" content="<?= e($canonical) ?>">
  <meta property="og:locale" content="en_GB">
  <meta property="og:image" content="<?= e($shareImage) ?>">
  <meta property="og:image:alt" content="<?= e($shareImageAlt) ?>">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= e($fullTitle) ?>">
  <meta name="twitter:description" content="<?= e($description) ?>">
  <meta name="twitter:image" content="<?= e($shareImage) ?>">
  <link rel="preload" href="/fonts/baskervville.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="/fonts/dm-sans.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="stylesheet" href="/css/style.css?v=<?= e($cssVersion) ?>">
  <link rel="icon" href="/images/favicon.svg" type="image/svg+xml">
  <link rel="icon" href="/images/favicon-32.png" type="image/png" sizes="32x32">
  <link rel="apple-touch-icon" href="/images/apple-touch-icon.png">
  <meta name="theme-color" content="#471D26">
<?php if (current_path() === '/') { include __DIR__ . '/structured-data.php'; } ?>
  <script src="/js/site.js" defer></script>
</head>
<body<?= $overPhoto ? ' class="over-photo"' : '' ?>>
<a class="skip-link" href="#main">Skip to content</a>
<?php if ($site['announcement']['text'] !== ''): ?>
<div class="announcement" id="announcement">
  <div class="wrap">
    <p><?= announcement_html($site['announcement']) ?></p>
    <button type="button" class="announcement-close" aria-label="Close announcement" hidden>&times;</button>
  </div>
</div>
<?php endif; ?>
<?php include __DIR__ . '/header.php'; ?>
<main id="main">
