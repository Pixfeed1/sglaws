/**
 * S-G Avocat — main.js
 * Faithful reproduction of original animations
 */

/* Lenis smooth scroll */
const lenis = new Lenis({
  duration: 1.2,
  easing: t => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
  smoothWheel: true,
});
lenis.on('scroll', ScrollTrigger.update);
gsap.ticker.add(t => lenis.raf(t * 1000));
gsap.ticker.lagSmoothing(0);

/* Loader (homepage only) */
const loader = document.getElementById('loader');
if (loader) {
  const tl = gsap.timeline({
    onComplete: () => { loader.style.pointerEvents = 'none'; animatePage(); }
  });
  tl.to('.loader-monogram', { opacity: 1, duration: 0.6, ease: 'power2.out' })
    .to('.loader-bar', { scaleX: 1, duration: 0.9, ease: 'power3.inOut' }, '-=0.2')
    .to('.loader-monogram', { opacity: 0, y: -15, duration: 0.4 }, '+=0.2')
    .to('.loader-bar', { scaleX: 0, transformOrigin: 'right', duration: 0.3 }, '-=0.2')
    .to(loader, { yPercent: -100, duration: 0.7, ease: 'power3.inOut' });
  /* Safety timeout */
  setTimeout(() => {
    if (loader.parentNode) {
      loader.style.opacity = '0';
      loader.style.pointerEvents = 'none';
      setTimeout(() => loader.remove(), 500);
      animatePage();
    }
  }, 5000);
} else {
  /* Sub-pages: run animations on load */
  window.addEventListener('load', animateSubPage);
}

/* Nav — header scroll effect */
const header = document.getElementById('header');
const burger = document.getElementById('burger');
const mobileNav = document.getElementById('mobileNav');

if (header) {
  window.addEventListener('scroll', () => {
    header.classList.toggle('scrolled', window.scrollY > 60);
  });
}

if (burger && mobileNav) {
  burger.addEventListener('click', () => {
    burger.classList.toggle('active');
    mobileNav.classList.toggle('open');
    if (header) header.classList.toggle('menu-open');
    document.body.style.overflow = mobileNav.classList.contains('open') ? 'hidden' : '';
  });
}

document.querySelectorAll('.mob-link').forEach(l => {
  l.addEventListener('click', () => {
    if (burger) burger.classList.remove('active');
    if (mobileNav) mobileNav.classList.remove('open');
    if (header) header.classList.remove('menu-open');
    document.body.style.overflow = '';
  });
});

/* Smooth anchor links */
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const target = document.querySelector(a.getAttribute('href'));
    if (target) {
      e.preventDefault();
      lenis.scrollTo(target, { offset: -80 });
    }
  });
});

/* =============================================
   HOMEPAGE ANIMATIONS (after loader)
============================================= */
function animatePage() {
  /* Hero line reveals */
  gsap.to('.hero .lr span', {
    y: 0, duration: 1.1, ease: 'power3.out', stagger: 0.12, delay: 0.1
  });
  gsap.to('.hero .r', {
    opacity: 1, y: 0, duration: 0.9, ease: 'power2.out', delay: 0.5
  });

  /* Generic .r reveal */
  document.querySelectorAll('.r:not(.hero .r)').forEach(el => {
    gsap.to(el, {
      scrollTrigger: { trigger: el, start: 'top 88%' },
      opacity: 1, y: 0, duration: 0.8, ease: 'power2.out'
    });
  });

  /* Line reveals below hero */
  document.querySelectorAll('section:not(.hero) .lr span').forEach(el => {
    gsap.to(el, {
      scrollTrigger: { trigger: el.closest('.lr'), start: 'top 88%' },
      y: 0, duration: 1, ease: 'power3.out'
    });
  });

  /* Values row stagger */
  const vw = document.querySelectorAll('.values-row__word');
  if (vw.length) gsap.to(vw, {
    scrollTrigger: { trigger: '.values-row', start: 'top 85%' },
    opacity: 1, y: 0, duration: 0.6, stagger: 0.08, ease: 'power2.out'
  });

  /* Expertise items stagger */
  const ei = document.querySelectorAll('.expertise__item');
  if (ei.length) gsap.to(ei, {
    scrollTrigger: { trigger: '.expertise__list', start: 'top 82%' },
    opacity: 1, y: 0, duration: 0.6, stagger: 0.07, ease: 'power2.out'
  });

  /* Publication items stagger */
  const pi = document.querySelectorAll('.pub-item');
  if (pi.length) gsap.to(pi, {
    scrollTrigger: { trigger: '.publications__list', start: 'top 85%' },
    opacity: 1, y: 0, duration: 0.6, stagger: 0.07, ease: 'power2.out'
  });

  /* Hero media parallax */
  const heroMedia = document.querySelector('.hero__media video, .hero__media img');
  if (heroMedia) {
    gsap.to(heroMedia, {
      scrollTrigger: { trigger: '.hero', start: 'top top', end: 'bottom top', scrub: 1 },
      y: 120, scale: 1.06, ease: 'none'
    });
  }

  ScrollTrigger.refresh();
}

/* =============================================
   SUB-PAGE ANIMATIONS (no loader)
============================================= */
function animateSubPage() {
  /* Page header line reveals */
  gsap.to('.page-header .lr span', {
    y: 0, duration: 1, ease: 'power3.out', stagger: 0.12, delay: 0.15
  });

  /* Reveal .r elements */
  document.querySelectorAll('.r').forEach(el => {
    const rect = el.getBoundingClientRect();
    if (rect.top < window.innerHeight) {
      gsap.to(el, {
        opacity: 1, y: 0, duration: 0.8, ease: 'power2.out',
        delay: 0.2 + (rect.top / window.innerHeight) * 0.4
      });
    } else {
      gsap.to(el, {
        scrollTrigger: { trigger: el, start: 'top 88%' },
        opacity: 1, y: 0, duration: 0.8, ease: 'power2.out'
      });
    }
  });

  /* Line reveals below fold */
  document.querySelectorAll('.lr span').forEach(el => {
    const parent = el.closest('.lr');
    if (parent && !parent.closest('.page-header')) {
      gsap.to(el, {
        scrollTrigger: { trigger: parent, start: 'top 88%' },
        y: 0, duration: 1, ease: 'power3.out'
      });
    }
  });

  ScrollTrigger.refresh();
}

/* =============================================
   CONTACT FORM (AJAX)
============================================= */
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('sg-contact-form');
  if (!form || typeof sgData === 'undefined') return;

  const btn = form.querySelector('.form__submit, .lp-form__submit');
  if (!btn) return;

  form.addEventListener('submit', (e) => {
    e.preventDefault();

    /* Honeypot check */
    const hp = form.querySelector('[name="sg_hp"]');
    if (hp && hp.value) return;

    /* Collect form data */
    const fields = {};
    form.querySelectorAll('input, textarea, select').forEach(el => {
      if (el.name && el.name !== 'sg_hp') fields[el.name] = el.value;
    });

    btn.textContent = 'Envoi en cours...';
    btn.disabled = true;

    /* 1. Save to WP (Messages CPT) — always */
    const wpData = new FormData();
    wpData.append('action', 'sg_contact');
    wpData.append('nonce', sgData.nonce);
    for (const [k, v] of Object.entries(fields)) wpData.append(k, v);
    const wpSave = fetch(sgData.ajaxUrl, { method: 'POST', body: wpData }).then(r => r.json());

    /* 2. Send via Formspree — if configured */
    let fspSend;
    if (sgData.formspree) {
      fspSend = fetch(sgData.formspree, {
        method: 'POST',
        headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
        body: JSON.stringify(fields),
      }).then(r => r.ok);
    } else {
      fspSend = Promise.resolve(true);
    }

    /* Wait for both */
    Promise.all([wpSave, fspSend])
      .then(([wpRes]) => {
        btn.textContent = 'Message envoyé ✓';
        form.querySelectorAll('input:not([type="hidden"]), textarea, select').forEach(el => el.value = '');
        setTimeout(() => { btn.textContent = 'Envoyer'; btn.disabled = false; }, 3000);
      })
      .catch(() => {
        btn.textContent = 'Erreur — Réessayer';
        btn.disabled = false;
      });
  });
});

/* =============================================
   SOMMAIRE — suivi de lecture
   Met en avant l'entrée correspondant à la section
   à l'écran. Sans IntersectionObserver, le sommaire
   reste un simple jeu de liens : rien ne casse.
============================================= */
(function () {
  var liens = Array.prototype.slice.call(
    document.querySelectorAll('.article-layout .sg-toc__list a')
  );
  if (!liens.length || !('IntersectionObserver' in window)) return;

  var cibles = {};
  liens.forEach(function (a) {
    var href = a.getAttribute('href') || '';
    if (href.charAt(0) !== '#' || href.length < 2) return;
    var titre = document.getElementById(href.slice(1));
    if (titre) cibles[titre.id] = a.parentNode;
  });

  var observateur = new IntersectionObserver(function (entrees) {
    entrees.forEach(function (e) {
      if (!e.isIntersecting) return;
      liens.forEach(function (a) { a.parentNode.classList.remove('is-current'); });
      if (cibles[e.target.id]) cibles[e.target.id].classList.add('is-current');
    });
  }, { rootMargin: '-120px 0px -70% 0px' });

  Object.keys(cibles).forEach(function (id) {
    observateur.observe(document.getElementById(id));
  });
})();
