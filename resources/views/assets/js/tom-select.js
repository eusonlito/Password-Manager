import TomSelect from 'tom-select';

(function (cash) {
    'use strict';

    cash('.tom-select').each(function () {
        const $this = cash(this);
        let options = {};

        if ($this.data('placeholder')) {
            options.placeholder = $this.data('placeholder');
        }

        if ($this.attr('multiple') !== undefined) {
            options.persist = false;
            options.plugins = ['dropdown_input', 'remove_button'];
        }

        if ($this.data('create') !== undefined) {
            options.create = true;
        }

        new TomSelect(this, options);
    });
})(cash);
