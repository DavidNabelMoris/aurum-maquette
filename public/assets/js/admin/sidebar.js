const DESKTOP_QUERY = '(min-width: 992px)';

export function initSidebar() {
  const sidebar = document.querySelector('[data-sidebar]');
  const openButton = document.querySelector('[data-sidebar-open]');
  const backdrop = document.querySelector('[data-sidebar-backdrop]');
  if (!sidebar || !openButton || !backdrop) return;

  const setOpen = (isOpen) => {
    sidebar.classList.toggle('is-open', isOpen);
    backdrop.hidden = !isOpen;
    openButton.setAttribute('aria-expanded', String(isOpen));
    document.body.classList.toggle('is-locked', isOpen);
  };

  openButton.addEventListener('click', () => setOpen(true));
  backdrop.addEventListener('click', () => setOpen(false));

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') setOpen(false);
  });

  window.matchMedia(DESKTOP_QUERY).addEventListener('change', (event) => {
    if (event.matches) setOpen(false);
  });
}
