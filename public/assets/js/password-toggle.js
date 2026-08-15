(function () {
    'use strict';

    function syncButton(button, input) {
        var showing = input.type === 'text';
        var icon = button.querySelector('i');

        button.classList.toggle('is-revealed', showing);
        button.setAttribute('aria-pressed', showing ? 'true' : 'false');
        button.setAttribute('aria-label', showing ? 'Hide password' : 'Show password');
        button.setAttribute('title', showing ? 'Hide password' : 'Show password');

        if (icon) {
            icon.classList.toggle('fa-eye', !showing);
            icon.classList.toggle('fa-eye-slash', showing);
        }
    }

    document.addEventListener('click', function (event) {
        var button = event.target.closest('.password-toggle');
        if (!button) return;

        var field = button.closest('.password-field');
        var input = field ? field.querySelector('input') : null;
        if (!input) return;

        input.type = input.type === 'password' ? 'text' : 'password';
        syncButton(button, input);
        input.focus({ preventScroll: true });

        try {
            var end = input.value.length;
            input.setSelectionRange(end, end);
        } catch (e) {
            // Some input implementations do not support selection ranges.
        }
    });

    document.addEventListener('input', function (event) {
        var input = event.target.closest('.password-field input');
        if (!input) return;

        var field = input.closest('.password-field');
        var button = field ? field.querySelector('.password-toggle') : null;
        if (!button) return;

        // Returning to an empty field always restores secure/masked mode.
        if (input.value.length === 0 && input.type === 'text') {
            input.type = 'password';
        }
        syncButton(button, input);
    });

    document.addEventListener('reset', function (event) {
        window.setTimeout(function () {
            event.target.querySelectorAll('.password-field').forEach(function (field) {
                var input = field.querySelector('input');
                var button = field.querySelector('.password-toggle');
                if (!input || !button) return;
                input.type = 'password';
                syncButton(button, input);
            });
        }, 0);
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.password-field').forEach(function (field) {
            var input = field.querySelector('input');
            var button = field.querySelector('.password-toggle');
            if (input && button) syncButton(button, input);
        });
    });
})();
