import { initSite } from '../site/common.js';
import { initSculptureHero } from '../site/sculpture-hero.js';
import { initTabs } from '../site/tabs.js';
import { initAgencyFilter } from '../site/agency-filter.js';
import { initEstimationForm } from '../site/estimation-form.js';

initSite();
initSculptureHero(document.querySelector('[data-sculpture-hero]'));
initTabs(document.querySelector('[data-tabs]'));
initAgencyFilter(document.querySelector('[data-agency-filter]'));
initEstimationForm(document.querySelector('[data-estimation-form]'));
