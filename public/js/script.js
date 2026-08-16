document.addEventListener('DOMContentLoaded', () => {

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const isCoarsePointer = window.matchMedia('(pointer: coarse)').matches;

  /* ---------------------------------------------------
     INTRO — let people skip the reveal with a click/tap
     --------------------------------------------------- */
  const introOverlay = document.getElementById('introOverlay');
  const introTitleEl = document.querySelector('.intro-title');
  const caseEl = document.querySelector('.case');
  let dissolveFired = false;

  // Spawns a burst of small marks right from "CASE FILE"'s own position,
  // flying outward and fading — timed to fire exactly when the text
  // itself starts dissolving (see .intro-mark-out's 1.75s delay in CSS),
  // so it reads as the letters breaking apart into the ambient field
  // rather than just fading in place.
  function burstIntroParticles() {
    if (dissolveFired || !introTitleEl || reduceMotion) return;
    dissolveFired = true;

    const rect = introTitleEl.getBoundingClientRect();
    if (!rect.width) return; // already hidden/skipped before it ever rendered
    const count = 26;

    for (let i = 0; i < count; i++) {
      const el = document.createElement('div');
      el.className = 'intro-particle';

      const startX = rect.left + Math.random() * rect.width;
      const startY = rect.top + rect.height / 2 + (Math.random() - 0.5) * rect.height * 0.6;

      // Fly outward in a loose radial burst with a slight upward drift,
      // so it feels like the letters are lifting off and scattering.
      const angle = Math.random() * Math.PI * 2;
      const dist = 60 + Math.random() * 150;
      const dx = Math.cos(angle) * dist;
      const dy = Math.sin(angle) * dist - 24;

      const size = 3 + Math.random() * 5;
      const dur = (0.6 + Math.random() * 0.5).toFixed(2) + 's';
      const delay = (Math.random() * 0.15).toFixed(2) + 's';

      el.style.left = startX + 'px';
      el.style.top = startY + 'px';
      el.style.width = size + 'px';
      el.style.height = size + 'px';
      el.style.setProperty('--pdx', dx.toFixed(1) + 'px');
      el.style.setProperty('--pdy', dy.toFixed(1) + 'px');
      el.style.setProperty('--pdur', dur);
      el.style.setProperty('--pdelay', delay);
      if (Math.random() > 0.6) el.style.background = 'var(--accent-green)';

      document.body.appendChild(el);
      setTimeout(() => el.remove(), 1400);
    }
  }

  // Fire on the natural timeline (matches the CSS dissolve delay)...
  setTimeout(burstIntroParticles, 1750);

  function dismissIntro() {
    if (!introOverlay) return;
    burstIntroParticles(); // ...or immediately if the person skips early
    introOverlay.classList.add('is-hidden');
    caseEl?.classList.add('is-revealed');
  }

  introOverlay?.addEventListener('click', dismissIntro);
  // Safety net: guarantee the overlay never blocks the page even if a
  // browser skips animations for some reason.
  window.addEventListener('load', () => setTimeout(dismissIntro, 2650));

  // Safety net #2: some desktop browsers restore the page from the
  // back/forward cache instead of doing a fresh load (common when
  // navigating back from the admin/login pages). In that case the intro
  // never re-runs and the folder just appears "stuck" pre-revealed or
  // mid-animation. Forcing a real reload on a bfcache restore makes the
  // intro behave the same everywhere, desktop included.
  window.addEventListener('pageshow', (e) => {
    if (e.persisted) location.reload();
  });

  /* ---------------------------------------------------
     BACKGROUND FIELD — sparse, floating minimal marks
     --------------------------------------------------- */
  const bgField = document.getElementById('bgField');

  const MARKS = [
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="9"/></svg>',
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="1.4" fill="currentColor" stroke="none"/></svg>',
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="4" y="4" width="16" height="16" rx="1"/></svg>',
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="5" y="5" width="14" height="14" rx="1" transform="rotate(45 12 12)"/></svg>',
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><line x1="5" y1="12" x2="19" y2="12"/><line x1="12" y1="5" x2="12" y2="19"/></svg>',
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><line x1="6" y1="6" x2="18" y2="18"/><line x1="18" y1="6" x2="6" y2="18"/></svg>',
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><line x1="7" y1="17" x2="17" y2="7"/></svg>',
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="9"/><line x1="7" y1="7" x2="17" y2="17"/></svg>'
  ];

  // Fewer marks on small / short viewports so the field stays minimal
  // and never crowds the folder or forces layout overflow.
  function markCount() {
    const w = window.innerWidth;
    if (w < 420) return 18;
    if (w < 700) return 26;
    if (w < 1100) return 38;
    return 50;
  }

  function buildBackgroundField() {
    if (!bgField) return;
    bgField.innerHTML = '';
    const count = markCount();
    const used = [];

    for (let i = 0; i < count; i++) {
      const el = document.createElement('div');
      el.className = 'bg-icon';
      el.innerHTML = MARKS[Math.floor(Math.random() * MARKS.length)];

      // Loose grid placement (avoids a dead-center cluster) plus jitter,
      // so marks stay spaced out at any screen size.
      const cols = 6, rows = 5;
      let col, row, key;
      let tries = 0;
      do {
        col = Math.floor(Math.random() * cols);
        row = Math.floor(Math.random() * rows);
        key = col + '-' + row;
        tries++;
      } while (used.includes(key) && tries < 20);
      used.push(key);

      const jitterX = (Math.random() - 0.5) * (100 / cols) * 0.7;
      const jitterY = (Math.random() - 0.5) * (100 / rows) * 0.7;
      const left = (col + 0.5) * (100 / cols) + jitterX;
      const top = (row + 0.5) * (100 / rows) + jitterY;

      const size = 20 + Math.random() * 30; // 20–50px
      const depth = (0.4 + Math.random() * 1.6).toFixed(2); // parallax weight
      const dur = (5 + Math.random() * 6).toFixed(1) + 's'; // faster, still varied pace
      const delay = (Math.random() * -11).toFixed(1) + 's'; // desync start points
      const rot = Math.floor(Math.random() * 40 - 20) + 'deg';

      // Each mark drifts toward its own random direction/distance so the
      // field doesn't move as one uniform block.
      const angle = Math.random() * Math.PI * 2;
      const dist = 18 + Math.random() * 22; // 18–40px of travel
      const fx = (Math.cos(angle) * dist).toFixed(1) + 'px';
      const fy = (Math.sin(angle) * dist).toFixed(1) + 'px';

      el.style.left = left + '%';
      el.style.top = top + '%';
      el.style.width = size + 'px';
      el.style.height = size + 'px';
      el.style.setProperty('--depth', depth);
      el.style.setProperty('--dur', dur);
      el.style.setProperty('--delay', delay);
      el.style.setProperty('--rot', rot);
      el.style.setProperty('--fx', fx);
      el.style.setProperty('--fy', fy);
      if (Math.random() > 0.7) el.style.color = 'var(--accent-green)';

      bgField.appendChild(el);
    }
  }

  buildBackgroundField();

  let resizeTimer;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(buildBackgroundField, 300);
  });

  /* ---------------------------------------------------
     MOUSE PARALLAX — background marks drift with the
     cursor; the folder gets a soft cursor-tracked sheen
     --------------------------------------------------- */
  const folderBody = document.querySelector('.folder-body');
  let rafId = null;

  if (!reduceMotion && !isCoarsePointer) {
    document.addEventListener('mousemove', (e) => {
      if (rafId) return;
      rafId = requestAnimationFrame(() => {
        const nx = (e.clientX / window.innerWidth - 0.5) * 2;   // -1..1
        const ny = (e.clientY / window.innerHeight - 0.5) * 2;  // -1..1

        document.querySelectorAll('.bg-icon').forEach((icon) => {
          const depth = parseFloat(icon.style.getPropertyValue('--depth')) || 1;
          icon.style.setProperty('--px', (nx * depth * 14).toFixed(1) + 'px');
          icon.style.setProperty('--py', (ny * depth * 14).toFixed(1) + 'px');
        });

        rafId = null;
      });
    });
  }

  if (folderBody) {
    folderBody.addEventListener('mousemove', (e) => {
      const rect = folderBody.getBoundingClientRect();
      const mx = ((e.clientX - rect.left) / rect.width) * 100;
      const my = ((e.clientY - rect.top) / rect.height) * 100;
      folderBody.style.setProperty('--mx', mx + '%');
      folderBody.style.setProperty('--my', my + '%');
    });
  }

  const tabs = Array.from(document.querySelectorAll('.tab'));
  const panels = Array.from(document.querySelectorAll('.panel'));

  function activate(index) {
    tabs.forEach((tab, i) => {
      const isActive = i === index;
      tab.classList.toggle('active', isActive);
      tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
      tab.tabIndex = isActive ? 0 : -1;
    });

    panels.forEach((panel, i) => {
      const isActive = i === index;
      panel.classList.toggle('active', isActive);
      panel.hidden = !isActive;
      if (isActive) panel.querySelector('.panel-scroll')?.scrollTo(0, 0);
    });
  }

  tabs.forEach((tab, i) => {
    tab.addEventListener('click', () => activate(i));

    tab.addEventListener('keydown', (e) => {
      let newIndex = null;
      if (e.key === 'ArrowRight') newIndex = (i + 1) % tabs.length;
      if (e.key === 'ArrowLeft') newIndex = (i - 1 + tabs.length) % tabs.length;
      if (newIndex !== null) {
        e.preventDefault();
        tabs[newIndex].focus();
        activate(newIndex);
      }
    });
  });

  // Start on the first tab
  activate(0);

  /* ---------------------------------------------------
     SCROLL-TO-ADVANCE — scrolling past the end (or start)
     of a panel's content moves to the next (or previous)
     tab. Tab buttons and arrow-key navigation above still
     work exactly as before.
     --------------------------------------------------- */
  let wheelLock = false;
  const WHEEL_COOLDOWN = 650; // ms — prevents a single trackpad swipe from skipping multiple tabs

  function handlePanelWheel(e) {
    const activeIndex = tabs.findIndex((t) => t.classList.contains('active'));
    if (activeIndex === -1) return;

    const scrollEl = panels[activeIndex]?.querySelector('.panel-scroll');
    if (!scrollEl) return;

    const canScroll = scrollEl.scrollHeight > scrollEl.clientHeight + 1;
    const atTop = scrollEl.scrollTop <= 0;
    const atBottom = Math.ceil(scrollEl.scrollTop + scrollEl.clientHeight) >= scrollEl.scrollHeight;

    const scrollingDown = e.deltaY > 0;
    const scrollingUp = e.deltaY < 0;

    const shouldAdvance = scrollingDown && (!canScroll || atBottom);
    const shouldGoBack = scrollingUp && (!canScroll || atTop);

    if (!shouldAdvance && !shouldGoBack) return; // let the panel scroll normally

    if (wheelLock) {
      e.preventDefault();
      return;
    }

    e.preventDefault();
    const nextIndex = shouldAdvance
      ? (activeIndex + 1) % tabs.length
      : (activeIndex - 1 + tabs.length) % tabs.length;

    activate(nextIndex);
    tabs[nextIndex].focus();

    wheelLock = true;
    setTimeout(() => { wheelLock = false; }, WHEEL_COOLDOWN);
  }

  panels.forEach((panel) => {
    const scrollEl = panel.querySelector('.panel-scroll');
    scrollEl?.addEventListener('wheel', handlePanelWheel, { passive: false });
  });
});