# Winter's Nook

The website for Winter's Nook, by Staying Season, at
**https://winter.stayingseason.com**.

Made from the Autumn House site (days4dreams/autumn): the same code, with
Winter's Nook's settings, colours, logo and wording.

Plain PHP and HTML: no database, no framework. Fonts and scripts are self-hosted.

## Where things live

| To change… | Edit this |
| --- | --- |
| Wording on Home, The Flat, Longer Stays, Enquire, Terms | The page's own file: `index.php`, `the-flat.php`, `longer-stays.php`, `enquire.php`, `terms.php`. The text is plain HTML. |
| Wording at the top of the FAQs and The Guide pages | `faqs.php`, `the-guide.php` |
| **FAQs** (every question, everywhere) | `content/faqs.md`: one file; instructions at its top |
| **Guide posts** | `content/guide/`: one file per post; copy `_template.md` to start a new one |
| Guide categories (Get to know, Local area, News) | `$guideCategories` in `includes/config.php` |
| Site name, Book now link, Instagram, announcement bar, menu | `includes/config.php` |
| Colours and fonts | The top of `css/style.css` |
| Header, footer, "Ready to stay?" band, review, Instagram row | `includes/header.php`, `footer.php`, `callout.php`, `review.php`, `instagram.php` |
| Logos and hand-drawn illustrations | `images/logos/`, `images/illustrations/` (SVG files; they take their colour from the page) |

### Showing FAQs on a page

In `content/faqs.md`, add `show on: long` under a question. Any page with
the line `<?= faq_list('long') ?>` then shows it. Longer Stays, The Flat
and Enquire already have one (`long`, `flat`, `enquire`).

### Photos

Every photo is the same placeholder for now. To use a real photo, put it in
`images/` (lower case, hyphens, no spaces, e.g. `images/photos/kitchen.jpg`)
and change the line, for example from

    <?= placeholder('', '', '4/5') ?>

to

    <?= content_image('/images/photos/kitchen.jpg', 'The kitchen', '', '4/5') ?>

The second part describes the photo for people who can't see it. `'4/5'` is
the shape (width/height); leave it as `''` to use the photo's own shape.

## Previewing on your computer

In Terminal, in this folder:

    php -S localhost:8000 router.php

then open http://localhost:8000. Draft Guide posts show up here, but not on
the live site.

## Publishing

Every change merged into `main` is checked and uploaded automatically by
GitHub Actions (`.github/workflows/deploy.yml`). Pull requests are only
checked. You'll see a green tick or a red cross next to each one in GitHub.

1. In **GitHub Desktop**, create a branch (Branch → New branch), make your
   changes, commit them, and click **Publish branch**.
2. Click **Create Pull Request**. GitHub checks every page loads with no errors.
3. When it's green, **Merge** it on github.com. The site updates a minute or two later.

The upload only sends files that changed, only deletes files it uploaded
itself, and refuses to upload anywhere except this site's own folder, so it
can never touch anything else on the hosting account.

**Settings it needs** (github.com → this repo → Settings → Secrets and variables → Actions):

| Name | Kind | Value |
| --- | --- | --- |
| `SFTP_HOST`, `SFTP_USER`, `SFTP_PASSWORD`, `SFTP_KNOWN_HOSTS` | Secrets | The Krystal login and server identity for the stayingseason.com package |
| `REMOTE_DIR` | Variable | `winter.stayingseason.com` |
| `ENQUIRY_EMAIL` | Variable | Where the Enquire form sends messages. Kept here, not in the code. |

**Rolling back:** Actions tab → *Deploy to Krystal* → *Run workflow*, and paste
the commit ID of the version you want live.

## Launch day checklist

1. In `includes/config.php`, change `'launched' => false` to `true`
   (this lets Google list the site), commit and merge.
2. In Google Search Console (search.google.com/search-console), add the
   property `https://winter.stayingseason.com`, verify it (the HTML tag
   method: send Claude the tag and it goes in `includes/head.php`), then
   submit the sitemap: `https://winter.stayingseason.com/sitemap.xml`.
3. Test the homepage at https://search.google.com/test/rich-results
   (it should find a "Local business" / lodging item).
4. Paste a page link into WhatsApp or Facebook to check the preview photo.
5. When the Google Business Profile is live, add its link to
   `also_listed_at` in `includes/config.php` (and the website link to the profile).

## Photos

Most photos point at a file in `images/photos/` (e.g. `/images/photos/kitchen.jpg`).
Until that file exists the placeholder shows, so adding a photo with the
right name makes it appear without touching the page.

## Made from Autumn House

Fixes to the shared parts (CSS, includes/, publishing) can be copied
between the two repositories.
