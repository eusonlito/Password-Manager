import Velocity from 'velocity-animate';

(function (cash) {
    'use strict';

    cash('.side-menu').on('click', function () {
        const $this = cash(this);

        if (!$this.parent().find('ul').length) {
            return;
        }

        if ($this.parent().find('ul').first()[0].offsetParent !== null) {
            $this.find('.side-menu__sub-icon').removeClass('transform rotate-180');
            $this.removeClass('side-menu--open');

            Velocity($this.parent().find('ul').first(), 'slideUp', {
                duration: 300,
                complete: el => cash(el).removeClass('side-menu__sub-open'),
            });
        } else {
            $this.find('.side-menu__sub-icon').addClass('transform rotate-180');
            $this.addClass('side-menu--open');

            Velocity($this.parent().find('ul').first(), 'slideDown', {
                duration: 300,
                complete: el => cash(el).addClass('side-menu__sub-open'),
            });
        }
    });
})(cash);
