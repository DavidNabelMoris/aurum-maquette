import { renderIcons } from '../lib/icons.js';
import { initHeader } from './header.js';
import { initMobileMenu } from './mobile-menu.js';
import { initCookieConsent } from './cookie-consent.js';
import { initStickyCta } from './sticky-cta.js';

export function initSite() {
  renderIcons();
  initHeader();
  initMobileMenu();
  initCookieConsent();
  initStickyCta();
}
