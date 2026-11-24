---
# HOW TO ADD A GUIDE POST
# 1. Copy this file and rename the copy, e.g. a-slow-weekend.md
#    (lower case, numbers and hyphens only; this becomes the web address:
#    /the-guide/a-slow-weekend)
# 2. Fill in the settings below, then write the post under the second ---
# 3. Commit. The Guide page and the sitemap update themselves.
# Lines starting with # are notes and are ignored.

title: The headline of the post
# Newest posts appear first on The Guide
date: 2026-11-21
# One of: get-to-know, local-area, news (set in includes/config.php)
category: local-area
# One or two sentences, used on The Guide page and for Google
summary: A short summary of the post.
# The photo on The Guide page (put the file in /images/guide/)
image: /images/guide/my-photo.jpg
image_alt: Describe the photo for people who can't see it
# true = only visible when previewing on your own computer
draft: true
---

The opening paragraphs go here, before the first heading. They're shown
centred under the title.

#### Friday
## Arrive and *settle in*

A small heading (####) straight above a heading (##) becomes the little
label above it. Each ## heading starts a new section.

![Describe the photo](/images/guide/friday.jpg)

The first photo in a section sits beside the text; sections take turns
putting it on the left and the right.

## A section with a row of photos

Photos on lines next to each other (no blank line between them) make a
row across the page:

![First photo](/images/guide/one.jpg)
![Second photo](/images/guide/two.jpg)
![Third photo](/images/guide/three.jpg)

## A section with only words

A section with no photo is centred. A [link to another site](https://example.com)
opens in a new tab.
