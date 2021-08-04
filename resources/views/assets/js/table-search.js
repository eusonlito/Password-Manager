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

        $trs.each(function () {
            this.style.display = ((this.textContent || this.innerText).toLowerCase().indexOf(value) > -1) ? 'table-row' : 'none';
        });
    };

    const searchReset = function ($table, $trs) {
        $trs.each(function () {
            this.style.display = (this.dataset.tablePaginationHidden === 'true') ? 'none' : 'table-row';
        });

        $table.dispatchEvent(new CustomEvent('reset', { detail: 'search' }));
    };

    cash('[data-table-search]').on('input', search);
    cash('[data-table-search]').on('keydown', search);
})(cash);
