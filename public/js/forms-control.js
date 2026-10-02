(() => {
  document.addEventListener('DOMContentLoaded', () => {
    const page = document.querySelector('.forms-control-page');
    if (!page) return;
    const search = page.querySelector('#forms-control-search');
    const state = page.querySelector('#forms-control-state');
    const count = page.querySelector('#forms-control-count');
    const empty = page.querySelector('#forms-control-empty');
    const rows = [...page.querySelectorAll('[data-form-entry]')];
    const filter = () => {
      const query = search.value.trim().toLocaleLowerCase();
      let visible = 0;
      rows.forEach(row => {
        const matches = (state.value === 'all' || row.dataset.state === state.value)
          && row.dataset.search.toLocaleLowerCase().includes(query);
        row.hidden = !matches;
        if (matches) visible += 1;
      });
      count.textContent = `${visible} of ${rows.length} forms`;
      empty.hidden = visible > 0;
    };
    search.addEventListener('input', filter);
    state.addEventListener('change', filter);

    // The schedule form is loaded into the shared modal after the page loads.
    document.addEventListener('input', event => {
      if (!event.target.matches('[data-schedule-form] [name="opening_time"]')) return;
      event.target.form.elements.closing_time.min = event.target.value;
    });

    document.addEventListener('submit', async event => {
      const form = event.target;
      if (!form.matches('[data-schedule-form]')) return;
      event.preventDefault();
      const button = form.querySelector('[type="submit"]');
      if (button.disabled) return;
      const errors = form.querySelector('[data-schedule-errors]');
      const errorList = form.querySelector('[data-schedule-error-list]');
      const showErrors = messages => {
        errorList.replaceChildren();
        messages.forEach(message => {
          const item = document.createElement('li');
          item.textContent = message;
          errorList.append(item);
        });
        errors.hidden = false;
        errors.focus();
      };
      errors.hidden = true;
      form.querySelectorAll('[aria-invalid]').forEach(input => input.removeAttribute('aria-invalid'));
      button.disabled = true;
      button.textContent = 'Saving…';
      try {
        const response = await fetch(form.action, {
          method: 'POST',
          headers: { Accept: 'application/json' },
          body: new FormData(form),
          credentials: 'same-origin',
        });
        const result = await response.json();
        if (response.ok && result.redirect) {
          window.location.assign(result.redirect);
          return;
        }
        const fieldErrors = result.errors || {};
        Object.keys(fieldErrors).forEach(name => {
          form.elements.namedItem(name)?.setAttribute('aria-invalid', 'true');
        });
        const messages = Object.values(fieldErrors).flat();
        showErrors(messages.length ? messages : [result.message || 'Unable to save the schedule. Please try again.']);
      } catch {
        showErrors(['Unable to save the schedule. Check your connection and sign-in, then try again.']);
      } finally {
        button.disabled = false;
        button.textContent = 'Save';
      }
    });
  });
})();
