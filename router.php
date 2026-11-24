<?php
/**
 * Local preview router: NOT used on the live server.
 *
 * PHP's built-in server doesn't read .htaccess, so this file copies the
 * important rules from it, letting you preview the site as it will behave live:
 *
 *     php -S localhost:8000 router.php
 *
 * then open http://localhost:8000 in your browser.
 */

$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$root = __DIR__;

// Never serve private folders or hidden files (same as .htaccess).
if (preg_match('#^/(includes|content|dev)(/|$)#', $path) || preg_match('#/\.#', $path)) {
    http_response_code(404);
    require $root . '/404.php';
    return true;
}

// Google Search Console's verification file is served as it is (same as .htaccess).
if (preg_match('#^/google[0-9a-f]+\.html$#', $path) && is_file($root . $path)) {
    return false;
}

// Old addresses ending in .html or .php redirect to the clean address.
if (preg_match('#^/(.+?)\.(html|php)$#', $path, $m) && $path !== '/router.php') {
    header('Location: ' . (($m[1] === 'index') ? '/' : '/' . $m[1]), true, 301);
    return true;
}

// Real files (CSS, images, fonts, JS) are served as they are.
if ($path !== '/' && is_file($root . $path)) {
    return false;
}

// The sitemap is built by sitemap.php.
if ($path === '/sitemap.xml') {
    require $root . '/sitemap.php';
    return true;
}

// Guide posts (same as .htaccess).
if (preg_match('#^/the-guide/([a-z0-9-]+)/?$#', $path, $m)) {
    $_GET['post'] = $m[1];
    require $root . '/the-guide.php';
    return true;
}

// Clean addresses: /faqs -> faqs.php, / -> index.php
$page = ($path === '/') ? 'index' : trim($path, '/');
if (preg_match('#^[a-z0-9-]+$#', $page) && is_file("$root/$page.php")) {
    require "$root/$page.php";
    return true;
}

http_response_code(404);
require $root . '/404.php';
return true;
