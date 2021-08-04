import Velocity from 'velocity-animate';

(function (cash) {
    'use strict';

    cash('#mobile-menu-toggler').on('click', function () {
        if (cash('.mobile-menu').find('ul').first()[0].offsetParent !== null) {
            Velocity(cash('.mobile-menu').find('ul').first(), 'slideUp');
        } else {
            Velocity(cash('.mobile-menu').find('ul').first(), 'slideDown');
        }
    });

    cash('.mobile-menu').find('.menu').on('click', function () {
        if (!cash(this).parent().find('ul').length) {
            return;
        }

        if (cash(this).parent().find('ul').first()[0].offsetParent !== null) {
            cash(this).find('.menu__sub-icon').removeClass('transform rotate-180');

            Velocity(cash(this).parent().find('ul').first(), 'slideUp', {
                duration: 300,
                complete: el => cash(this).removeClass('menu__sub-open'),
            });
        } else {
            cash(this).find('.menu__sub-icon').addClass('transform rotate-180');

            Velocity(cash(this).parent().find('ul').first(), 'slideDown', {
                duration: 300,
                complete: el => cash(this).addClass('menu__sub-open'),
            });
        }
    });
})(cash);
