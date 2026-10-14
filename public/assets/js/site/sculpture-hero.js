import { LiquidEngine, computeRect } from './liquid-engine.js';

const MOBILE_QUERY = '(max-width: 639px)';

const ENGINE_OPTIONS = {
  interactive: true,
  strength: 1,
  radius: 160,
  density: 1,
  dotSize: 1,
  spread: 1,
  turbulence: 1,
  returnSpeed: 1,
  streaks: true,
  restStyle: 'image',
  ambient: true,
  ambientIntensity: 0.5,
  speed: 1,
  liquid: 1,
  imgBg: null,
  tint: [1.08, 0.97, 0.78],
};

function loadImage(src) {
  return new Promise((resolve, reject) => {
    const image = new Image();
    image.decoding = 'async';
    image.onload = () => resolve(image);
    image.onerror = () => reject(new Error(`Image failed to load: ${src}`));
    image.src = src;
  });
}

function backgroundRgb(element) {
  const [r, g, b] = getComputedStyle(element).backgroundColor.match(/\d+(\.\d+)?/g).map(Number);
  return [r / 255, g / 255, b / 255];
}

export function initSculptureHero(root) {
  if (!root) return;

  const canvas = root.querySelector('[data-hero-canvas]');
  const fallback = root.querySelector('[data-hero-fallback]');
  const hint = root.querySelector('[data-hero-hint]');
  const backdrop = root.querySelector('[data-hero-backdrop]');
  const content = root.querySelector('[data-hero-content]');
  const header = document.querySelector('[data-site-header]');
  const mobileQuery = window.matchMedia(MOBILE_QUERY);
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  let engine = null;
  let image = null;
  let inView = true;
  let loadId = 0;

  if (hint && window.matchMedia('(pointer: coarse)').matches) {
    hint.textContent = hint.dataset.touchLabel;
  }

  function layout() {
    const width = root.clientWidth;
    const height = root.clientHeight;
    const top = header ? header.offsetHeight : 0;
    const bottom = content.offsetTop;
    const aspect = image ? image.naturalWidth / image.naturalHeight : 2.5;
    const rect = computeRect(width, height, aspect, { top, bottom });

    Object.assign(fallback.style, {
      left: `${rect.x}px`,
      top: `${rect.y}px`,
      width: `${rect.w}px`,
      height: `${rect.h}px`,
    });

    if (hint) hint.style.top = `${Math.min(rect.y + rect.h + 8, bottom - 28)}px`;

    if (backdrop) {
      backdrop.style.top = `${(top + bottom) / 2}px`;
      backdrop.style.fontSize = `${Math.min(width * 0.3, (bottom - top) * 0.9)}px`;
    }

    engine?.resize(width, height, rect);
  }

  function fail() {
    root.dataset.gl = 'off';
    engine?.destroy();
    engine = null;
  }

  function createEngine() {
    try {
      engine = new LiquidEngine(canvas, {
        ...ENGINE_OPTIONS,
        intro: !reducedMotion,
        reducedMotion,
        bg: backgroundRgb(root),
      }, fail);
      engine.onFirstFrame = () => { root.dataset.gl = 'on'; };
    } catch {
      fail();
    }
  }

  async function showImage() {
    const id = ++loadId;
    const src = mobileQuery.matches ? root.dataset.mobileSrc : root.dataset.src;

    try {
      const loaded = await loadImage(src);
      if (id !== loadId) return;
      image = loaded;
      fallback.src = src;
      layout();
      engine?.setImage(image);
    } catch {
      fail();
    }
  }

  function updateVisibility() {
    engine?.setVisible(inView && !document.hidden);
  }

  function localPoint(event) {
    const bounds = root.getBoundingClientRect();
    return [event.clientX - bounds.left, event.clientY - bounds.top];
  }

  function onPointer(type) {
    return (event) => {
      if (!engine) return;
      root.dataset.touched = '1';
      engine.pointer(type, ...localPoint(event), event.pointerType === 'touch');
    };
  }

  createEngine();
  showImage();

  root.addEventListener('pointermove', onPointer('move'));
  root.addEventListener('pointerdown', onPointer('down'));
  root.addEventListener('pointerup', onPointer('up'));
  root.addEventListener('pointercancel', onPointer('up'));
  root.addEventListener('pointerleave', onPointer('leave'));

  new ResizeObserver(layout).observe(root);
  mobileQuery.addEventListener('change', showImage);

  new IntersectionObserver(([entry]) => {
    inView = entry.isIntersecting;
    updateVisibility();
  }).observe(root);
  document.addEventListener('visibilitychange', updateVisibility);
}
