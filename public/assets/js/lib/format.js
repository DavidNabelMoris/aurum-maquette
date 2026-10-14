const currency = new Intl.NumberFormat('fr-FR', {
  style: 'currency',
  currency: 'EUR',
  maximumFractionDigits: 0,
});

const number = new Intl.NumberFormat('fr-FR');

export const formatCurrency = (value) => currency.format(value);

export const formatNumber = (value) => number.format(value);

export const formatThousandsOfEuros = (value) => `${number.format(Math.round(value / 1000))} k€`;
