import { formatCurrency, formatNumber, formatThousandsOfEuros } from '../lib/format.js';

const { Chart } = window;

const colors = {
  gold: '#e6c15a',
  orange: '#fb6340',
  muted: '#8898aa',
  gridDark: 'rgba(255, 255, 255, 0.08)',
  gridLight: '#e9ecef',
};

Chart.defaults.font.family = "'Open Sans', sans-serif";
Chart.defaults.color = colors.muted;
Chart.defaults.plugins.legend.display = false;
Chart.defaults.maintainAspectRatio = false;

function scales({ gridColor, formatTick, beginAtZero = false }) {
  return {
    x: {
      grid: { display: false },
      border: { display: false },
    },
    y: {
      beginAtZero,
      grid: { color: gridColor },
      border: { display: false, dash: [2, 2] },
      ticks: { padding: 10, callback: formatTick },
    },
  };
}

export function createVolumeChart(canvas, { labels, values }) {
  return new Chart(canvas, {
    type: 'line',
    data: {
      labels,
      datasets: [{
        label: 'Volume de rachat',
        data: values,
        borderColor: colors.gold,
        borderWidth: 4,
        tension: 0.4,
        pointRadius: 0,
        pointHoverRadius: 5,
        pointBackgroundColor: colors.gold,
      }],
    },
    options: {
      interaction: { mode: 'index', intersect: false },
      plugins: {
        tooltip: { callbacks: { label: (context) => formatCurrency(context.parsed.y) } },
      },
      scales: scales({ gridColor: colors.gridDark, formatTick: formatThousandsOfEuros }),
    },
  });
}

export function createTransactionsChart(canvas, { labels, values }) {
  return new Chart(canvas, {
    type: 'bar',
    data: {
      labels,
      datasets: [{
        label: 'Transactions',
        data: values,
        backgroundColor: colors.orange,
        borderRadius: 6,
        maxBarThickness: 10,
      }],
    },
    options: {
      plugins: {
        tooltip: { callbacks: { label: (context) => `${formatNumber(context.parsed.y)} transactions` } },
      },
      scales: scales({ gridColor: colors.gridLight, formatTick: formatNumber, beginAtZero: true }),
    },
  });
}

export function updateChart(chart, { labels, values }) {
  chart.data.labels = labels;
  chart.data.datasets[0].data = values;
  chart.update();
}
