(function () {
  const modalInstances = new WeakMap();
  const toastTimers = new WeakMap();

  function emit(element, eventName) {
    element.dispatchEvent(new CustomEvent(`ui:${eventName}`));
  }

  class UiModal {
    constructor(element) {
      this.element = element;
      this.previousFocus = null;
      modalInstances.set(element, this);
    }

    static getOrCreateInstance(element) {
      return modalInstances.get(element) || new UiModal(element);
    }

    show() {
      if (this.element.classList.contains('is-open')) return;
      this.previousFocus = document.activeElement;
      this.element.classList.add('is-open');
      this.element.setAttribute('aria-hidden', 'false');
      this.element.setAttribute('aria-modal', 'true');
      document.body.classList.add('ui-modal-open');
      emit(this.element, 'shown');
      const focusable = this.element.querySelector(
        'input:not([type="hidden"]), select, textarea, button, [href], [tabindex]:not([tabindex="-1"])'
      );
      if (focusable) focusable.focus();
      else this.element.focus();
    }

    hide() {
      if (!this.element.classList.contains('is-open')) return;
      emit(this.element, 'hide');
      this.element.classList.remove('is-open');
      this.element.setAttribute('aria-hidden', 'true');
      this.element.removeAttribute('aria-modal');
      emit(this.element, 'hidden');
      if (!document.querySelector('.modal.is-open')) document.body.classList.remove('ui-modal-open');
      if (this.previousFocus && this.previousFocus.isConnected) this.previousFocus.focus();
    }
  }

  class UiToast {
    constructor(element, options) {
      this.element = element;
      this.delay = options && options.delay ? options.delay : 3500;
    }

    show() {
      this.element.classList.add('is-visible');
      window.clearTimeout(toastTimers.get(this.element));
      toastTimers.set(this.element, window.setTimeout(() => this.hide(), this.delay));
    }

    hide() {
      this.element.classList.remove('is-visible');
    }
  }

  window.UiModal = UiModal;
  window.UiToast = UiToast;

  function closeSidebar() {
    const sidebar = document.querySelector('.sidebar.is-open');
    if (sidebar) sidebar.classList.remove('is-open');
    document.body.classList.remove('ui-sidebar-open');
    document.querySelectorAll('[data-ui-toggle="sidebar"]').forEach(button => {
      button.setAttribute('aria-expanded', 'false');
    });
  }

  document.addEventListener('click', event => {
    if (!(event.target instanceof Element)) return;
    const target = event.target;
    const dismiss = target.closest('[data-ui-dismiss]');

    if (dismiss) {
      const type = dismiss.dataset.uiDismiss;
      if (type === 'modal') {
        const modal = dismiss.closest('.modal');
        if (modal) UiModal.getOrCreateInstance(modal).hide();
      } else if (type === 'sidebar') {
        closeSidebar();
      } else if (type === 'toast') {
        const toast = dismiss.closest('.toast');
        if (toast) toast.classList.remove('is-visible');
      }
    }

    if (document.body.classList.contains('ui-sidebar-open') &&
        !target.closest('#sidebar') &&
        !target.closest('[data-ui-toggle="sidebar"]')) {
      closeSidebar();
    }

    const toggle = target.closest('[data-ui-toggle]');
    if (toggle) {
      const type = toggle.dataset.uiToggle;
      if (type === 'sidebar') {
        const sidebar = document.querySelector(toggle.dataset.uiTarget || '#sidebar');
        if (sidebar) {
          sidebar.classList.toggle('is-open');
          const opened = sidebar.classList.contains('is-open');
          document.body.classList.toggle('ui-sidebar-open', opened);
          toggle.setAttribute('aria-expanded', String(opened));
        }
      } else if (type === 'dropdown') {
        const dropdown = toggle.closest('.dropdown');
        const opened = dropdown && !dropdown.classList.contains('is-open');
        document.querySelectorAll('.dropdown.is-open').forEach(item => item.classList.remove('is-open'));
        if (dropdown && opened) dropdown.classList.add('is-open');
        toggle.setAttribute('aria-expanded', String(Boolean(opened)));
      } else if (type === 'collapse') {
        const panel = document.querySelector(toggle.dataset.uiTarget);
        if (panel) {
          panel.hidden = !panel.hidden;
          toggle.setAttribute('aria-expanded', String(!panel.hidden));
        }
      }
    }

    if (target.classList.contains('modal') && target.classList.contains('is-open')) {
      UiModal.getOrCreateInstance(target).hide();
    }

    if (!target.closest('.dropdown')) {
      document.querySelectorAll('.dropdown.is-open').forEach(item => item.classList.remove('is-open'));
    }
  });

  document.addEventListener('keydown', event => {
    if (event.key !== 'Escape') return;
    const modal = document.querySelector('.modal.is-open');
    if (modal) UiModal.getOrCreateInstance(modal).hide();
    closeSidebar();
    document.querySelectorAll('.dropdown.is-open').forEach(item => item.classList.remove('is-open'));
  });

  document.querySelectorAll('.global-search').forEach(form => {
    form.addEventListener('submit', event => event.preventDefault());
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth >= 992) closeSidebar();
  });
})();
