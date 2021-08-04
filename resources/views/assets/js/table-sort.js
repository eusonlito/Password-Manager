(function (cash) {
    'use strict';

    const cellValue = function ($td) {
        return $td.dataset.tableSortValue || ($td.innerText || $td.textContent).trim();
    };

    const sort = function ($table, col, reverse) {
        let $body = $table.tBodies[0],
            $trs = Array.prototype.slice.call($body.rows, 0);

        reverse = -((+reverse) || -1);

        $trs = $trs.sort(function ($a, $b) {
            const aValue = cellValue($a.cells[col]);
            const bValue = cellValue($b.cells[col]);

            if (!isNaN(aValue) && !isNaN(bValue)) {
                return reverse * (aValue - bValue);
            }

            return reverse * aValue.localeCompare(bValue);
        });

        for (let i = 0; i < $trs.length; ++i) {
            $body.appendChild($trs[i]);
        }

        $table.dispatchEvent(new CustomEvent('reset', { detail: 'sort' }));
    };

    cash('[data-table-sort]').each(function (e) {
        const $table = this;
        const $ths = this.tHead.rows[0].cells;
        let i = $ths.length;

        while (--i >= 0) (function (i) {
            let dir = 1;

            $ths[i].addEventListener('click', function () {
                sort($table, i, (dir = 1 - dir));
            });
        }(i));
    });
})(cash);