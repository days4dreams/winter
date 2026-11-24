<?php
/* The "page not found" page. It sends a real 404 status so Google knows. */
$title = 'Page not found';
$description = 'The page you were looking for has moved or doesn\'t exist.';
http_response_code(404);
require_once __DIR__ . '/includes/content.php';
require __DIR__ . '/includes/head.php';
?>

<section class="band">
  <div class="wrap narrow stack centre">
    <?= svg('illustrations/03-hare.svg', 'illustration') ?>
    <h1>Page not found</h1>
    <p>Sorry, the page you were looking for has moved or doesn't exist. Try one of the links below, or head back to the <a href="/">homepage</a>.</p>
    <div class="btns"><a class="btn" href="/">Home</a><a class="btn" href="/the-guide">The Guide</a><a class="btn" href="/enquire">Enquire</a></div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
