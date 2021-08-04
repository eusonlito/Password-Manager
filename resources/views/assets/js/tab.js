(function (cash) {
    'use strict';

    cash('body').on('click', 'a[data-toggle="tab"]', function (key, el) {
        const $this = cash(this);

        $this.closest('.nav-tabs').find('a[data-toggle="tab"]').removeClass('active').attr('aria-selected', false);
        $this.addClass('active').attr('aria-selected', true);

        let element = cash($this.attr('data-target'));

        element.closest('.tab-content').children('.tab-pane').removeClass('active');
        element.addClass('active');
    });
})(cash);
