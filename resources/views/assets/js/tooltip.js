import tippy, { roundArrow } from 'tippy.js';

(function (cash) {
    'use strict';

    cash('.tooltip').each(function () {
        tippy(this, {
            trigger: 'click',
            animation: 'shift-away',
            hideOnClick: true,
            onShow(instance) {
                setTimeout(() => instance.hide(), 1000);
            }
        });
    });
})(cash);
