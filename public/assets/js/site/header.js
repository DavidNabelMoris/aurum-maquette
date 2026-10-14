const SCROLL_THRESHOLD = 24;

export function initHeader() {
  const header = document.querySelector('[data-site-header]');
  if (!header) return;

  const update = () => header.classList.toggle('is-scrolled', window.scrollY > SCROLL_THRESHOLD);

  update();
  window.addEventListener('scroll', update, { passive: true });
}
