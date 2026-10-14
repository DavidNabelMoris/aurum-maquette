import { renderIcons } from '../lib/icons.js';
import { fetchJson } from '../lib/http.js';
import { initSidebar } from '../admin/sidebar.js';
import { createTransactionsChart, createVolumeChart, updateChart } from '../admin/charts.js';

const root = document.querySelector('[data-dashboard]');
const endpoint = root.dataset.statsEndpoint;
const chartContainers = root.querySelectorAll('[data-chart-state]');

const loadStats = (period) => fetchJson(`${endpoint}?period=${encodeURIComponent(period)}`);

function setChartState(state) {
  chartContainers.forEach((container) => { container.dataset.chartState = state; });
}

function renderProgressBars() {
  root.querySelectorAll('[data-progress]').forEach((bar) => {
    bar.style.width = `${Number(bar.dataset.progress)}%`;
  });
}

function initPeriodToggle(onChange) {
  const group = root.querySelector('[data-period-toggle]');

  group.addEventListener('click', (event) => {
    const button = event.target.closest('[data-period]');
    if (!button || button.getAttribute('aria-pressed') === 'true') return;

    group.querySelectorAll('[data-period]').forEach((item) => {
      const isActive = item === button;
      item.classList.toggle('is-active', isActive);
      item.setAttribute('aria-pressed', String(isActive));
    });

    onChange(button.dataset.period);
  });
}

async function initCharts() {
  try {
    const stats = await loadStats('month');
    setChartState('ready');
    const volumeChart = createVolumeChart(root.querySelector('#volume-chart'), stats.volume);
    createTransactionsChart(root.querySelector('#transactions-chart'), stats.transactions);

    initPeriodToggle(async (period) => {
      const { volume } = await loadStats(period);
      updateChart(volumeChart, volume);
    });
  } catch (error) {
    setChartState('error');
    console.error(error);
  }
}

renderIcons();
initSidebar();
renderProgressBars();
initCharts();
