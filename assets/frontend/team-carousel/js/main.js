'use strict';
(function ($, w) {
    var $window = $(w);
    $window.on('elementor/frontend/init', function() {
        var EF = elementorFrontend,
            EM = elementorModules;
        var CarouselBase = EM.frontend.handlers.Base.extend({
            onInit: function () {
                EM.frontend.handlers.Base.prototype.onInit.apply(this, arguments);
                this.$container = this.$element.find('.hajs-slick');
                this.run();
            },
            getDefaultSettings: function () {
                return {
                    selectors: {
                        container: '.ha-carousel-container'
                    },
                    arrows: false,
                    dots: false,
                    checkVisible: false,
                    infinite: true,
                    slidesToShow: 3,
                    rows: 0,
                    prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
                    nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
                }
            },
            getDefaultElements: function () {
                var selectors = this.getSettings('selectors');
                return {
                    $container: this.findElement(selectors.container)
                };
            },

            onElementChange: function () {
                this.elements.$container.slick('unslick');
                this.run();
            },

            getReadySettings: function () {
                var settings = {
                    infinite: !!this.getElementSettings('loop'),
                    autoplay: !!this.getElementSettings('autoplay'),
                    autoplaySpeed: this.getElementSettings('autoplay_speed'),
                    speed: this.getElementSettings('animation_speed'),
                    centerMode: !!this.getElementSettings('center'),
                    vertical: !!this.getElementSettings('vertical'),
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

                settings.slidesToShow = this.getElementSettings('slides_to_show') || 3;
                settings.responsive = [
                    {
                        breakpoint: elementorFrontend.config.breakpoints.lg,
                        settings: {
                            slidesToShow: (this.getElementSettings('slides_to_show_tablet') || settings.slidesToShow),
                        }
                    },
                    {
                        breakpoint: elementorFrontend.config.breakpoints.md,
                        settings: {
                            slidesToShow: (this.getElementSettings('slides_to_show_mobile') || this.getElementSettings('slides_to_show_tablet')) || settings.slidesToShow,
                        }
                    }
                ];

                return $.extend({}, this.getSettings(), settings);
            },

            run: function () {
                this.elements.$container.slick(this.getReadySettings());
            }

        });
        EF.hooks.addAction( 'frontend/element_ready/pixerex-team-carousel.default', function( $scope ) {
            EF.elementsHandler.addHandler( CarouselBase, {
                $element: $scope,
                selectors: {
                    container: '.ha-team-carousel-wrap',
                },
                prevArrow: '<button type="button" class="slick-prev"><i class="hm hm-arrow-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="hm hm-arrow-right"></i></button>'
            });
        });
    })
}(jQuery, window))