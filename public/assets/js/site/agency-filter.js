export function initAgencyFilter(root) {
  if (!root) return;

  const filters = [...root.querySelectorAll('[data-filter]')];
  const agencies = [...root.querySelectorAll('[data-region]')];
  const count = root.querySelector('[data-agency-count]');

  root.addEventListener('click', (event) => {
    const button = event.target.closest('[data-filter]');
    if (!button) return;

    const region = button.dataset.filter;
    filters.forEach((item) => item.setAttribute('aria-pressed', String(item === button)));

    let visible = 0;
    agencies.forEach((agency) => {
      const matches = region === 'all' || agency.dataset.region === region;
      agency.hidden = !matches;
      if (matches) visible++;
    });

    count.textContent = `${visible} agence${visible > 1 ? 's' : ''}`;
  });
}
