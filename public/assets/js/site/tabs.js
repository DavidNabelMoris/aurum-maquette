export function initTabs(root) {
  if (!root) return;

  const tabs = [...root.querySelectorAll('[role="tab"]')];

  const select = (tab) => {
    tabs.forEach((item) => {
      const isSelected = item === tab;
      item.setAttribute('aria-selected', String(isSelected));
      item.tabIndex = isSelected ? 0 : -1;
      document.getElementById(item.getAttribute('aria-controls')).hidden = !isSelected;
    });
  };

  root.addEventListener('click', (event) => {
    const tab = event.target.closest('[role="tab"]');
    if (tab) select(tab);
  });

  root.addEventListener('keydown', (event) => {
    const index = tabs.indexOf(document.activeElement);
    if (index === -1) return;

    const moves = { ArrowRight: 1, ArrowLeft: -1, Home: -index, End: tabs.length - 1 - index };
    if (!(event.key in moves)) return;

    event.preventDefault();
    const next = tabs[(index + moves[event.key] + tabs.length) % tabs.length];
    select(next);
    next.focus();
  });
}
