const DESKTOP_QUERY = '(min-width: 768px)';

export function initMobileMenu() {
  const toggle = document.querySelector('[data-menu-toggle]');
  if (!toggle) return;

  const menu = document.getElementById(toggle.getAttribute('aria-controls'));
  if (!menu) return;

  const setOpen = (isOpen) => {
    menu.hidden = !isOpen;
    toggle.setAttribute('aria-expanded', String(isOpen));
    toggle.setAttribute('aria-label', isOpen ? 'Fermer le menu' : 'Ouvrir le menu');
  };

  toggle.addEventListener('click', () => setOpen(menu.hidden));

  menu.addEventListener('click', (event) => {
    if (event.target.closest('a')) setOpen(false);
  });

  window.matchMedia(DESKTOP_QUERY).addEventListener('change', (event) => {
    if (event.matches) setOpen(false);
  });
}
