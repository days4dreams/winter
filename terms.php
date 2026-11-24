<?php
/*
 * Terms. A plain page of text: edit the wording straight in below.
 * Headings are <h2>, paragraphs <p>, lists <ul><li>.
 */
$title = 'Terms';
$description = "Booking terms for Winter's Nook: check-in times, payment, cancellations, the parking permit deposit and house rules.";
$ogImage = '/images/photos/living-room.jpg';
$ogImageAlt = "The living room at Winter's Nook";
require __DIR__ . '/includes/content.php';
require __DIR__ . '/includes/head.php';
?>

<header class="wrap page-head narrow">
  <h1>Terms</h1>
</header>

<section class="band" style="padding-top: 0">
  <div class="wrap narrow prose">
    <p>These terms apply to every booking made directly with Winter's Nook. By making a reservation, you agree to them. If anything is unclear, please <a href="/enquire">get in touch</a> before you book.</p>

    <h2>Booking</h2>
    <p>To book, please give us accurate details, including your name, your dates and the number of guests. Your booking is confirmed once you receive a confirmation email from us. If it doesn't arrive, please <a href="/enquire">contact us</a>.</p>

    <h2>Check-in and check-out</h2>
    <ul>
      <li>Check-in is from 14:00.</li>
      <li>Check-out is by 11:00.</li>
    </ul>
    <p>This gives us time to clean and prepare the flat for the next guests.</p>

    <h2>Payment</h2>
    <p>We take 50% of the total when you book, and the remaining 50% 21 days before you arrive. The full amount, any extras and the cancellation terms are shown when you book. For longer stays, we'll agree a payment schedule with you.</p>

    <h2>Cancellations and changes</h2>
    <ul>
      <li>Cancel more than 21 days before your arrival and there's no charge.</li>
      <li>Cancel within 21 days of arrival and we keep the 50% paid at booking.</li>
      <li>Non-refundable rates can't be refunded.</li>
      <li>Changes to dates are at our discretion.</li>
      <li>There are no refunds for leaving early or for unused nights.</li>
    </ul>
    <p>Refunds are made to your original payment method within 14 working days. In unforeseen circumstances, such as extreme weather, we may adjust these terms and will tell you promptly.</p>

    <h2>Parking permit</h2>
    <p>If you'd like a council guest parking permit, please ask at least 5 days before you arrive and send us your car's make, model and registration. We take a holding deposit of £80, returned when the permit is left in the flat at check-out. If the permit isn't returned at check-out, even for a few hours, the deposit can't be refunded.</p>

    <h2>During your stay</h2>
    <ul>
      <li>No more than two guests may stay at Winter's Nook at any time.</li>
      <li>Please keep noise down after 22:30, out of respect for our neighbours.</li>
      <li>No parties or events, please.</li>
      <li>Winter's Nook is non-smoking and non-vaping. Smoking indoors may result in a cleaning charge.</li>
      <li>Please run the bathroom extractor fan when showering, and leave the flat as you found it. Any damage will be charged.</li>
      <li>The locked cupboard in the bedroom is private and not part of the let.</li>
    </ul>

    <h2>Pets</h2>
    <p>Sorry, we don't normally allow pets. If you'd like to bring one, <a href="/enquire">drop us a message</a> and we'll see what we can do.</p>

    <h2>Your belongings</h2>
    <p>Please look after your belongings. We can't be held responsible for loss, theft or damage to guests' property, or for disruption beyond our control. If something isn't right during your stay, please tell us straight away so we can put it right.</p>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
