(function (cash) {
    'use strict';

    cash('[data-change-submit]').on('change', function (e) {
        const form = this.closest('form');

        if (!form) {
            return;
        }

        e.preventDefault();

        form.submit();
    });

    cash('[data-click-one]').on('click', function (e) {
        const form = this.closest('form');

        if (!form) {
            return;
        }

        e.preventDefault();

        this.disabled = true;

        const input = document.createElement('input');

        input.type = 'hidden';
        input.name = this.name;
        input.value = this.value;

        form.appendChild(input);
        form.submit();
    });

    cash('[data-link-boolean]').on('click', function (e) {
        e.preventDefault();

        const link = this;

        ajax(link.href, function(response) {
            const value = response[link.dataset.linkBoolean];

            link.innerHTML = '<span class="' + (value ? 'text-theme-10' : 'text-theme-24') + '">'
                + '<svg class="feather w-4 h-4 mr-2"><use xlink:href="' + WWW + '/build/images/feather-sprite.svg#' + (value ? 'check-square' : 'square') + '" /></svg>'
                + '</span>';
        });
    });

    cash('[data-password-show]').on('click', function (e) {
        e.preventDefault();

        const field = byQuery(this.dataset.passwordShow);

        if (!field) {
            return;
        }

        let hidden;

        if (field.tagName.toLowerCase() === 'textarea') {
            hidden = field.classList.contains('textarea-password');
            field.classList.toggle('textarea-password');
        } else {
            hidden = field.type === 'password';
            field.type = hidden ? 'text' : 'password';
        }

        this.querySelector('svg:first-child').innerHTML = '<use xlink:href="' + WWW + '/build/images/feather-sprite.svg#' + (hidden ? 'eye-off' : 'eye') + '" />';
    });

    cash('[data-password-generate]').on('click', function (e) {
        e.preventDefault();

        function password () {
            return Array(Math.floor(Math.random() * (16 - 12 + 1) + 12))
                .fill('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!$%&/()=?[]{}+-_:;')
                .map((x) => x[Math.floor(Math.random() * x.length)])
                .join('');
        }

        function uuid() {
            return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, c =>
                (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
            );
        }

        let value;

        if (this.dataset.passwordGenerateFormat === 'uuid') {
            value = uuid();
        } else {
            value = password();
        }

        byQuery(this.dataset.passwordGenerate, {}).value = value;
    });

    cash('[data-disabled]').each(function (e) {
        cash('input, select, textarea', this).prop('disabled', true);
    });
})(cash);

(function (cash) {
    'use strict';

     function decode(encoded) {
        const hex = atob(encoded).split('\\x');
        let decoded = '';

        for (let i = 0; i < hex.length; i++) {
            decoded += hex2char(hex[i]);
        }

        return decoded;
    }

     function hex2char(hex) {
        const groups = hex.match(/[\s\S]{2}/g) || [];
        let char = '';

        for (var i = 0, j = groups.length; i < j; i++) {
            char += '%' + ('0' + groups[i]).slice(-2);
        }

        return decodeURIComponent(char);
    }

    cash('[data-copy]').on('click', function (e) {
        e.preventDefault();

        if (this.dataset.copyTarget) {
            clipboard(byQuery(this.dataset.copyTarget, {}).value);
        } else {
            clipboard(this.dataset.copy || this.innerHTML);
        }
    });

    cash('[data-copy-ajax]').on('click', function (e) {
        e.preventDefault();

        if (!this.dataset.copyAjax) {
            return;
        }

        ajax(this.dataset.copyAjax, null, function (data) {
            clipboard(decode(data.value));
        });
    });
})(cash);
