// Interactive Calendar Component with Dominican Republic Timezone
// CampusRoom - NeoTaiwan Modern Tech Design System

class InteractiveCalendar {
    constructor(options = {}) {
        this.options = {
            container: options.container || '#calendar-container',
            timezone: 'America/Santo_Domingo',
            minDate: new Date(),
            maxDate: new Date(Date.now() + 365 * 24 * 60 * 60 * 1000), // 1 year from now
            onDateSelect: options.onDateSelect || null,
            selectedDate: options.selectedDate || null,
            ...options
        };

        this.currentDate = new Date();
        this.selectedDate = this.options.selectedDate;
        this.calendarElement = null;
        this.init();
    }

    init() {
        this.createCalendar();
        this.render();
        this.bindEvents();
    }

    createCalendar() {
        const container = document.querySelector(this.options.container);
        if (!container) return;

        container.innerHTML = `
            <div class="calendar-wrapper">
                <div class="calendar-header">
                    <button class="calendar-nav prev-month" aria-label="Mes anterior">
                        <iconify-icon icon="mdi:chevron-left"></iconify-icon>
                    </button>
                    <h3 class="calendar-title"></h3>
                    <button class="calendar-nav next-month" aria-label="Mes siguiente">
                        <iconify-icon icon="mdi:chevron-right"></iconify-icon>
                    </button>
                </div>
                <div class="calendar-grid">
                    <div class="weekdays">
                        <div>Dom</div>
                        <div>Lun</div>
                        <div>Mar</div>
                        <div>Mié</div>
                        <div>Jue</div>
                        <div>Vie</div>
                        <div>Sáb</div>
                    </div>
                    <div class="days"></div>
                </div>
            </div>
        `;

        this.calendarElement = container.querySelector('.calendar-wrapper');
    }

    render() {
        this.updateHeader();
        this.renderDays();
    }

    updateHeader() {
        const title = this.calendarElement.querySelector('.calendar-title');
        const monthNames = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];

        title.textContent = `${monthNames[this.currentDate.getMonth()]} ${this.currentDate.getFullYear()}`;
    }

    renderDays() {
        const daysContainer = this.calendarElement.querySelector('.days');
        daysContainer.innerHTML = '';

        const year = this.currentDate.getFullYear();
        const month = this.currentDate.getMonth();

        // First day of the month
        const firstDay = new Date(year, month, 1);
        const startingDayOfWeek = firstDay.getDay();

        // Last day of the month
        const lastDay = new Date(year, month + 1, 0);
        const totalDays = lastDay.getDate();

        // Previous month's days to fill the grid
        const prevMonthLastDay = new Date(year, month, 0);
        const prevMonthDays = prevMonthLastDay.getDate();

        // Create calendar grid
        let dayCounter = 1;
        let nextMonthDayCounter = 1;

        for (let i = 0; i < 42; i++) { // 6 weeks * 7 days
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';

            let dayNumber;
            let isCurrentMonth = true;
            let isToday = false;
            let isSelected = false;
            let isDisabled = false;

            if (i < startingDayOfWeek) {
                // Previous month days
                dayNumber = prevMonthDays - startingDayOfWeek + i + 1;
                isCurrentMonth = false;
                dayElement.classList.add('prev-month');
            } else if (dayCounter <= totalDays) {
                // Current month days
                dayNumber = dayCounter;

                const currentDateObj = new Date(year, month, dayNumber);
                const today = new Date();

                // Reset time for date comparison
                const todayNormalized = new Date(today.getFullYear(), today.getMonth(), today.getDate());
                const currentNormalized = new Date(currentDateObj.getFullYear(), currentDateObj.getMonth(), currentDateObj.getDate());

                isToday = currentNormalized.getTime() === todayNormalized.getTime();
                isSelected = this.selectedDate &&
                           this.selectedDate.getFullYear() === year &&
                           this.selectedDate.getMonth() === month &&
                           this.selectedDate.getDate() === dayNumber;

                // Check if date is within allowed range
                isDisabled = currentNormalized < this.options.minDate || currentNormalized > this.options.maxDate;

                dayCounter++;
            } else {
                // Next month days
                dayNumber = nextMonthDayCounter;
                isCurrentMonth = false;
                dayElement.classList.add('next-month');
                nextMonthDayCounter++;
            }

            dayElement.textContent = dayNumber;

            // Apply classes
            if (isCurrentMonth) {
                dayElement.classList.add('current-month');
            }

            if (isToday) {
                dayElement.classList.add('today');
            }

            if (isSelected) {
                dayElement.classList.add('selected');
            }

            if (isDisabled) {
                dayElement.classList.add('disabled');
            } else {
                dayElement.classList.add('clickable');
            }

            // Add accessibility attributes
            dayElement.setAttribute('role', 'button');
            dayElement.setAttribute('tabindex', isDisabled ? -1 : 0);
            dayElement.setAttribute('aria-label', this.getDayAriaLabel(dayNumber, month, year, isCurrentMonth));

            daysContainer.appendChild(dayElement);
        }
    }

    getDayAriaLabel(day, month, year, isCurrentMonth) {
        const monthNames = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];

        if (!isCurrentMonth) {
            return `${day} de ${monthNames[month]} ${year}`;
        }

        const date = new Date(year, month, day);
        const today = new Date();
        const isToday = date.toDateString() === today.toDateString();

        let label = `${day} de ${monthNames[month]} ${year}`;
        if (isToday) {
            label += ', hoy';
        }
        if (this.selectedDate && date.toDateString() === this.selectedDate.toDateString()) {
            label += ', seleccionado';
        }

        return label;
    }

    bindEvents() {
        // Navigation buttons
        const prevBtn = this.calendarElement.querySelector('.prev-month');
        const nextBtn = this.calendarElement.querySelector('.next-month');

        prevBtn.addEventListener('click', () => this.navigateMonth(-1));
        nextBtn.addEventListener('click', () => this.navigateMonth(1));

        // Day selection
        const daysContainer = this.calendarElement.querySelector('.days');
        daysContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('clickable')) {
                this.selectDay(e.target);
            }
        });

        // Keyboard navigation
        this.calendarElement.addEventListener('keydown', (e) => {
            this.handleKeydown(e);
        });
    }

    navigateMonth(direction) {
        this.currentDate.setMonth(this.currentDate.getMonth() + direction);
        this.render();

        // Announce navigation to screen readers
        const title = this.calendarElement.querySelector('.calendar-title');
        this.announceToScreenReader(`Navegando a ${title.textContent}`);
    }

    selectDay(dayElement) {
        const dayNumber = parseInt(dayElement.textContent);
        const year = this.currentDate.getFullYear();
        const month = this.currentDate.getMonth();

        // Determine if it's current month or adjacent month
        if (dayElement.classList.contains('prev-month')) {
            const prevMonth = new Date(year, month - 1, dayNumber);
            this.selectedDate = prevMonth;
            this.currentDate = new Date(prevMonth.getFullYear(), prevMonth.getMonth(), 1);
        } else if (dayElement.classList.contains('next-month')) {
            const nextMonth = new Date(year, month + 1, dayNumber);
            this.selectedDate = nextMonth;
            this.currentDate = new Date(nextMonth.getFullYear(), nextMonth.getMonth(), 1);
        } else {
            this.selectedDate = new Date(year, month, dayNumber);
        }

        this.render();

        // Trigger callback
        if (this.options.onDateSelect) {
            this.options.onDateSelect(this.selectedDate);
        }

        // Announce selection to screen readers
        this.announceToScreenReader(`Fecha seleccionada: ${this.formatDateForScreenReader(this.selectedDate)}`);
    }

    handleKeydown(e) {
        const focusedDay = this.calendarElement.querySelector('.calendar-day:focus');
        if (!focusedDay) return;

        let newFocusedDay = null;

        switch (e.key) {
            case 'ArrowUp':
                e.preventDefault();
                newFocusedDay = this.getAdjacentDay(focusedDay, -7);
                break;
            case 'ArrowDown':
                e.preventDefault();
                newFocusedDay = this.getAdjacentDay(focusedDay, 7);
                break;
            case 'ArrowLeft':
                e.preventDefault();
                newFocusedDay = this.getAdjacentDay(focusedDay, -1);
                break;
            case 'ArrowRight':
                e.preventDefault();
                newFocusedDay = this.getAdjacentDay(focusedDay, 1);
                break;
            case 'Enter':
            case ' ':
                e.preventDefault();
                if (focusedDay.classList.contains('clickable')) {
                    this.selectDay(focusedDay);
                }
                break;
            case 'Home':
                e.preventDefault();
                newFocusedDay = this.getFirstDayOfMonth();
                break;
            case 'End':
                e.preventDefault();
                newFocusedDay = this.getLastDayOfMonth();
                break;
        }

        if (newFocusedDay) {
            newFocusedDay.focus();
        }
    }

    getAdjacentDay(currentDay, offset) {
        const days = Array.from(this.calendarElement.querySelectorAll('.calendar-day'));
        const currentIndex = days.indexOf(currentDay);
        const newIndex = Math.max(0, Math.min(days.length - 1, currentIndex + offset));
        return days[newIndex];
    }

    getFirstDayOfMonth() {
        return this.calendarElement.querySelector('.calendar-day.current-month');
    }

    getLastDayOfMonth() {
        const currentMonthDays = this.calendarElement.querySelectorAll('.calendar-day.current-month');
        return currentMonthDays[currentMonthDays.length - 1];
    }

    formatDateForScreenReader(date) {
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        return date.toLocaleDateString('es-DO', options);
    }

    announceToScreenReader(message) {
        const announcement = document.createElement('div');
        announcement.setAttribute('aria-live', 'polite');
        announcement.setAttribute('aria-atomic', 'true');
        announcement.style.position = 'absolute';
        announcement.style.left = '-10000px';
        announcement.style.width = '1px';
        announcement.style.height = '1px';
        announcement.style.overflow = 'hidden';

        announcement.textContent = message;
        document.body.appendChild(announcement);

        setTimeout(() => {
            document.body.removeChild(announcement);
        }, 1000);
    }

    // Public methods
    setSelectedDate(date) {
        this.selectedDate = date;
        this.currentDate = new Date(date.getFullYear(), date.getMonth(), 1);
        this.render();
    }

    getSelectedDate() {
        return this.selectedDate;
    }

    destroy() {
        if (this.calendarElement) {
            this.calendarElement.remove();
        }
    }
}

// Initialize calendar when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Auto-initialize calendars with data-calendar attribute
    const calendarContainers = document.querySelectorAll('[data-calendar]');
    calendarContainers.forEach(container => {
        const options = {
            container: '#' + container.id,
            onDateSelect: (date) => {
                // Update associated input field
                const inputId = container.dataset.input;
                if (inputId) {
                    const input = document.getElementById(inputId);
                    if (input) {
                        const formattedDate = date.toLocaleDateString('es-DO', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                        input.value = formattedDate;
                        input.dispatchEvent(new Event('input'));
                        input.dispatchEvent(new Event('change'));
                    }
                }
            }
        };

        window.calendar = new InteractiveCalendar(options);
    });
});
