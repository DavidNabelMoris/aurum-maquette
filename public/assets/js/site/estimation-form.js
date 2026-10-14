export function initEstimationForm(form) {
  if (!form) return;

  const steps = [...form.querySelectorAll('[data-step]')];
  const progress = [...form.querySelectorAll('[data-progress-step]')];
  const groups = [...form.querySelectorAll('[data-options-for]')];
  const status = form.querySelector('[data-form-status]');
  const success = document.querySelector('[data-form-success]');
  let current = 0;

  function showStep(index) {
    current = index;
    steps.forEach((step, i) => { step.hidden = i !== index; });
    progress.forEach((item, i) => {
      item.classList.toggle('is-active', i === index);
      item.classList.toggle('is-done', i < index);
    });
    steps[index].querySelector('input, select, textarea')?.focus({ preventScroll: true });
  }

  function showOptionsFor(category) {
    groups.forEach((group) => {
      const isActive = group.dataset.optionsFor === category;
      group.hidden = !isActive;
      group.querySelectorAll('input, select, textarea').forEach((field) => { field.disabled = !isActive; });
    });
  }

  function stepIsValid(step) {
    const fields = [...step.querySelectorAll('input, select, textarea')].filter((field) => !field.disabled);
    const invalid = fields.find((field) => !field.checkValidity());
    invalid?.reportValidity();
    return !invalid;
  }

  function clearErrors() {
    form.querySelectorAll('[data-error-for]').forEach((error) => { error.textContent = ''; });
    status.textContent = '';
  }

  function showErrors(errors) {
    let firstStep = steps.length;
    Object.entries(errors).forEach(([field, message]) => {
      const error = form.querySelector(`[data-error-for="${field}"]`);
      if (!error) return;
      error.textContent = message;
      firstStep = Math.min(firstStep, steps.indexOf(error.closest('[data-step]')));
    });
    if (firstStep < steps.length) showStep(firstStep);
  }

  function setLoading(isLoading) {
    const button = form.querySelector('[type="submit"]');
    button.disabled = isLoading;
    button.textContent = isLoading ? 'Envoi en cours…' : button.dataset.label;
    form.setAttribute('aria-busy', String(isLoading));
  }

  async function submit() {
    setLoading(true);
    clearErrors();

    try {
      const response = await fetch(form.action, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json',
          'X-CSRF-Token': form.elements._token.value,
        },
        body: JSON.stringify(Object.fromEntries(new FormData(form))),
      });
      const result = await response.json().catch(() => ({}));

      if (response.status === 422) {
        showErrors(result.errors);
        return;
      }
      if (!response.ok) {
        status.textContent = result.error ?? "L'envoi a échoué. Réessayez ou appelez-nous.";
        return;
      }

      success.querySelector('[data-reference]').textContent = result.reference ?? '';
      form.hidden = true;
      success.hidden = false;
      success.focus();
    } catch {
      status.textContent = "L'envoi a échoué. Vérifiez votre connexion ou appelez-nous.";
    } finally {
      setLoading(false);
    }
  }

  form.addEventListener('change', (event) => {
    if (event.target.name === 'category') showOptionsFor(event.target.value);
  });

  form.addEventListener('click', (event) => {
    if (event.target.closest('[data-next]') && stepIsValid(steps[current])) showStep(current + 1);
    if (event.target.closest('[data-prev]')) showStep(current - 1);
  });

  form.addEventListener('submit', (event) => {
    event.preventDefault();
    if (stepIsValid(steps[current])) submit();
  });

  showOptionsFor(form.querySelector('[name="category"]:checked')?.value ?? null);
  showStep(0);
}
