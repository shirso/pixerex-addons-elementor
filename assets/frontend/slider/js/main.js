'use strict';
(function ($, w) {
    var $window = $(w);
    $window.on('elementor/frontend/init', function() {
        var EF = elementorFrontend,
            EM = elementorModules;
        var Slick = EM.frontend.handlers.Base.extend({
            onInit: function () {
                EM.frontend.handlers.Base.prototype.onInit.apply(this, arguments);
                this.$container = this.$element.find('.hajs-slick');
                this.run();
            },

            isCarousel: function() {
                return this.$element.hasClass('ha-carousel');
            },

            getDefaultSettings: function() {
                return {
                    arrows: false,
                    dots: false,
                    checkVisible: false,
                    infinite: true,
                    slidesToShow: this.isCarousel() ? 3 : 1,
                    rows: 0,
                    prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
                    nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
                }
            },

            onElementChange: function() {
                this.$container.slick('unslick');
                this.run();
            },

            getReadySettings: function() {
                var settings = {
                    infinite: !! this.getElementSettings('loop'),
                    autoplay: !! this.getElementSettings('autoplay'),
                    autoplaySpeed: this.getElementSettings('autoplay_speed'),
                    speed: this.getElementSettings('animation_speed'),
                    centerMode: !! this.getElementSettings('center'),
                    vertical: !! this.getElementSettings('vertical'),
                    slidesToScroll: 1,
                };

                switch (this.getElementSettings('navigation')) {
                    case 'arrow':
                        settings.arrows = true;
                        break;
                    case 'dots':
                        settings.dots = true;
                        break;
                    case 'both':
                        settings.arrows = true;
                        settings.dots = true;
                        break;
                }

                if (this.isCarousel()) {
                    settings.slidesToShow = this.getElementSettings('slides_to_show') || 3;
                    settings.responsive = [
                        {
                            breakpoint: EF.config.breakpoints.lg,
                            settings: {
                                slidesToShow: (this.getElementSettings('slides_to_show_tablet') || settings.slidesToShow),
                            }
                        },
                        {
                            breakpoint: EF.config.breakpoints.md,
                            settings: {
                                slidesToShow: (this.getElementSettings('slides_to_show_mobile') || this.getElementSettings('slides_to_show_tablet')) || settings.slidesToShow,
                            }
                        }
                    ];
                }

                return $.extend({}, this.getDefaultSettings(), settings);
            },

            run: function() {
                this.$container.slick(this.getReadySettings());
            }
        });

        EF.hooks.addAction( 'frontend/element_ready/pixerex-slider.default', function( $scope ) {
            EF.elementsHandler.addHandler( Slick, { $element: $scope });
        });
    })
}(jQuery, window))
