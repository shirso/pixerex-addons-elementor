(function ($) {
    /****** Premium Progress Bar Handler ******/
    var PremiumProgressBarWidgetHandler = function ($scope, $) {
        var progressbarElement = $scope.find(".pixerex-progressbar-progress-bar").each(function () {
            var settings = $(this).data("settings"),
                length = settings["progress_length"],
                speed = settings["speed"];
            $(this).animate({
                width: length + "%"
            }, speed);
        });
    };

    /****** Premium Progress Bar Scroll Handler *****/
    var PremiumProgressBarScrollWidgetHandler = function ($scope, $) {
        elementorFrontend.waypoint($scope, function () {
            PremiumProgressBarWidgetHandler($(this), $);
        }, {
            offset: Waypoint.viewportHeight() - 150,
            triggerOnce: true
        });
    };

    /****** Premium Media Grid Handler ******/
    var PixerexGridWidgetHandler = function ($scope, $) {
        var galleryElement = $scope.find(".pixerex-gallery-container"),
            gridSettings = galleryElement.data("settings"),
            layout = gridSettings["img_size"],
            deviceType = $("body").data("elementor-device-mode"),
            loadMore = gridSettings["load_more"],
            columnWidth = null,
            filter = null,
            isFilterClicked = false,
            minimum = gridSettings["minimum"],
            imageToShow = gridSettings["click_images"],
            counter = minimum,
            ltrMode = gridSettings["ltr_mode"],
            shuffle = gridSettings["shuffle"];
        if (layout === "metro") {
            var suffix = "";
            if ("tablet" === deviceType) {
                suffix = "_tablet";
            } else if ("mobile" === deviceType) {
                suffix = "_mobile";
            }
            var gridWidth = galleryElement.width(),
                cellSize = Math.floor(gridWidth / 12);
            galleryElement.find(".pixerex-gallery-item").each(function (index, item) {
                var cells = $(item).data("metro")["cells" + suffix],
                    vCells = $(item).data("metro")["vcells" + suffix];
                if ("" == cells || undefined == cells) {
                    var cells = $(item).data("metro")["cells"];
                }
                if ("" == vCells || undefined == vCells) {
                    var vCells = $(item).data("metro")["vcells"];
                }
                $(item).css({
                    width: Math.ceil(cells * cellSize),
                    height: Math.ceil(vCells * cellSize)
                });
            });
            layout = "masonry";
            columnWidth = cellSize;
        }
        galleryElement.imagesLoaded(function () {}).done(function () {
            galleryElement.isotope({
                itemSelector: ".pixerex-gallery-item",
                percentPosition: true,
                animationOptions: {
                    duration: 750,
                    easing: "linear"
                },
                filter: gridSettings["active_cat"],
                layoutMode: layout,
                originLeft: ltrMode,
                masonry: {
                    columnWidth: columnWidth
                },
                sortBy: gridSettings["sort_by"]
            });
        });
        if (loadMore) {
            galleryElement.parent().find(".pixerex-gallery-load-more div").addClass(
                "pixerex-gallery-item-hidden");
            if (galleryElement.find(".pixerex-gallery-item").length > minimum) {
                galleryElement.parent().find(".pixerex-gallery-load-more").removeClass(
                    "pixerex-gallery-item-hidden");
                galleryElement.find(".pixerex-gallery-item:gt(" + (minimum - 1) + ")").addClass(
                    "pixerex-gallery-item-hidden");

                function appendItems(imagesToShow) {
                    var instance = galleryElement.data("isotope");
                    galleryElement.find(".pixerex-gallery-item-hidden").removeClass(
                        "pixerex-gallery-item-hidden");
                    galleryElement.parent().find(".pixerex-gallery-load-more").removeClass(
                        "pixerex-gallery-item-hidden");
                    var itemsToHide = instance.filteredItems.slice(imagesToShow, instance
                        .filteredItems.length).map(function (item) {
                        return item.element;
                    });
                    $(itemsToHide).addClass("pixerex-gallery-item-hidden");
                    galleryElement.isotope("layout");
                    if (0 == itemsToHide) {
                        galleryElement.parent().find(".pixerex-gallery-load-more").addClass(
                            "pixerex-gallery-item-hidden");
                    }
                }
                galleryElement.parent().on("click", ".pixerex-gallery-load-more-btn", function () {
                    if (isFilterClicked) {
                        counter = minimum;
                        isFilterClicked = false;
                    } else {
                        counter = counter;
                    }
                    counter = counter + imageToShow;
                    $.ajax({
                        url: appendItems(counter),
                        beforeSend: function () {
                            galleryElement.parent().find(
                                ".pixerex-gallery-load-more div").removeClass(
                                "pixerex-gallery-item-hidden");
                        },
                        success: function () {
                            galleryElement.parent().find(
                                ".pixerex-gallery-load-more div").addClass(
                                "pixerex-gallery-item-hidden");
                        }
                    });
                });
            }
        }
        if ("yes" !== gridSettings["light_box"]) {
            galleryElement.find(".pixerex-gallery-video-wrap").each(function (index, item) {
                var type = $(item).data("type");
                $(item).closest(".pixerex-gallery-item").on("click", function () {
                    var $this = $(this);
                    $this.find(".pr-gallery-img").css("background", "#000");
                    $this.find(
                        "img, .pr-gallery-icons-caption-container, .pr-gallery-icons-wrapper, .pixerex-gallery-caption"
                    ).css("visibility", "hidden");
                    if ("hosted" !== type) {
                        var $iframeWrap = $this.find(".pixerex-gallery-iframe-wrap"),
                            src = $iframeWrap.data("src");

                        src = src.replace("&mute", "&autoplay=1&mute");

                        var $iframe = $("<iframe/>");

                        $iframe.attr("src", src);
                        $iframe.attr("frameborder", "0");
                        $iframe.attr("allowfullscreen", "1");
                        $iframe.attr("allow", "autoplay;encrypted-media;");
                        $iframeWrap.html($iframe);
                        $iframe.css("visibility", "visible");
                    } else {
                        var $video = $(item).find("video");
                        $video.get(0).play();
                        $video.css("visibility", "visible");
                    }
                });
            });
        }
        $scope.find(".pixerex-gallery-cats-container li a").click(function (e) {
            e.preventDefault();
            isFilterClicked = true;
            //Showing all images of category
            $scope.find(".pixerex-gallery-cats-container li .active").removeClass("active");
            $(this).addClass("active");
            filter = $(this).attr("data-filter");
            galleryElement.isotope({
                filter: filter
            });
            if (shuffle) {
                galleryElement.isotope("shuffle");
            }
            if (loadMore) appendItems(minimum);
            return false;
        });
        if ("default" === gridSettings["lightbox_type"]) {
            $scope.find(".pixerex-img-gallery a[data-rel^='prettyPhoto']").prettyPhoto({
                theme: gridSettings["theme"],
                hook: "data-rel",
                opacity: 0.7,
                show_title: false,
                deeplinking: false,
                overlay_gallery: gridSettings["overlay"],
                custom_markup: "",
                default_width: 900,
                default_height: 506,
                social_tools: ""
            });
        }
    };

    /****** Premium Counter Handler ******/
    var PremiumCounterHandler = function ($scope, $) {
        var counterElement = $scope.find(".pixerex-counter");
        elementorFrontend.waypoint(counterElement, function () {
            var counterSettings = counterElement.data(),
                incrementElement = counterElement.find(".pixerex-counter-init"),
                iconElement = counterElement.find(".icon");
            $(incrementElement).numerator(counterSettings);
            $(iconElement).addClass("animated " + iconElement.data("animation"));
        });
    };
    /****** Premium Countdown Handler ******/
    var PremiumCountDownHandler = function ($scope, $) {
        var countDownElement = $scope.find(".pixerex-countdown").each(function () {
            var countDownSettings = $(this).data("settings");
            var label1 = countDownSettings["label1"],
                label2 = countDownSettings["label2"],
                newLabe1 = label1.split(","),
                newLabe2 = label2.split(",");
            if (countDownSettings["event"] === "onExpiry") {
                $(this).find(".pixerex-countdown-init").pre_countdown({
                    labels: newLabe2,
                    labels1: newLabe1,
                    until: new Date(countDownSettings["until"]),
                    format: countDownSettings["format"],
                    padZeroes: true,
                    timeSeparator: countDownSettings["separator"],
                    onExpiry: function () {
                        $(this).html(countDownSettings["text"]);
                    },
                    serverSync: function () {
                        return new Date(countDownSettings["serverSync"]);
                    }
                });
            } else if (countDownSettings["event"] === "expiryUrl") {
                $(this).find(".pixerex-countdown-init").pre_countdown({
                    labels: newLabe2,
                    labels1: newLabe1,
                    until: new Date(countDownSettings["until"]),
                    format: countDownSettings["format"],
                    padZeroes: true,
                    timeSeparator: countDownSettings["separator"],
                    expiryUrl: countDownSettings["text"],
                    serverSync: function () {
                        return new Date(countDownSettings["serverSync"]);
                    }
                });
            }
            times = $(this).find(".pixerex-countdown-init").pre_countdown("getTimes");

            function runTimer(el) {
                return el == 0;
            }
            if (times.every(runTimer)) {
                if (countDownSettings["event"] === "onExpiry") {
                    $(this).find(".pixerex-countdown-init").html(countDownSettings["text"]);
                }
                if (countDownSettings["event"] === "expiryUrl") {
                    var editMode = $("body").find("#elementor").length;
                    if (editMode > 0) {
                        $(this).find(".pixerex-countdown-init").html(
                            "<h1>You can not redirect url from elementor Editor!!</h1>");
                    } else {
                        window.location.href = countDownSettings["text"];
                    }
                }
            }
        });
    };

    /****** Premium Carousel Handler ******/
    var PixerexCarouselHandler = function ($scope, $) {
        var carouselElement = $scope.find(".pixerex-carousel-wrapper"),
            carouselSettings = $(carouselElement).data("settings"),
            isEdit = elementorFrontend.isEditMode();

        function slideToShow(slick) {
            var slidesToShow = slick.options.slidesToShow,
                windowWidth = $(window).width();
            if (windowWidth > carouselSettings["tabletBreak"]) {
                slidesToShow = carouselSettings["slidesDesk"];
            }
            if (windowWidth <= carouselSettings["tabletBreak"]) {
                slidesToShow = carouselSettings["slidesTab"];
            }
            if (windowWidth <= carouselSettings["mobileBreak"]) {
                slidesToShow = carouselSettings["slidesMob"];
            }
            return slidesToShow;
        }
        if (isEdit) {
            carouselElement.find(".item-wrapper").each(function (index, slide) {
                var templateID = $(slide).data("template");
                if (undefined !== templateID) {
                    $.ajax({
                        type: "GET",
                        url: PixerexSettings.ajaxurl,
                        dataType: "html",
                        data: {
                            action: "get_elementor_template_content",
                            templateID: templateID
                        }
                    }).success(function (response) {
                        var data = JSON.parse(response).data;
                        if (undefined !== data.template_content) {
                            $(slide).html(data.template_content);
                            carouselElement.find(".pixerex-carousel-inner").slick(
                                "refresh");
                        }
                    });
                }
            });
        }
        carouselElement.on("init", function (event) {
            event.preventDefault();
            //            restartAnimations();
            $(this).find("item-wrapper.slick-active").each(function () {
                var $this = $(this);
                $this.addClass($this.data("animation"));
            });
            $(".slick-track").addClass("translate");
        });
        carouselElement.find(".pixerex-carousel-inner").slick({
            vertical: carouselSettings["vertical"],
            slidesToScroll: carouselSettings["slidesToScroll"],
            slidesToShow: carouselSettings["slidesToShow"],
            responsive: [{
                    breakpoint: carouselSettings["tabletBreak"],
                    settings: {
                        slidesToShow: carouselSettings["slidesTab"],
                        slidesToScroll: carouselSettings["slidesTab"]
                    }
                },
                {
                    breakpoint: carouselSettings["mobileBreak"],
                    settings: {
                        slidesToShow: carouselSettings["slidesMob"],
                        slidesToScroll: carouselSettings["slidesMob"]
                    }
                }
            ],
            useTransform: true,
            fade: carouselSettings["fade"],
            infinite: carouselSettings["infinite"],
            speed: carouselSettings["speed"],
            autoplay: carouselSettings["autoplay"],
            autoplaySpeed: carouselSettings["autoplaySpeed"],
            draggable: carouselSettings["draggable"],
            touchMove: carouselSettings["touchMove"],
            rtl: carouselSettings["rtl"],
            adaptiveHeight: carouselSettings["adaptiveHeight"],
            pauseOnHover: carouselSettings["pauseOnHover"],
            centerMode: carouselSettings["centerMode"],
            centerPadding: carouselSettings["centerPadding"],
            arrows: carouselSettings["arrows"],
            nextArrow: carouselSettings["nextArrow"],
            prevArrow: carouselSettings["prevArrow"],
            dots: carouselSettings["dots"],
            customPaging: function () {
                return ('<i class="' + carouselSettings["customPaging"] + '"></i>');
            }
        });

        function restartAnimations() {
            var $slides = carouselElement.find(".pixerex-carousel-template");
            $slides.find(".animated").each(function (index, elem) {
                var settings = $(elem).data("settings");
                if (!settings) return;
                if (!settings._animation && !settings.animation) return;
                var animation = settings._animation || settings.animation;
                $(elem).removeClass("animated " + animation).addClass("elementor-invisible");
            });
        };

        function triggerAnimation() {
            carouselElement.find(".slick-active .elementor-invisible").each(function (index, elem) {
                var settings = $(elem).data("settings");
                if (!settings) return;
                if (!settings._animation && !settings.animation) return;
                var delay = settings._animation_delay ? settings._animation_delay : 0,
                    animation = settings._animation || settings.animation;
                setTimeout(function () {
                    $(elem).removeClass("elementor-invisible").addClass(animation +
                        ' animated');
                }, delay);
            });
        }
        carouselElement.on("afterChange", function (event, slick, currentSlide) {
            var slidesScrolled = slick.options.slidesToScroll,
                slidesToShow = slideToShow(slick),
                centerMode = slick.options.centerMode,
                slideToAnimate = currentSlide + slidesToShow - 1;
            restartAnimations();
            triggerAnimation();
            if (slidesScrolled === 1) {
                if (!centerMode === true) {
                    var $inViewPort = $(this).find("[data-slick-index='" + slideToAnimate +
                        "']");
                    if ("null" != carouselSettings["animation"]) {
                        $inViewPort.find("p, h1, h2, h3, h4, h5, h6, span, a, img, i, button")
                            .addClass(carouselSettings["animation"]).removeClass(
                                "pixerex-carousel-content-hidden");
                    }
                }
            } else {
                for (var i = slidesScrolled + currentSlide; i >= 0; i--) {
                    $inViewPort = $(this).find("[data-slick-index='" + i + "']");
                    if ("null" != carouselSettings["animation"]) {
                        $inViewPort.find("p, h1, h2, h3, h4, h5, h6, span, a, img, i, button")
                            .addClass(carouselSettings["animation"]).removeClass(
                                "pixerex-carousel-content-hidden");
                    }
                }
            }
        });
        carouselElement.on("beforeChange", function (event, slick, currentSlide) {
            var $inViewPort = $(this).find("[data-slick-index='" + currentSlide + "']");
            if ("null" != carouselSettings["animation"]) {
                $inViewPort.siblings().find(
                    "p, h1, h2, h3, h4, h5, h6, span, a, img, i, button").removeClass(
                    carouselSettings["animation"]).addClass(
                    "pixerex-carousel-content-hidden");
            }
        });
        if (carouselSettings["vertical"]) {
            var maxHeight = -1;
            elementorFrontend.elements.$window.on('load', function () {
                carouselElement.find(".slick-slide").each(function () {
                    if ($(this).height() > maxHeight) {
                        maxHeight = $(this).height();
                    }
                });
                carouselElement.find(".slick-slide").each(function () {
                    if ($(this).height() < maxHeight) {
                        $(this).css("margin", Math.ceil(
                            (maxHeight - $(this).height()) / 2) + "px 0");
                    }
                });
            });
        }
        var marginFix = {
            element: $("a.ver-carousel-arrow"),
            getWidth: function () {
                var width = this.element.outerWidth();
                return width / 2;
            },
            setWidth: function (type) {
                type = type || "vertical";
                if (type == "vertical") {
                    this.element.css("margin-left", "-" + this.getWidth() + "px");
                } else {
                    this.element.css("margin-top", "-" + this.getWidth() + "px");
                }
            }
        };
        marginFix.setWidth();
        marginFix.element = $("a.carousel-arrow");
        marginFix.setWidth("horizontal");
    };

    /****** Premium Banner Handler ******/
    var PixerexBannerHandler = function ($scope, $) {
        var $bannerElement = $scope.find(".pixerex-banner"),
            $bannerImg = $bannerElement.find("img");

        $bannerElement.find(".pixerex-banner-ib").hover(function () {
            $bannerImg.addClass("active");
        }, function () {
            $bannerImg.removeClass("active");
        });
    };

    /****** Premium Modal Box Handler ******/
    var PremiumModalBoxHandler = function ($scope, $) {
        var modalBoxElement = $scope.find(".pixerex-modal-box-container"),
            modalBoxSettings = modalBoxElement.data("settings");
        if (modalBoxElement.length > 0) {
            if (modalBoxSettings["trigger"] === "pageload") {
                $(document).ready(function ($) {
                    setTimeout(function () {
                        modalBoxElement.find(".pixerex-modal-box-modal").modal();
                    }, modalBoxSettings["delay"] * 1000);
                });
            }
        }
    };

    /****** Premium Blog Handler ******/
    var PremiumBlogHandler = function ($scope, $) {
        var $blogElement = $scope.find(".pixerex-blog-wrap"),
            $blogPost = $blogElement.find(".pixerex-blog-post-outer-container"),
            colsNumber = $blogElement.data("col"),
            carousel = $blogElement.data("carousel"),
            grid = $blogElement.data("grid"),
            layout = $blogElement.data("layout");
    
        var $metaSeparators = $blogPost.first().find(".pixerex-blog-meta-separator");
        
        if (1 === $metaSeparators.length) {
            $blogPost.find(".pixerex-blog-meta-separator").remove();
        } else {
            if (!$blogPost.find(".fa-user").length) {
                $blogPost.each(function (index, post) {
                    $(post).find(".pixerex-blog-meta-separator").first().remove();
                });
            }
        }

        $scope.find(".pixerex-blog-cats-container li a").click(function (e) {
            e.preventDefault();
            $scope.find(".pixerex-blog-cats-container li .active").removeClass("active");
            $(this).addClass("active");
            var selector = $(this).attr("data-filter");
            $blogElement.isotope({
                filter: selector,
                layoutMode: "even" === layout ? "fitRows" : "masonry"
            });
            return false;
        });
        
        if ("masonry" === layout && ! carousel) {
            $blogElement.imagesLoaded(function () {
                $blogElement.isotope({
                    itemSelector: ".pixerex-blog-post-outer-container",
                    percentPosition: true,
                    animationOptions: {
                        duration: 750,
                        easing: "linear",
                        queue: false
                    }
                });
            });
        }
        
        if (carousel && grid) {
            var autoPlay = $blogElement.data("play"),
                speed = $blogElement.data("speed"),
                fade = $blogElement.data("fade"),
                arrows = $blogElement.data("arrows"),
                dots = $blogElement.data("dots"),
                prevArrow = null,
                nextArrow = null;
            if (arrows) {
                (prevArrow =
                    '<a type="button" data-role="none" class="carousel-arrow carousel-prev" aria-label="Next" role="button" style=""><i class="fas fa-angle-left" aria-hidden="true"></i></a>'
                ), (nextArrow =
                    '<a type="button" data-role="none" class="carousel-arrow carousel-next" aria-label="Next" role="button" style=""><i class="fas fa-angle-right" aria-hidden="true"></i></a>'
                );
            } else {
                prevArrow = prevArrow = "";
            }
            $($blogElement).slick({
                infinite: true,
                slidesToShow: colsNumber,
                slidesToScroll: colsNumber,
                responsive: [{
                        breakpoint: 769,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 481,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ],
                autoplay: autoPlay,
                autoplaySpeed: speed,
                nextArrow: nextArrow,
                prevArrow: prevArrow,
                fade: fade,
                draggable: true,
                dots: dots,
                customPaging: function () {
                    return '<i class="fas fa-circle"></i>';
                }
            });
        }
    };
    /****** Premium Image Scroll ******/
    var PremiumImageScrollHandler = function ($scope, $) {
        var scrollElement = $scope.find(".pixerex-image-scroll-container"),
            scrollOverlay = scrollElement.find(".pixerex-image-scroll-overlay"),
            scrollVertical = scrollElement.find(".pixerex-image-scroll-vertical"),
            dataElement = scrollElement.data("settings"),
            imageScroll = scrollElement.find("img"),
            direction = dataElement["direction"],
            reverse = dataElement["reverse"],
            transformOffset = null;

        function startTransform() {
            imageScroll.css("transform", (direction === "vertical" ? "translateY" : "translateX") + "( -" +
                transformOffset + "px)");
        }

        function endTransform() {
            imageScroll.css("transform", (direction === "vertical" ? "translateY" : "translateX") + "(0px)");
        }

        function setTransform() {
            if (direction === "vertical") {
                transformOffset = imageScroll.height() - scrollElement.height();
            } else {
                transformOffset = imageScroll.width() - scrollElement.width();
            }
        }
        if (dataElement["trigger"] === "scroll") {
            scrollElement.addClass("pixerex-container-scroll");
            if (direction === "vertical") {
                scrollVertical.addClass("pixerex-image-scroll-ver");
            } else {
                scrollElement.imagesLoaded(function () {
                    scrollOverlay.css({
                        width: imageScroll.width(),
                        height: imageScroll.height()
                    });
                });
            }
        } else {
            if (reverse === "yes") {
                scrollElement.imagesLoaded(function () {
                    scrollElement.addClass("pixerex-container-scroll-instant");
                    setTransform();
                    startTransform();
                });
            }
            if (direction === "vertical") {
                scrollVertical.removeClass("pixerex-image-scroll-ver");
            }
            scrollElement.mouseenter(function () {
                scrollElement.removeClass("pixerex-container-scroll-instant");
                setTransform();
                reverse === "yes" ? endTransform() : startTransform();
            });
            scrollElement.mouseleave(function () {
                reverse === "yes" ? startTransform() : endTransform();
            });
        }
    };

    var PixerexContactFormHandler = function ($scope, $) {

        var $contactForm = $scope.find(".pixerex-cf7-container");
        var $input = $contactForm.find(
            'input[type="text"], input[type="email"], textarea, input[type="password"], input[type="date"], input[type="number"], input[type="tel"], input[type="file"], input[type="url"]'
        );

        $input.wrap("<span class='wpcf7-span'>");

        $input.on("focus blur", function () {
            console.log($input);
            $(this).closest(".wpcf7-span").toggleClass("is-focused");
        });
    };

    //Elementor JS Hooks
    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/pixerex-img-gallery.default", PixerexGridWidgetHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/pixerex-counter.default", PremiumCounterHandler);
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/pixerex-countdown-timer.default", PremiumCountDownHandler);
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/pixerex-carousel-widget.default", PixerexCarouselHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/pixerex-elements-banner.default", PixerexBannerHandler);
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/pixerex-addon-modal-box.default", PremiumModalBoxHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/pixerex-addon-blog.default", PremiumBlogHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/pixerex-image-scroll.default", PremiumImageScrollHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/pixerex-contact-form.default", PixerexContactFormHandler);
        if (elementorFrontend.isEditMode()) {
            elementorFrontend.hooks.addAction(
                "frontend/element_ready/pixerex-progressbar.default", PremiumProgressBarWidgetHandler);
        } else {
            elementorFrontend.hooks.addAction(
                "frontend/element_ready/pixerex-progressbar.default", PremiumProgressBarScrollWidgetHandler);
        }
    });
})(jQuery);