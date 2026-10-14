const SHOW_AFTER_VIEWPORTS = 0.6;

/**
 * Mobile call/estimate bar: appears once the visitor scrolls past the first screen,
 * hides again while the estimation form or the footer is on screen.
 */
export function initStickyCta() {
  const bar = document.querySelector('[data-sticky-cta]');
  if (!bar) return;

  const hideOver = [document.querySelector('#estimation'), document.querySelector('.site-footer')].filter(Boolean);
  const covered = new Set();

  const update = () => {
    const scrolledEnough = window.scrollY > window.innerHeight * SHOW_AFTER_VIEWPORTS;
    bar.hidden = !scrolledEnough || covered.size > 0;
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => (entry.isIntersecting ? covered.add(entry.target) : covered.delete(entry.target)));
    update();
  });
  hideOver.forEach((element) => observer.observe(element));

  update();
  window.addEventListener('scroll', update, { passive: true });
}
