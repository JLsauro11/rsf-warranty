(function (window, document) {
    'use strict';

    function toIsoDate(date) {
        const local = new Date(date.getTime() - (date.getTimezoneOffset() * 60000));
        return local.toISOString().slice(0, 10);
    }

    function prettyDate(value) {
        if (!value) return '';
        const date = new Date(value + 'T00:00:00');
        return date.toLocaleDateString(undefined, {
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        });
    }

    function buildRange(type) {
        const today = new Date();
        const end = new Date(today.getFullYear(), today.getMonth(), today.getDate());
        const start = new Date(end);

        if (type === 'today') {
            return [toIsoDate(start), toIsoDate(end)];
        }

        if (type === 'month') {
            start.setDate(1);
            return [toIsoDate(start), toIsoDate(end)];
        }

        const days = Number(type);
        if (Number.isFinite(days) && days > 0) {
            start.setDate(start.getDate() - (days - 1));
            return [toIsoDate(start), toIsoDate(end)];
        }

        return ['', ''];
    }

    function initWarrantyDateFilter(options) {
        options = options || {};
        const root = document.querySelector(options.root || '[data-warranty-date-filter]');
        const table = options.table;

        if (!root || !table || root.dataset.initialized === 'true') return;
        root.dataset.initialized = 'true';

        const fromInput = root.querySelector('#fromDate');
        const toInput = root.querySelector('#toDate');
        const applyButton = root.querySelector('#filterBtn');
        const clearButton = root.querySelector('#clearFilterBtn');
        const status = root.querySelector('#dateFilterStatus');
        const statusText = status ? status.querySelector('span') : null;
        const presets = root.querySelectorAll('[data-range]');
        const today = toIsoDate(new Date());

        fromInput.max = today;
        toInput.max = today;

        function setStatus(message, state) {
            if (!status || !statusText) return;
            statusText.textContent = message;
            status.classList.remove('is-error', 'is-active', 'is-loading');
            if (state) status.classList.add('is-' + state);
        }

        function validate(showMessage) {
            const from = fromInput.value;
            const to = toInput.value;
            let message = '';

            root.classList.remove('is-invalid');
            fromInput.classList.remove('is-invalid');
            toInput.classList.remove('is-invalid');

            if (from && to && from > to) {
                message = 'From date cannot be later than To date.';
                root.classList.add('is-invalid');
                fromInput.classList.add('is-invalid');
                toInput.classList.add('is-invalid');
            } else if ((from && from > today) || (to && to > today)) {
                message = 'Future purchase dates are not allowed.';
                root.classList.add('is-invalid');
                if (from > today) fromInput.classList.add('is-invalid');
                if (to > today) toInput.classList.add('is-invalid');
            }

            applyButton.disabled = Boolean(message);

            if (message && showMessage) {
                setStatus(message, 'error');
            }

            return !message;
        }

        function describeRange() {
            const from = fromInput.value;
            const to = toInput.value;

            if (from && to) return prettyDate(from) + ' - ' + prettyDate(to);
            if (from) return 'From ' + prettyDate(from);
            if (to) return 'Up to ' + prettyDate(to);
            return 'All purchase dates';
        }

        function updatePresetState() {
            presets.forEach(function (button) {
                const range = buildRange(button.dataset.range);
                button.classList.toggle(
                    'is-active',
                    fromInput.value === range[0] && toInput.value === range[1]
                );
            });
        }

        function reloadTable(resetPaging) {
            if (!validate(true)) return;

            setStatus('Updating records...', 'loading');
            applyButton.disabled = true;

            table.ajax.reload(function () {
                const count = table.rows({ search: 'applied' }).count();
                const rangeText = describeRange();
                const noun = count === 1 ? 'record' : 'records';
                const isFiltered = Boolean(fromInput.value || toInput.value);

                setStatus(
                    isFiltered
                        ? count + ' ' + noun + ' • ' + rangeText
                        : count + ' ' + noun + ' • All purchase dates',
                    isFiltered ? 'active' : null
                );

                applyButton.disabled = false;
                updatePresetState();
                table.columns.adjust().draw(false);
            }, resetPaging !== false);
        }

        applyButton.addEventListener('click', function () {
            reloadTable(true);
        });

        clearButton.addEventListener('click', function () {
            fromInput.value = '';
            toInput.value = '';
            validate(false);
            updatePresetState();
            reloadTable(true);
        });

        presets.forEach(function (button) {
            button.addEventListener('click', function () {
                const range = buildRange(button.dataset.range);
                fromInput.value = range[0];
                toInput.value = range[1];
                validate(false);
                updatePresetState();
                reloadTable(true);
            });
        });

        [fromInput, toInput].forEach(function (input) {
            input.addEventListener('change', function () {
                validate(true);
                updatePresetState();
            });

            input.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    reloadTable(true);
                }
            });
        });

        validate(false);
        updatePresetState();
    }

    window.initWarrantyDateFilter = initWarrantyDateFilter;
})(window, document);
