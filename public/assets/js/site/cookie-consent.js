const STORAGE_KEY = 'aurum-cookie-consent';
const CONSENT_MAX_AGE_MS = 1000 * 60 * 60 * 24 * 180;

function readConsent() {
  try {
    const consent = JSON.parse(localStorage.getItem(STORAGE_KEY));
    return consent && Date.now() - consent.at < CONSENT_MAX_AGE_MS ? consent.value : null;
  } catch {
    return null;
  }
}

function saveConsent(value) {
  try {
    localStorage.setItem(STORAGE_KEY, JSON.stringify({ value, at: Date.now() }));
  } catch {
    // Storage can be unavailable (private mode): the choice then only lasts for this page.
  }
}

function loadAnalytics(gtmId) {
  if (!gtmId || window.dataLayer) return;

  window.dataLayer = [{ 'gtm.start': Date.now(), event: 'gtm.js' }];
  const script = document.createElement('script');
  script.async = true;
  script.src = `https://www.googletagmanager.com/gtm.js?id=${encodeURIComponent(gtmId)}`;
  document.head.append(script);
}

export function initCookieConsent() {
  const banner = document.querySelector('[data-cookie-banner]');
  if (!banner) return;

  const gtmId = document.body.dataset.gtmId;
  const consent = readConsent();

  if (consent === 'accepted') loadAnalytics(gtmId);
  if (consent === null) banner.hidden = false;

  banner.addEventListener('click', (event) => {
    const button = event.target.closest('[data-cookie-choice]');
    if (!button) return;

    const value = button.dataset.cookieChoice;
    saveConsent(value);
    banner.hidden = true;
    if (value === 'accepted') loadAnalytics(gtmId);
  });

  document.addEventListener('click', (event) => {
    if (!event.target.closest('[data-cookie-settings]')) return;
    banner.hidden = false;
    banner.querySelector('[data-cookie-choice]').focus();
  });
}
