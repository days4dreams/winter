<?php
/**
 * Structured data for Google: describes Winter's Nook as a place to stay,
 * so search results can show its details. Shown on the homepage only.
 * The facts come from includes/config.php and the list below.
 * Test it at https://search.google.com/test/rich-results
 */
$amenities = ['Free Wi-Fi', 'Guest parking permit', 'Kitchen', 'Washing machine', 'Shower',
    'Electric panel heating', 'King-size bed', 'Built-in wardrobes', 'Hairdryer', 'Iron', 'Board games and books'];

$data = [
    '@context' => 'https://schema.org',
    '@type' => 'LodgingBusiness',
    'name' => $site['name'],
    'description' => $site['description'],
    'url' => $site['url'] . '/',
    'image' => [$site['url'] . $site['default_image']],
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => $site['address']['town'],
        'addressRegion' => $site['address']['county'],
        'postalCode' => $site['address']['postcode'],
        'addressCountry' => $site['address']['country'],
    ],
    'numberOfRooms' => 1,
    'maximumAttendeeCapacity' => 2,
    'smokingAllowed' => false,
    'checkinTime' => '14:00',
    'checkoutTime' => '11:00',
    'amenityFeature' => array_map(function ($name) {
        return ['@type' => 'LocationFeatureSpecification', 'name' => $name, 'value' => true];
    }, $amenities),
    'sameAs' => $site['also_listed_at'],
];
?>
  <script type="application/ld+json"><?= json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_TAG) ?></script>
