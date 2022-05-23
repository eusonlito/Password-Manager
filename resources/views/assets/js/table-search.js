(function (cash) {
    'use strict';

    const search = function (e) {
        if ((e.code === 'Enter') || (e.code === 'NumpadEnter')) {
            return e.preventDefault();
        }

        if (e.type !== 'input') {
            return;
        }

        const $table = document.querySelector(this.dataset.tableSearch);
        const $trs = cash($table).find('tbody > tr');
        const value = this.value.toLowerCase().trim();

        if (!value.length) {
            return searchReset($table, $trs);
        }

        $table.dispatchEvent(new CustomEvent('search', { detail: value }));

        $trs.each(function () {
            this.style.display = ((this.textContent || this.innerText).toLowerCase().indexOf(value) > -1) ? 'table-row' : 'none';
        });
    };

    const searchReset = function ($table, $trs) {
        $trs.each(function () {
            this.style.display = (this.dataset.tablePaginationHidden === 'true') ? 'none' : 'table-row';
        });

        $table.dispatchEvent(new CustomEvent('search', { detail: '' }));
    };

    function load(element) {
        if (element.dataset.tableSortLoaded) {
            return;
        }

        cash(element).on('input', search).on('keydown', search)

        element.dataset.tableSortLoaded = true;
    }

    function init () {
        document.querySelectorAll('[data-table-search]').forEach(load);
    }

    document.addEventListener('ajax', init);

    init();
})(cash);
