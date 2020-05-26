'use strict';
(function ($, w) {
    var $window = $(w);

    var PixerexHandleImageCompare = function($scope) {
        var $item = $scope.find('.hajs-image-comparison'),
            settings = $item.getHappySettings(),
            fieldMap = {
                on_hover: 'move_slider_on_hover',
                on_swipe: 'move_with_handle_only',
                on_click: 'click_to_move'
            };
        settings[fieldMap[settings.move_handle || 'on_swipe']] = true;
        delete settings.move_handle;

        $item.imagesLoaded().done(function() {
            $item.twentytwenty(settings);

            var t = setTimeout(function() {
                $window.trigger('resize.twentytwenty');
                clearTimeout(t);
            }, 400);
        });
    };

    $window.on('elementor/frontend/init', function() {
        var EF = elementorFrontend;
        EF.hooks.addAction( 'frontend/element_ready/pixerex-image-compare.default', PixerexHandleImageCompare );
    })
}(jQuery, window));