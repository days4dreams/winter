<?php
/**
 * Builds /sitemap.xml for Google and other search engines.
 * Guide posts are added automatically. The other pages are the menu
 * (includes/config.php) plus the extra pages listed here.
 */
require __DIR__ . '/includes/content.php';

$pages = array_merge(array_keys($menu), ['/terms']);
foreach (guide_posts() as $post) {
    if ($post['draft'] !== true) {
        $pages[] = $post['url'];
    }
}

header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach (array_unique($pages) as $page) {
    echo '  <url><loc>' . e($site['url'] . $page) . "</loc></url>\n";
}
echo "</urlset>\n";
