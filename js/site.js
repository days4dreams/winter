/*
 * Small extras. Every page works without this file; it only adds:
 *  - the × button that hides the announcement bar (remembered for this visit)
 *  - arrow buttons for the numbered slider on the Home page
 *  - closing the phone menu with Escape or a tap outside it
 *  - sections fading up gently as you scroll to them
 */
(function () {
  // Announcement bar: show the close button, and keep it closed after closing.
  var bar = document.getElementById('announcement');
  if (bar) {
    var key = 'announcement-closed:' + bar.textContent.trim();
    try { if (sessionStorage.getItem(key)) bar.hidden = true; } catch (e) {}
    var close = bar.querySelector('.announcement-close');
    close.hidden = false;
    close.addEventListener('click', function () {
      bar.hidden = true;
      try { sessionStorage.setItem(key, '1'); } catch (e) {}
    });
  }

  // Slider arrows: move one slide left or right.
  document.querySelectorAll('[data-slider]').forEach(function (slider) {
    var arrows = document.querySelector('[data-slider-arrows="' + slider.id + '"]');
    if (!arrows) return;
    arrows.hidden = false;
    arrows.querySelectorAll('button').forEach(function (button) {
      button.addEventListener('click', function () {
        var slide = slider.querySelector('.slide');
        var step = slide ? slide.getBoundingClientRect().width + 32 : 300;
        slider.scrollBy({ left: step * Number(button.dataset.direction), behavior: 'smooth' });
      });
    });
  });

  // Fade sections up as they come into view. Only things below the first
  // screen are hidden first, and only if the visitor hasn't asked for less motion.
  var calm = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if ('IntersectionObserver' in window && !calm) {
    var watcher = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          watcher.unobserve(entry.target);
        }
      });
    }, { rootMargin: '0px 0px -8% 0px' });
    var items = document.querySelectorAll(
      'main .band > .wrap > *, .post-section, .instagram-row'
    );
    items.forEach(function (el) {
      if (el.getBoundingClientRect().top > window.innerHeight) {
        el.classList.add('reveal');
        watcher.observe(el);
      }
    });
  }

  // A link to a question (e.g. #faq-how-much-does-it-cost) opens its answer.
  function openFaqFromHash() {
    var id = decodeURIComponent(location.hash.slice(1));
    var target = id && document.getElementById(id);
    if (target && target.tagName === 'DETAILS') {
      target.open = true;
      target.classList.remove('reveal');
      target.classList.add('is-visible');
    }
  }
  openFaqFromHash();
  window.addEventListener('hashchange', openFaqFromHash);

  // Phone menu: close with Escape, or when tapping anywhere else.
  var menu = document.querySelector('.menu-toggle');
  if (menu) {
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && menu.open) { menu.open = false; menu.querySelector('summary').focus(); }
    });
    document.addEventListener('click', function (e) {
      if (menu.open && !menu.contains(e.target)) menu.open = false;
    });
  }
})();
