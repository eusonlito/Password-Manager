(function (cash) {
    'use strict';

    function create($table, total, limit) {
        const $paginator = paginator($table);
        const pages = parseInt((total / limit) + (((total % limit) === 0) ? 0 : 1));

        $paginator.insertAdjacentHTML('beforeend', '<li><a href="javascript:;" class="pagination__link" data-table-pagination-navigate="first">&Lt;</a></li>');
        $paginator.insertAdjacentHTML('beforeend', '<li><a href="javascript:;" class="pagination__link" data-table-pagination-navigate="previous">&lt;</a></li>');
        $paginator.insertAdjacentHTML('beforeend', '<li><a href="javascript:;" class="pagination__link pagination__link--active whitespace-nowrap" data-table-pagination-navigate="current" data-table-pagination-page="1"></a></li>');
        $paginator.insertAdjacentHTML('beforeend', '<li><a href="javascript:;" class="pagination__link" data-table-pagination-navigate="next">&gt;</a></li>');
        $paginator.insertAdjacentHTML('beforeend', '<li><a href="javascript:;" class="pagination__link" data-table-pagination-navigate="last">&Gt;</a></li>');

        paginate($table, $paginator, $paginator.querySelector('[data-table-pagination-navigate="current"]'));

        $paginator.querySelectorAll('a').forEach(each => each.addEventListener('click', () => paginate($table, $paginator, each), false));

        $table.addEventListener('reset', (e) => reset(e, $table, $paginator), false);
    }

    function paginator($table) {
        if ($table.dataset.tablePagination.length) {
            return document.getElementById($table.dataset.tablePagination);
        }

        const $paginator = document.createElement('ul');

        $paginator.id = $table.id + '-pagination';
        $paginator.classList.add('pagination', 'justify-end');

        $table.parentNode.insertBefore($paginator, $table.nextSibling);

        return $paginator;
    }

    function paginate($table, $paginator, $page) {
        const limit = parseInt($table.dataset.tablePaginationLimit || 20);
        const $trs = $table.querySelectorAll('tbody > tr');
        const $current = $paginator.querySelector('[data-table-pagination-navigate="current"]');

        const total = $trs.length;
        const pages = parseInt((total / limit) + (((total % limit) === 0) ? 0 : 1));
        const action = $page.dataset.tablePaginationNavigate;

        let page = parseInt($current.dataset.tablePaginationPage);

        if (action === 'first') {
            page = 1;
        } else if (action === 'previous') {
            page = page - 1;
        } else if (action === 'next') {
            page = page + 1;
        } else if (action === 'last') {
            page = pages;
        }

        page = (page < 1) ? 1 : ((page > pages) ? pages : page);

        const first = (page - 1) * limit;
        const last = (page * limit) - 1;

        $trs.forEach(function (value, index) {
            const $tr = $trs[index];

            if ((index < first) || (index > last)) {
                $tr.style.display = 'none';
                $tr.dataset.tablePaginationHidden = 'true';
            } else {
                $tr.style.display = 'table-row';
                $tr.dataset.tablePaginationHidden = 'false';
            }
        });

        $current.dataset.tablePaginationPage = page;
        $current.innerHTML = page + ' / ' + pages + '&nbsp;&nbsp;&nbsp;&boxH;&nbsp;&nbsp;&nbsp;' + total;
    }

    function reset(e, $table, $paginator) {
        if (e.detail === 'pagination') {
            return;
        }

        paginate($table, $paginator, $paginator.querySelector('[data-table-pagination-navigate="current"]'));
    }

    cash('[data-table-pagination]').each(function () {
        const $table = this;

        const total = $table.querySelectorAll('tbody > tr').length;
        const limit = parseInt($table.dataset.tablePaginationLimit || 20);

        if (total > limit) {
            create($table, total, limit);
        }

        $table.style.display = 'table';
    });
})(cash);
