// Auto-formatting utilities for time and date inputs
// CampusRoom - NeoTaiwan Modern Tech Design System

class InputFormatter {
    constructor() {
        this.timeInputs = [];
        this.dateInputs = [];
        this.init();
    }

    init() {
        // Initialize existing inputs
        this.bindTimeInputs();
        this.bindDateInputs();
    }

    bindTimeInputs() {
        const timeInputs = document.querySelectorAll('input[type="text"][placeholder*="hh:mm"]');
        timeInputs.forEach(input => {
            if (!input.dataset.formatted) {
                input.dataset.formatted = 'true';
                input.addEventListener('input', (e) => this.formatTimeInput(e.target));
                input.addEventListener('keydown', (e) => this.handleTimeKeydown(e));
                input.addEventListener('blur', (e) => this.validateTimeFormat(e.target));
            }
        });
    }

    bindDateInputs() {
        const dateInputs = document.querySelectorAll('input[type="text"][placeholder*="dd/mm/yyyy"]');
        dateInputs.forEach(input => {
            if (!input.dataset.formatted) {
                input.dataset.formatted = 'true';
                input.addEventListener('input', (e) => this.formatDateInput(e.target));
                input.addEventListener('keydown', (e) => this.handleDateKeydown(e));
                input.addEventListener('blur', (e) => this.validateDateFormat(e.target));
            }
        });
    }

    formatTimeInput(input) {
        let value = input.value.replace(/[^0-9]/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + ':' + value.substring(2);
        }
        if (value.length >= 5) {
            value = value.substring(0, 5) + ':' + value.substring(5);
        }
        if (value.length > 8) {
            value = value.substring(0, 8);
        }
        input.value = value;
    }

    formatDateInput(input) {
        let value = input.value.replace(/[^0-9]/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2);
        }
        if (value.length >= 5) {
            value = value.substring(0, 5) + '/' + value.substring(5);
        }
        if (value.length > 10) {
            value = value.substring(0, 10);
        }
        input.value = value;
    }

    handleTimeKeydown(e) {
        const input = e.target;
        const cursorPos = input.selectionStart;
        const value = input.value;

        // Auto-insert colons
        if (e.key >= '0' && e.key <= '9') {
            if (cursorPos === 2 || cursorPos === 5) {
                input.value = value.substring(0, cursorPos) + ':' + value.substring(cursorPos);
                setTimeout(() => input.setSelectionRange(cursorPos + 1, cursorPos + 1), 0);
            }
        }

        // Handle backspace over colons
        if (e.key === 'Backspace' && (cursorPos === 3 || cursorPos === 6)) {
            e.preventDefault();
            input.value = value.substring(0, cursorPos - 1) + value.substring(cursorPos);
            setTimeout(() => input.setSelectionRange(cursorPos - 1, cursorPos - 1), 0);
        }
    }

    handleDateKeydown(e) {
        const input = e.target;
        const cursorPos = input.selectionStart;
        const value = input.value;

        // Auto-insert slashes
        if (e.key >= '0' && e.key <= '9') {
            if (cursorPos === 2 || cursorPos === 5) {
                input.value = value.substring(0, cursorPos) + '/' + value.substring(cursorPos);
                setTimeout(() => input.setSelectionRange(cursorPos + 1, cursorPos + 1), 0);
            }
        }

        // Handle backspace over slashes
        if (e.key === 'Backspace' && (cursorPos === 3 || cursorPos === 6)) {
            e.preventDefault();
            input.value = value.substring(0, cursorPos - 1) + value.substring(cursorPos);
            setTimeout(() => input.setSelectionRange(cursorPos - 1, cursorPos - 1), 0);
        }
    }

    validateTimeFormat(input) {
        const timeRegex = /^([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/;
        const isValid = timeRegex.test(input.value);

        input.classList.toggle('is-valid', isValid && input.value.length > 0);
        input.classList.toggle('is-invalid', !isValid && input.value.length > 0);

        return isValid;
    }

    validateDateFormat(input) {
        const dateRegex = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/;
        const isValid = dateRegex.test(input.value);

        if (isValid) {
            // Additional validation for valid date
            const [day, month, year] = input.value.split('/').map(Number);
            const date = new Date(year, month - 1, day);
            const isValidDate = date.getFullYear() === year &&
                               date.getMonth() === month - 1 &&
                               date.getDate() === day;
            input.classList.toggle('is-valid', isValidDate);
            input.classList.toggle('is-invalid', !isValidDate);
            return isValidDate;
        } else {
            input.classList.toggle('is-valid', false);
            input.classList.toggle('is-invalid', input.value.length > 0);
            return false;
        }
    }
}

// Initialize formatter when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.inputFormatter = new InputFormatter();
});

// Re-bind inputs after dynamic content changes
function rebindFormatters() {
    if (window.inputFormatter) {
        window.inputFormatter.bindTimeInputs();
        window.inputFormatter.bindDateInputs();
    }
}
