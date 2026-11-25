<?php
/*
 * Enquire: the form that emails you.
 *
 * Where it sends: the ENQUIRY_EMAIL repository variable on GitHub (written to
 * the server by the publishing workflow, so the address isn't in the code).
 * The form's wording and choices are written straight in below: edit them here.
 */
$title = 'Enquire about your stay';
$description = "Get in touch with Lauren and David about staying at Winter's Nook in Gosforth: dates, longer stays, parking permits and more.";
$ogImage = '/images/photos/kitchen.jpg';
$ogImageAlt = "The kitchen at Winter's Nook";
$overPhoto = true;
require __DIR__ . '/includes/content.php';

// The choices in the two drop-down lists. Add or remove lines freely.
$aboutOptions = ['A longer stay (a month or more)', 'A stay of a few weeks', 'A short stay', 'A guest parking permit', 'Something else'];
$heardOptions = ['Instagram', 'Airbnb', 'A friend or family member', 'A search engine', 'Somewhere else'];

$values = ['name' => '', 'email' => '', 'phone' => '', 'about' => '', 'dates' => '', 'guests' => '', 'message' => '', 'heard' => ''];
$errors = [];
$sendFailed = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($values as $key => $_) {
        $value = (string) ($_POST[$key] ?? '');
        if ($key !== 'message') {
            // Every answer but the message is one line. Removing line breaks
            // also means nothing can sneak extra lines into the email's headers.
            $value = preg_replace('/[\r\n\t]+/', ' ', $value);
        }
        // Trim, and cap each answer's length so no one can post a novel.
        $values[$key] = mb_substr(trim($value), 0, $key === 'message' ? 5000 : 200);
    }

    // Spam traps: a hidden field people never see (robots fill it in), and
    // a minimum time between the page loading and the form being sent.
    $isRobot = (($_POST['website'] ?? '') !== '')
        || (time() - (int) ($_POST['started'] ?? 0) < 3);

    if ($values['name'] === '') {
        $errors['name'] = 'Please add your name.';
    }
    if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please check your email address.';
    }
    if ($values['message'] === '') {
        $errors['message'] = 'Please tell us a little about your plans.';
    }
    if ($values['about'] !== '' && !in_array($values['about'], $aboutOptions, true)) {
        $values['about'] = '';
    }
    if ($values['heard'] !== '' && !in_array($values['heard'], $heardOptions, true)) {
        $values['heard'] = '';
    }

    if (!$errors) {
        if ($isRobot) {
            header('Location: /enquire?sent=1#form', true, 303); // look successful, send nothing
            exit;
        }
        if ($site['enquiry_email'] !== '') {
            // The name shown in "Reply-To": letters, numbers, spaces and simple punctuation only.
            $replyName = trim(preg_replace("/[^\\p{L}\\p{N} .'-]/u", '', $values['name']));
            $body = "New enquiry from the {$site['name']} website\n\n"
                . "Name: {$values['name']}\n"
                . "Email: {$values['email']}\n"
                . "Phone: {$values['phone']}\n"
                . "Enquiring about: {$values['about']}\n"
                . "Preferred dates: {$values['dates']}\n"
                . "Number of guests: {$values['guests']}\n"
                . "Heard about us: {$values['heard']}\n\n"
                . "Message:\n{$values['message']}\n";
            $headers = [
                'From' => $site['name'] . ' website <' . $site['mail_from'] . '>',
                'Reply-To' => ($replyName !== '' ? '=?UTF-8?B?' . base64_encode($replyName) . '?= ' : '') . '<' . $values['email'] . '>',
                'Content-Type' => 'text/plain; charset=UTF-8',
            ];
            $subject = '=?UTF-8?B?' . base64_encode('Enquiry from ' . $values['name']) . '?=';
            if (mail($site['enquiry_email'], $subject, $body, $headers)) {
                header('Location: /enquire?sent=1#form', true, 303);
                exit;
            }
        }
        $sendFailed = true;
    }
}
$sent = isset($_GET['sent']);

require __DIR__ . '/includes/head.php';

/** A drop-down list with the chosen answer kept selected. */
function options($choices, $chosen)
{
    $html = '<option value="">Select an option</option>';
    foreach ($choices as $choice) {
        $html .= '<option' . ($choice === $chosen ? ' selected' : '') . '>' . e($choice) . '</option>';
    }
    return $html;
}
/** The error message under a field, if there is one. */
function field_error($errors, $key)
{
    return isset($errors[$key]) ? '<span class="field-error" id="' . $key . '-error">' . e($errors[$key]) . '</span>' : '';
}
?>

<section class="hero hero--short hero--centre">
  <?= content_image('/images/photos/kitchen.jpg', "The kitchen at Winter's Nook", 'band-photo', '') ?>
  <div class="shade-over"></div>
  <div class="wrap stack centre">
    <h1>Get in touch with <em>Winter's Nook</em></h1>
  </div>
</section>

<section class="band torn" id="form">
  <div class="wrap split split--form">
    <div class="stack">
      <h2>Planning a stay at <em>Winter's Nook?</em></h2>
      <p class="lead">We would love to hear from you.</p>
      <p>Tell us your dates and a little about your stay, whether it's a few weeks or a few months, and we'll come back with availability and our best rate. Ask about parking permits or anything else, too.</p>
      <p class="label" style="margin-top: 1rem">Helpful links</p>
      <ul class="helpful-links">
        <li><a href="<?= e($site['booking_url']) ?>"<?= link_attrs($site['booking_url']) ?>>Book your stay</a></li>
        <li><a href="#faq-how-much-does-it-cost">Pricing</a></li>
        <li><a href="/faqs">Read the FAQs</a></li>
        <li><a href="/the-guide">Explore the guide</a></li>
      </ul>
    </div>

    <div>
<?php if ($sent): ?>
      <div class="form-message" role="status">
        <h3>Thank you, your message is on its way.</h3>
        <p>We'll reply as soon as we can, usually within a day or two.</p>
      </div>
<?php else: ?>
<?php if ($sendFailed): ?>
      <p class="form-message form-message--error" role="alert">Sorry, your message couldn't be sent just now. Please try again in a few minutes, or message us on <a href="<?= e($site['instagram_url']) ?>"<?= link_attrs($site['instagram_url']) ?>>Instagram</a>.</p>
<?php elseif ($errors): ?>
      <p class="form-message form-message--error" role="alert">Please check the highlighted answers below.</p>
<?php endif; ?>
      <form class="form" method="post" action="/enquire#form" novalidate>
        <div class="field">
          <label for="name">Full name</label>
          <input id="name" name="name" type="text" autocomplete="name" required value="<?= e($values['name']) ?>"<?= isset($errors['name']) ? ' aria-invalid="true" aria-describedby="name-error"' : '' ?>>
          <?= field_error($errors, 'name') ?>
        </div>
        <div class="field-row">
          <div class="field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" autocomplete="email" required value="<?= e($values['email']) ?>"<?= isset($errors['email']) ? ' aria-invalid="true" aria-describedby="email-error"' : '' ?>>
            <?= field_error($errors, 'email') ?>
          </div>
          <div class="field">
            <label for="phone">Phone <span class="optional">(optional)</span></label>
            <input id="phone" name="phone" type="tel" autocomplete="tel" value="<?= e($values['phone']) ?>">
          </div>
        </div>
        <div class="field">
          <label for="about">What are you enquiring about? <span class="optional">(optional)</span></label>
          <select id="about" name="about"><?= options($aboutOptions, $values['about']) ?></select>
        </div>
        <div class="field-row">
          <div class="field">
            <label for="dates">Preferred dates <span class="optional">(optional)</span></label>
            <input id="dates" name="dates" type="text" placeholder="e.g. 12–15 March" value="<?= e($values['dates']) ?>">
          </div>
          <div class="field">
            <label for="guests">Number of guests <span class="optional">(optional)</span></label>
            <input id="guests" name="guests" type="text" inputmode="numeric" value="<?= e($values['guests']) ?>">
          </div>
        </div>
        <div class="field">
          <label for="message">Tell us a little about your plans</label>
          <textarea id="message" name="message" required<?= isset($errors['message']) ? ' aria-invalid="true" aria-describedby="message-error"' : '' ?>><?= e($values['message']) ?></textarea>
          <?= field_error($errors, 'message') ?>
        </div>
        <div class="field">
          <label for="heard">How did you hear about us? <span class="optional">(optional)</span></label>
          <select id="heard" name="heard"><?= options($heardOptions, $values['heard']) ?></select>
        </div>
        <!-- Spam traps: hidden from people; see the top of this file. -->
        <div class="hp-field" aria-hidden="true"><label for="website">Leave this empty</label><input id="website" name="website" type="text" tabindex="-1" autocomplete="off"></div>
        <input type="hidden" name="started" value="<?= time() ?>">
        <div><button class="btn btn--fill" type="submit">Send</button></div>
      </form>
<?php endif; ?>
    </div>
  </div>
</section>

<?php $enquireFaqs = faq_list('enquire', ['faq-how-much-does-it-cost']); if ($enquireFaqs !== ''): ?>
<section class="band torn torn--flip" style="--band: var(--primary-light)">
  <div class="wrap split" style="align-items: start">
    <div class="stack">
      <p class="label">Before you ask</p>
      <h2>Before you <em>ask</em></h2>
      <p><a href="/faqs">See all FAQs</a></p>
    </div>
    <?= $enquireFaqs ?>
  </div>
</section>
<?php endif; ?>

<?php include __DIR__ . '/includes/callout.php'; ?>
<?php include __DIR__ . '/includes/footer.php'; ?>
