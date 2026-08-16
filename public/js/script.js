document.addEventListener('DOMContentLoaded', () => {

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const isCoarsePointer = window.matchMedia('(pointer: coarse)').matches;

  /* ---------------------------------------------------
     INTRO — let people skip the reveal with a click/tap
     --------------------------------------------------- */
  const introOverlay = document.getElementById('introOverlay');
  const caseEl = document.querySelector('.case');

  function dismissIntro() {
    if (!introOverlay) return;
    introOverlay.classList.add('is-hidden');
    caseEl?.classList.add('is-revealed');
  }

  introOverlay?.addEventListener('click', dismissIntro);
  // Safety net: guarantee the overlay never blocks the page even if a
  // browser skips animations for some reason.
  window.addEventListener('load', () => setTimeout(dismissIntro, 2650));

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
    if (w < 420) return 10;
    if (w < 700) return 15;
    if (w < 1100) return 21;
    return 28;
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
      const dur = (10 + Math.random() * 12).toFixed(1) + 's'; // slow, varied pace
      const delay = (Math.random() * -18).toFixed(1) + 's'; // desync start points
      const rot = Math.floor(Math.random() * 40 - 20) + 'deg';

      // Each mark drifts toward its own random direction/distance so the
      // field doesn't move as one uniform block.
      const angle = Math.random() * Math.PI * 2;
      const dist = 12 + Math.random() * 16; // 12–28px of travel
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
});
