// Real-time form validation with visual feedback
// CampusRoom - NeoTaiwan Modern Tech Design System

class FormValidator {
    constructor() {
        this.debounceTimers = new Map();
        this.init();
    }

    init() {
        this.bindValidation();
        this.bindFormSubmission();
    }

    bindValidation() {
        // Real-time validation for all form inputs
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (!input.dataset.validated) {
                input.dataset.validated = 'true';

                // Real-time validation on input/change
                input.addEventListener('input', (e) => this.debounceValidation(e.target));
                input.addEventListener('change', (e) => this.validateField(e.target));

                // Visual feedback on focus/blur
                input.addEventListener('focus', (e) => this.showFieldFocus(e.target));
                input.addEventListener('blur', (e) => this.hideFieldFocus(e.target));
            }
        });
    }

    bindFormSubmission() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            if (!form.dataset.submissionBound) {
                form.dataset.submissionBound = 'true';
                form.addEventListener('submit', (e) => this.handleFormSubmission(e));
            }
        });
    }

    debounceValidation(input) {
        const fieldName = input.name;
        clearTimeout(this.debounceTimers.get(fieldName));

        this.debounceTimers.set(fieldName, setTimeout(() => {
            this.validateField(input);
        }, 300));
    }

    validateField(input) {
        const fieldName = input.name;
        const value = input.value.trim();
        let isValid = true;
        let errorMessage = '';

        // Clear previous validation states
        this.clearFieldValidation(input);

        // Field-specific validation
        switch (fieldName) {
            case 'nombre':
                isValid = this.validateNombre(value);
                errorMessage = isValid ? '' : 'El nombre debe tener al menos 2 caracteres y contener solo letras y espacios.';
                break;

            case 'sala':
                isValid = this.validateSala(value);
                errorMessage = isValid ? '' : 'Debe seleccionar una sala válida.';
                break;

            case 'fecha':
                isValid = this.validateFecha(value);
                errorMessage = isValid ? '' : 'La fecha debe estar en formato DD/MM/YYYY y ser futura.';
                break;

            case 'hora':
                isValid = this.validateHora(value);
                errorMessage = isValid ? '' : 'La hora debe estar en formato HH:MM:SS y dentro del horario laboral (08:00-18:00).';
                break;

            case 'duracion':
                isValid = this.validateDuracion(value);
                errorMessage = isValid ? '' : 'Debe seleccionar una duración válida.';
                break;

            default:
                isValid = value.length > 0;
                break;
        }

        // Apply validation styling
        this.applyValidationStyling(input, isValid, errorMessage);

        // Trigger cross-field validation if needed
        if (['fecha', 'hora', 'duracion', 'sala'].includes(fieldName)) {
            this.validateCrossFieldDependencies();
        }

        return isValid;
    }

    validateNombre(value) {
        return value.length >= 2 && /^[a-zA-ZÀ-ÿ\s]+$/.test(value);
    }

    validateSala(value) {
        const salas = ['A', 'B', 'C'];
        return salas.includes(value);
    }

    validateFecha(value) {
        const dateRegex = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/;
        if (!dateRegex.test(value)) return false;

        const [day, month, year] = value.split('/').map(Number);
        const date = new Date(year, month - 1, day);

        // Check if date is valid and in the future
        const now = new Date();
        now.setHours(0, 0, 0, 0); // Reset time to start of day

        return date.getFullYear() === year &&
               date.getMonth() === month - 1 &&
               date.getDate() === day &&
               date >= now;
    }

    validateHora(value) {
        const timeRegex = /^([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/;
        if (!timeRegex.test(value)) return false;

        const [hours, minutes, seconds] = value.split(':').map(Number);
        const timeInMinutes = hours * 60 + minutes;

        // Check if within business hours (08:00 - 18:00)
        return timeInMinutes >= 480 && timeInMinutes <= 1080;
    }

    validateDuracion(value) {
        const duraciones = [30, 60, 90, 120];
        return duraciones.includes(parseInt(value));
    }

    validateCrossFieldDependencies() {
        const fecha = document.querySelector('input[name="fecha"]');
        const hora = document.querySelector('input[name="hora"]');
        const duracion = document.querySelector('select[name="duracion"]');
        const sala = document.querySelector('select[name="sala"]');

        if (fecha && hora && duracion && sala && fecha.value && hora.value && duracion.value && sala.value) {
            // Check for overlaps (this would need AJAX call to server in real implementation)
            this.checkAvailability(fecha.value, hora.value, duracion.value, sala.value);
        }
    }

    async checkAvailability(fecha, hora, duracion, sala) {
        // This would make an AJAX call to check availability
        // For now, we'll simulate the validation
        try {
            const response = await fetch('check_availability.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ fecha, hora, duracion, sala })
            });

            if (response.ok) {
                const result = await response.json();
                if (!result.available) {
                    this.showOverlapError();
                }
            }
        } catch (error) {
            console.warn('Availability check failed:', error);
        }
    }

    showOverlapError() {
        const salaSelect = document.querySelector('select[name="sala"]');
        if (salaSelect) {
            this.applyValidationStyling(salaSelect, false, 'Esta sala ya está reservada para la fecha y hora seleccionadas.');
        }
    }

    applyValidationStyling(input, isValid, errorMessage) {
        const formGroup = input.closest('.form-group');

        // Remove previous validation classes
        input.classList.remove('is-valid', 'is-invalid');
        formGroup?.classList.remove('has-success', 'has-error');

        if (input.value.trim() === '') {
            // Don't show validation for empty fields
            return;
        }

        if (isValid) {
            input.classList.add('is-valid');
            formGroup?.classList.add('has-success');
        } else {
            input.classList.add('is-invalid');
            formGroup?.classList.add('has-error');
        }

        // Update or create error message
        this.updateErrorMessage(formGroup, errorMessage, isValid);
    }

    updateErrorMessage(formGroup, message, isValid) {
        let errorElement = formGroup.querySelector('.field-error');

        if (!isValid && message) {
            if (!errorElement) {
                errorElement = document.createElement('div');
                errorElement.className = 'field-error';
                formGroup.appendChild(errorElement);
            }
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        } else if (errorElement) {
            errorElement.style.display = 'none';
        }
    }

    clearFieldValidation(input) {
        const formGroup = input.closest('.form-group');
        input.classList.remove('is-valid', 'is-invalid');
        formGroup?.classList.remove('has-success', 'has-error');

        const errorElement = formGroup?.querySelector('.field-error');
        if (errorElement) {
            errorElement.style.display = 'none';
        }
    }

    showFieldFocus(input) {
        const formGroup = input.closest('.form-group');
        formGroup?.classList.add('field-focused');
    }

    hideFieldFocus(input) {
        const formGroup = input.closest('.form-group');
        formGroup?.classList.remove('field-focused');
    }

    handleFormSubmission(e) {
        const form = e.target;
        const inputs = form.querySelectorAll('input, select, textarea');
        let isFormValid = true;

        // Validate all fields
        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isFormValid = false;
            }
        });

        if (!isFormValid) {
            e.preventDefault();

            // Show form-level error
            this.showFormError(form, 'Por favor, corrija los errores en el formulario antes de enviar.');

            // Scroll to first error
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        } else {
            // Show loading state
            this.showFormLoading(form);
        }
    }

    showFormError(form, message) {
        let errorElement = form.querySelector('.form-error');
        if (!errorElement) {
            errorElement = document.createElement('div');
            errorElement.className = 'form-error alert alert-danger';
            form.insertBefore(errorElement, form.firstChild);
        }
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }

    showFormLoading(form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<iconify-icon icon="mdi:loading" class="animate-spin"></iconify-icon> Procesando...';
        }
    }
}

// Initialize validator when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.formValidator = new FormValidator();
});

// Re-bind validation after dynamic content changes
function rebindValidation() {
    if (window.formValidator) {
        window.formValidator.bindValidation();
        window.formValidator.bindFormSubmission();
    }
}
