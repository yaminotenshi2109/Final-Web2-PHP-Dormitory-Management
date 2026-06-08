/* ============================================================
   🛠️ UTILITY FUNCTIONS - Helper JS
   ============================================================ */

// ── API Requests ──────────────────────────────────────────
const API = {
    async get(url) {
        try {
            const response = await axios.get(`/Final-Web2-PHP-Dormitory-Management/public${url}`);
            return response.data;
        } catch (error) {
            console.error('GET Error:', error);
            throw error;
        }
    },

    async post(url, data = {}) {
        try {
            const response = await axios.post(`/Final-Web2-PHP-Dormitory-Management/public${url}`, data);
            return response.data;
        } catch (error) {
            console.error('POST Error:', error);
            throw error;
        }
    },

    async put(url, data = {}) {
        try {
            const response = await axios.put(`/Final-Web2-PHP-Dormitory-Management/public${url}`, data);
            return response.data;
        } catch (error) {
            console.error('PUT Error:', error);
            throw error;
        }
    },

    async delete(url) {
        try {
            const response = await axios.delete(`/Final-Web2-PHP-Dormitory-Management/public${url}`);
            return response.data;
        } catch (error) {
            console.error('DELETE Error:', error);
            throw error;
        }
    }
};

// ── Notifications ───────────────────────────────────────────
const Notify = {
    success(message) {
        this._show(message, 'success');
    },

    error(message) {
        this._show(message, 'danger');
    },

    warning(message) {
        this._show(message, 'warning');
    },

    info(message) {
        this._show(message, 'info');
    },

    _show(message, type) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.querySelector('main')?.insertAdjacentElement('afterbegin', alertDiv);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
};

// ── Form Validation ──────────────────────────────────────────
const Validate = {
    email(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    },

    required(value) {
        return value && value.trim() !== '';
    },

    minLength(value, length) {
        return value && value.length >= length;
    },

    maxLength(value, length) {
        return value && value.length <= length;
    },

    phone(phone) {
        return /^(\+84|0)[0-9]{9,10}$/.test(phone.replace(/\s/g, ''));
    },

    number(value) {
        return !isNaN(value) && value !== '';
    },

    date(date) {
        return !isNaN(new Date(date).getTime());
    }
};

// ── DOM Helpers ──────────────────────────────────────────
const DOM = {
    get(selector) {
        return document.querySelector(selector);
    },

    getAll(selector) {
        return document.querySelectorAll(selector);
    },

    addClass(element, className) {
        element.classList.add(className);
    },

    removeClass(element, className) {
        element.classList.remove(className);
    },

    hasClass(element, className) {
        return element.classList.contains(className);
    },

    toggleClass(element, className) {
        element.classList.toggle(className);
    },

    setText(element, text) {
        element.textContent = text;
    },

    setHTML(element, html) {
        element.innerHTML = html;
    },

    setValue(element, value) {
        element.value = value;
    },

    getValue(element) {
        return element.value;
    },

    on(element, event, callback) {
        element.addEventListener(event, callback);
    },

    off(element, event, callback) {
        element.removeEventListener(event, callback);
    },

    show(element) {
        element.style.display = '';
    },

    hide(element) {
        element.style.display = 'none';
    },

    toggle(element) {
        element.style.display = element.style.display === 'none' ? '' : 'none';
    }
};

// ── Storage Helpers ──────────────────────────────────────────
const Storage = {
    set(key, value) {
        localStorage.setItem(key, JSON.stringify(value));
    },

    get(key) {
        const value = localStorage.getItem(key);
        return value ? JSON.parse(value) : null;
    },

    remove(key) {
        localStorage.removeItem(key);
    },

    clear() {
        localStorage.clear();
    }
};

// ── String Helpers ──────────────────────────────────────────
const String = {
    capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    },

    truncate(str, length) {
        return str.length > length ? str.substring(0, length) + '...' : str;
    },

    slug(str) {
        return str.toLowerCase().replace(/\s+/g, '-').replace(/[^\w-]/g, '');
    },

    formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(amount);
    },

    formatDate(date) {
        return new Intl.DateTimeFormat('vi-VN', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }).format(new Date(date));
    }
};

// ── Table Helpers ──────────────────────────────────────────
const Table = {
    async loadData(url, tableSelector) {
        try {
            const data = await API.get(url);
            const table = DOM.get(tableSelector);
            if (table) {
                table.innerHTML = this._buildRows(data);
            }
        } catch (error) {
            Notify.error('Lỗi khi tải dữ liệu');
        }
    },

    _buildRows(data) {
        if (!data || data.length === 0) {
            return '<tr><td colspan="100%" class="text-center py-4">Không có dữ liệu</td></tr>';
        }
        return data.map(row => `<tr>${Object.values(row).map(val => `<td>${val}</td>`).join('')}</tr>`).join('');
    }
};

// ── Modal Helpers ──────────────────────────────────────────
const Modal = {
    show(modalId) {
        const modal = new bootstrap.Modal(DOM.get(`#${modalId}`));
        modal.show();
    },

    hide(modalId) {
        const modal = bootstrap.Modal.getInstance(DOM.get(`#${modalId}`));
        modal?.hide();
    }
};

// ── Form Builders ──────────────────────────────────────────
const Form = {
    getData(formSelector) {
        const form = DOM.get(formSelector);
        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });
        return data;
    },

    reset(formSelector) {
        DOM.get(formSelector)?.reset();
    },

    setErrors(formSelector, errors) {
        const form = DOM.get(formSelector);
        // Clear previous errors
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

        // Add new errors
        Object.keys(errors).forEach(field => {
            const input = form.querySelector(`[name="${field}"]`);
            if (input) {
                input.classList.add('is-invalid');
                const feedback = document.createElement('div');
                feedback.className = 'invalid-feedback';
                feedback.textContent = errors[field];
                input.parentNode.appendChild(feedback);
            }
        });
    },

    clearErrors(formSelector) {
        const form = DOM.get(formSelector);
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    }
};

// Export for use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { API, Notify, Validate, DOM, Storage, String, Table, Modal, Form };
}
