/**
 * KTX Management System — Premium UI JavaScript v2.0
 * Features: Dark/Light mode, Scroll animations, Enhanced interactions
 */

// ── Theme (Dark/Light) ─────────────────────────────────────
const THEME_KEY = 'ktx-theme';

function getPreferredTheme() {
  const stored = localStorage.getItem(THEME_KEY);
  if (stored) return stored;
  return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
}

function setTheme(theme) {
  document.documentElement.setAttribute('data-theme', theme);
  localStorage.setItem(THEME_KEY, theme);
}

// Apply theme immediately to avoid flash
setTheme(getPreferredTheme());

document.addEventListener('DOMContentLoaded', () => {
  // Theme toggle buttons
  document.querySelectorAll('.theme-toggle').forEach(btn => {
    btn.addEventListener('click', () => {
      const current = document.documentElement.getAttribute('data-theme') || 'light';
      setTheme(current === 'dark' ? 'light' : 'dark');
    });
  });
});

// Listen for system theme changes
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
  if (!localStorage.getItem(THEME_KEY)) {
    setTheme(e.matches ? 'dark' : 'light');
  }
});

// ── Sidebar toggle ──────────────────────────────────────────
const sidebar  = document.getElementById('sidebar');
const overlay  = document.getElementById('sidebarOverlay');
const toggleBtn = document.getElementById('sidebarToggle');

function openSidebar() {
  sidebar?.classList.add('open');
  overlay?.classList.add('show');
  document.body.style.overflow = 'hidden';
}
function closeSidebar() {
  sidebar?.classList.remove('open');
  overlay?.classList.remove('show');
  document.body.style.overflow = '';
}
toggleBtn?.addEventListener('click', openSidebar);
overlay?.addEventListener('click', closeSidebar);

// ── Active sidebar link ─────────────────────────────────────
(function markActiveLink() {
  const path = window.location.pathname;
  document.querySelectorAll('.sidebar-link').forEach(link => {
    const href = link.getAttribute('href');
    if (href && href !== '/' && path.startsWith(href)) {
      link.classList.add('active');
    } else if (href === path) {
      link.classList.add('active');
    }
  });
})();

// ── Flash / Alert dismiss ───────────────────────────────────
document.querySelectorAll('.alert-close').forEach(btn => {
  btn.addEventListener('click', () => {
    const alert = btn.closest('.alert');
    alert.style.opacity = '0';
    alert.style.transform = 'translateY(-6px)';
    setTimeout(() => alert.remove(), 250);
  });
});
// Auto-dismiss success alerts after 5s
setTimeout(() => {
  document.querySelectorAll('.alert-success').forEach(el => {
    el.style.transition = 'opacity .4s, transform .4s';
    el.style.opacity = '0';
    el.style.transform = 'translateY(-6px)';
    setTimeout(() => el.remove(), 400);
  });
}, 5000);

// ── Modals ──────────────────────────────────────────────────
function openModal(id) {
  const overlay = document.getElementById(id);
  if (!overlay) return;
  overlay.classList.add('open');
  document.body.style.overflow = 'hidden';
  overlay.querySelector('[autofocus]')?.focus();
}
function closeModal(id) {
  const overlay = document.getElementById(id);
  if (!overlay) return;
  overlay.classList.remove('open');
  document.body.style.overflow = '';
}
document.addEventListener('click', e => {
  const trigger = e.target.closest('[data-modal-open]');
  if (trigger) openModal(trigger.dataset.modalOpen);

  const close = e.target.closest('[data-modal-close]');
  if (close) closeModal(close.dataset.modalClose);

  if (e.target.classList.contains('modal-overlay')) {
    e.target.classList.remove('open');
    document.body.style.overflow = '';
  }
});
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') {
    document.querySelectorAll('.modal-overlay.open').forEach(m => {
      m.classList.remove('open');
      document.body.style.overflow = '';
    });
    closeSidebar();
  }
});

// ── Dropdowns ───────────────────────────────────────────────
document.addEventListener('click', e => {
  const trigger = e.target.closest('[data-dropdown]');
  if (trigger) {
    const dropdown = trigger.closest('.dropdown');
    dropdown?.classList.toggle('open');
    e.stopPropagation();
    return;
  }
  document.querySelectorAll('.dropdown.open').forEach(d => d.classList.remove('open'));
});

// ── Tabs ────────────────────────────────────────────────────
document.querySelectorAll('.tab-link').forEach(btn => {
  btn.addEventListener('click', () => {
    const tabGroup = btn.closest('.tabs');
    const tabContent = document.querySelector(btn.dataset.tabTarget);
    if (!tabContent) return;

    tabGroup.querySelectorAll('.tab-link').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const paneContainer = tabContent.closest('.tab-content') || tabContent.parentElement;
    paneContainer.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    tabContent.classList.add('active');
  });
});

// ── Confirm delete ──────────────────────────────────────────
document.addEventListener('click', e => {
  const btn = e.target.closest('[data-confirm]');
  if (btn) {
    const msg = btn.dataset.confirm || 'Bạn có chắc muốn thực hiện thao tác này?';
    if (!confirm(msg)) e.preventDefault();
  }
});

// ── AJAX fetch helper ───────────────────────────────────────
async function ktxFetch(url, options = {}) {
  const defaults = {
    headers: {
      'Content-Type': 'application/json',
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
    },
  };
  const res = await fetch(url, { ...defaults, ...options, headers: { ...defaults.headers, ...(options.headers || {}) } });
  const json = await res.json();
  if (!res.ok) throw json;
  return json;
}

// ── Toast notification (premium) ────────────────────────────
function toast(message, type = 'success') {
  let container = document.querySelector('.toast-container');
  if (!container) {
    container = document.createElement('div');
    container.className = 'toast-container';
    document.body.appendChild(container);
  }

  const icons = { success: '✅', error: '❌', warning: '⚠️', info: 'ℹ️' };
  const div = document.createElement('div');
  div.className = `toast toast-${type}`;
  div.innerHTML = `
    <span style="font-size:18px;flex-shrink:0;margin-top:1px">${icons[type] || '💬'}</span>
    <div style="flex:1;min-width:0">
      <div style="font-weight:600;font-size:13.5px;color:var(--txt-primary)">${message}</div>
    </div>
    <button onclick="this.closest('.toast').remove()" style="background:none;border:none;color:var(--txt-muted);cursor:pointer;padding:2px;font-size:16px;line-height:1;flex-shrink:0;transition:opacity .2s" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=.5">×</button>
    <div class="toast-progress"></div>
  `;
  container.appendChild(div);

  // Auto-remove after animation
  setTimeout(() => {
    div.style.opacity = '0';
    div.style.transform = 'translateX(20px)';
    div.style.transition = 'all .3s ease';
    setTimeout(() => div.remove(), 300);
  }, 4500);
}

// ── Form submit with loading state ─────────────────────────
document.querySelectorAll('form[data-ajax]').forEach(form => {
  form.addEventListener('submit', async e => {
    e.preventDefault();
    const btn = form.querySelector('[type=submit]');
    const origText = btn?.innerHTML;
    if (btn) { btn.disabled = true; btn.innerHTML = '<span class="loading"></span> Đang xử lý...'; }

    try {
      const formData = new FormData(form);
      const data = Object.fromEntries(formData.entries());
      const res = await ktxFetch(form.action, { method: form.method.toUpperCase(), body: JSON.stringify(data) });
      toast(res.message || 'Thành công', 'success');
      if (res.redirect) window.location.href = res.redirect;
      if (form.dataset.ajaxReset !== undefined) form.reset();
    } catch (err) {
      toast(err.message || 'Đã có lỗi xảy ra', 'error');
      if (err.errors) {
        Object.entries(err.errors).forEach(([field, msgs]) => {
          const input = form.querySelector(`[name="${field}"]`);
          if (input) {
            input.classList.add('is-invalid');
            let errEl = input.parentElement.querySelector('.form-error');
            if (!errEl) { errEl = document.createElement('p'); errEl.className = 'form-error'; input.after(errEl); }
            errEl.textContent = Array.isArray(msgs) ? msgs[0] : msgs;
          }
        });
      }
    } finally {
      if (btn) { btn.disabled = false; btn.innerHTML = origText; }
    }
  });
});

// Clear form errors on input
document.addEventListener('input', e => {
  if (e.target.classList.contains('is-invalid')) {
    e.target.classList.remove('is-invalid');
    e.target.parentElement.querySelector('.form-error')?.remove();
  }
});

// ── Animate stat numbers ────────────────────────────────────
function animateCount(el) {
  const target = parseInt(el.dataset.count || el.textContent.replace(/\D/g,''), 10);
  if (isNaN(target) || target === 0) return;
  el.textContent = '0';
  const duration = 1200;
  const start = performance.now();
  const step = ts => {
    const progress = Math.min((ts - start) / duration, 1);
    const eased = 1 - Math.pow(1 - progress, 3); // easeOutCubic
    el.textContent = Math.round(eased * target).toLocaleString('vi-VN');
    if (progress < 1) requestAnimationFrame(step);
  };
  requestAnimationFrame(step);
}

// ── Scroll animations (Intersection Observer) ───────────────
const scrollObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      // Animate on scroll elements
      if (entry.target.classList.contains('animate-on-scroll')) {
        entry.target.classList.add('visible');
      }
      // Animate stat counters
      if (entry.target.hasAttribute('data-count')) {
        animateCount(entry.target);
        scrollObserver.unobserve(entry.target);
      }
    }
  });
}, {
  threshold: 0.15,
  rootMargin: '0px 0px -50px 0px'
});

// Observe elements
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-count]').forEach(el => scrollObserver.observe(el));
  document.querySelectorAll('.animate-on-scroll').forEach(el => scrollObserver.observe(el));

  // Add stagger delay to feature cards
  document.querySelectorAll('.feature-card.animate-on-scroll').forEach((card, i) => {
    card.style.transitionDelay = `${i * 100}ms`;
  });
});

// ── Home navbar scroll effect ───────────────────────────────
const homeNav = document.querySelector('.home-nav');
if (homeNav) {
  let lastScroll = 0;
  window.addEventListener('scroll', () => {
    const scrollY = window.scrollY;
    homeNav.classList.toggle('scrolled', scrollY > 50);
    lastScroll = scrollY;
  }, { passive: true });
}

// ── Keyboard shortcuts ──────────────────────────────────────
document.addEventListener('keydown', e => {
  // Ctrl/Cmd + K for search focus
  if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
    e.preventDefault();
    const searchInput = document.querySelector('.filter-search input, .topbar-search input');
    if (searchInput) searchInput.focus();
  }
});

// ── Password toggle ─────────────────────────────────────────
document.querySelectorAll('.password-toggle').forEach(btn => {
  btn.addEventListener('click', () => {
    const input = btn.closest('.password-wrapper').querySelector('input');
    if (input.type === 'password') {
      input.type = 'text';
      btn.textContent = '🙈';
    } else {
      input.type = 'password';
      btn.textContent = '👁️';
    }
  });
});

// ── Format currency ─────────────────────────────────────────
function formatVND(amount) {
  return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
}

// ── Export functions to global ───────────────────────────────
window.ktx = { openModal, closeModal, toast, ktxFetch, formatVND, setTheme };
