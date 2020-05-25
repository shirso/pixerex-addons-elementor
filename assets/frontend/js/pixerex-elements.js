'use strict';
(function ($, w) {
    var $window = $(w);

    $.fn.getHappySettings = function() {
        return this.data('happy-settings');
    };


}(jQuery, window));