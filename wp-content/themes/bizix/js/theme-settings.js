(function ($) {

     "use strict";

    /* Retina ------------------------- */

    function swm_retinaRatioCookies() {
        var swm_DevicePixelRatio = !!window.devicePixelRatio ? window.devicePixelRatio : 1;
        if (!$.cookie("pixel_ratio")) {
            if (swm_DevicePixelRatio > 1 && navigator.cookieEnabled === true) {
                $.cookie("pixel_ratio", swm_DevicePixelRatio, {expires : 360});
                location.reload();
            }
        }
    }

    /* Post Format Gallery ------------------------- */

    function swmPfGallery() {
        $('.pfi-gallery').imagesLoaded( function() {
            $('.pfi-gallery').flexslider({
                animation: 'fade',
                animationSpeed: 500,
                slideshow: false,
                smoothHeight: false,
                controlNav: false,
                directionNav: true,
                prevText: '<i class="fas fa-chevron-left"></i>',
                nextText: '<i class="fas fa-chevron-right"></i>'
            });
        });
    }


    /* Go top scroll ------------------------- */

    function swmGoTopScroll() {

        var swm_PageScroll = false,
            $swm_PageScrollElement = $('.swm-go-top-scroll-btn-wrap');

        $swm_PageScrollElement.on("click",function(e) {
            $('body,html').animate({ scrollTop: "0" }, 750, 'easeOutExpo' );
            e.preventDefault();
        });

        $(window).scroll(function() {
            swm_PageScroll = true;
        });

        setInterval(function() {
            if( swm_PageScroll ) {
                swm_PageScroll = false;

                if( $(window).scrollTop() > 300 ) {
                    $swm_PageScrollElement.fadeIn('fast');
                } else {
                    $swm_PageScrollElement.fadeOut('fast');
                }
            }
        }, 250);

    }

    /* Share Post Link ------------------------- */

    function swm_sharePostLinks() {

        $(".swm-post-share").each(function(){

            var $this = $(this),
                swm_ElementId = $this.attr("data-postid"),
                swm_ClickElement = '.post-share-id-'+swm_ElementId,
                swm_OpenElement = '.swm-share-id-box-'+swm_ElementId+' ul';

            $(swm_ClickElement).addClass('active');

            $(swm_ClickElement).on('click',function(e){
                e.preventDefault();
                if ($(this).hasClass("active") ) {
                    $(swm_OpenElement).animate({ left: '30' }, 500);
                    $(this).removeClass("active");
                } else {
                    $(swm_OpenElement).animate({ left: '-300' }, 500);
                    $(this).addClass("active");
                }
                return false;
            });

        });

    }

    /* Element Horizontal and Verticel Center ------------------------- */

    function swm_js_H_Center() {

        $(".swm-js-center").each(function(){
            var $this = $(this),
                swm_ElementWidth = $this.width(),
                swm_ElementMargin = swm_ElementWidth/-2;
            $this.css('margin-left',swm_ElementMargin);
        });

    }

    function swm_js_V_Center() {

        $(".swm-js-center-top").each(function(){

            var $this = $(this),
                swm_ElementWidth = $this.height(),
                swm_ElementMargin = swm_ElementWidth/-2;

            $this.css('margin-top',swm_ElementMargin);

        });

    }

    /* WordPress Gallery ------------------------- */

    function swm_WPGallery() {
        if ( $('.gallery').length ){

            var swm_LayoutModeStyle = 'fitRows';

            if ($("body").hasClass('swm-img-gallery-masonry')) {
                swm_LayoutModeStyle = 'masonry';
            }

            $('.gallery').imagesLoaded( function() {
                $('.gallery').isotope({
                    itemSelector: '.gallery-item',
                    layoutMode: swm_LayoutModeStyle
                });
            });

        }
    }

    /* Sticky Header ------------------------- */

    function swm_stickyHeader(){
        if( $('body').hasClass('swm-stickyOn') ){

            var getResolutionNumber = $('#swm-main-nav-holder').data('sticky-hide');
            var getResolution = getResolutionNumber ? getResolutionNumber : 768;
            //var getResolution = 768;

             if( $(window).width() > getResolution ){

                var swm_header_height = 0,
                    headerHeight = $('#swm-header').innerHeight(),
                    swm_header_height = headerHeight;

                if ( $('.swm-header-placeholder').length ){
                    var getHeaderHeightDesktop = $('.swm-header-placeholder').data("header-d"),
                        getHeaderHeightTablet = $('.swm-header-placeholder').data("header-t"),
                        getHeaderHeightMobile = $('.swm-header-placeholder').data("header-m"),
                        spaceHolderHeight = getHeaderHeightDesktop;

                    if ( $(window).width() < 980 ) {
                        spaceHolderHeight = getHeaderHeightTablet;
                    } else if ( $(window).width() < 768 ) {
                        spaceHolderHeight = getHeaderHeightMobile;
                    }
                }

                if ( $('.swm-topbar-main-container').length ){
                    swm_header_height = $('.swm-topbar-main-container').innerHeight() + swm_header_height;
                }

                if ( $('body.subHeaderTop').length ){
                    swm_header_height = $('.swm-sub-header').innerHeight() + swm_header_height;
                }

                if( $('.swm-header').hasClass('header_2s') ){
                    swm_header_height = swm_header_height + 67;
                    spaceHolderHeight = 70;
                }

                if( $('body').hasClass('swm-l-boxed') ){
                    swm_header_height = swm_header_height + $('body').data("boxed-margin");
                }

                var start_y = swm_header_height,
                    window_y = $(window).scrollTop(),
                    wpAdminBarHeight = 0;

                if ( $('#wpadminbar').length ){
                    wpAdminBarHeight = $('#wpadminbar').innerHeight();
                }

                if ( $('.swm-header').hasClass('header_2s') ){
                    // Header 2
                    if ( window_y > start_y ){
                        if ( ! ($('#swm-main-nav-holder').hasClass('sticky-on'))){
                            $('#swm-main-nav-holder')
                                .addClass('sticky-on');
                            $('#swm-main-nav-holder .swm-infostack-menu')
                                .css('top',-67)
                                .animate({'top': wpAdminBarHeight },300);
                            $('.swm-header-placeholder').css('height', spaceHolderHeight);
                        }
                    }
                    else {
                        if ($('#swm-main-nav-holder').hasClass('sticky-on')) {
                            $('#swm-main-nav-holder')
                                .removeClass('sticky-on');
                            $('#swm-main-nav-holder .swm-infostack-menu')
                                .css('top', 0);
                            $('.swm-header-placeholder').css('height', 0);
                        }
                    }

                } else {
                    // Header 1
                    if ( window_y > start_y ){
                        if ( ! ($('#swm-main-nav-holder').hasClass('sticky-on'))){
                            $('#swm-main-nav-holder')
                                .addClass('sticky-on')
                                .css('top',-80)
                                .animate({'top': wpAdminBarHeight },300);
                            $('.swm-header-placeholder').css('height', spaceHolderHeight);
                        }
                    }
                    else {
                        if ($('#swm-main-nav-holder').hasClass('sticky-on')) {
                            $('#swm-main-nav-holder')
                                .removeClass('sticky-on')
                                .css('top', 0);
                            $('.swm-header-placeholder').css('height', 0);
                        }
                    }
                }

            }

        }
    }

     /* Universal Filter ------------------------- */

    function swm_universalFilterItemsMenu() {
        $('.swm-universal-filter-items-menu a').on('click',function(){
            var selector = $(this).attr('data-filter');
            $('.swm-universal-filter-items-section').isotope({filter: selector});
            $('.swm-universal-filter-items-menu a.swm-active-sort').removeClass('swm-active-sort');
            $(this).addClass('swm-active-sort');
            return false;
        });
    }

     /* Smooth Scroll ------------------------- */

    function swm_smoothScroll() {
        $('a.smooth-scroll').on('click',function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                if (target.length) {
                    $('html, body').animate({
                    scrollTop: target.offset().top - 140
                }, 1000);
                return false;
                }
            }

        });
    }

    /* Sidebar List Widgets ------------------------- */

    function swm_listWidgets() {
        $(".sidebar,.sidebar .theiaStickySidebar,.footer .swm-f-widget,.swm-sidepanel-wrap").children(".widget_meta,.widget_categories,.widget_pages,.widget_archive,.widget_recent_comments,.widget_recent_entries,.widget_nav_menu,.widget_product_categories,.widget_layered_nav_filters,.archives-link,.widget_rss,.widget_rating_filter,.woocommerce-widget-layered-nav,.widget_gyan_useful_links_wid").addClass("swm-list-widgets");
    }

    /* Side Panel ------------------------- */

    function swmSidePanel() {
        var $body = $('body');
        var SWM = {};

        SWM.isMobile = {
            Android: function() {
                return navigator.userAgent.match(/Android/i);
            },
            iOS: function() {
                return navigator.userAgent.match(/iPhone|iPad|iPod/i);
            },
            Windows: function() {
                return navigator.userAgent.match(/IEMobile/i);
            },
            Opera: function() {
                return navigator.userAgent.match(/Opera Mini/i);
            },
            BlackBerry: function() {
                return navigator.userAgent.match(/BlackBerry/i);
            },
            any: function() {
                return (SWM.isMobile.Android() || SWM.isMobile.BlackBerry() || SWM.isMobile.iOS() || SWM.isMobile.Opera() || SWM.isMobile.Windows());
            }
        };

        if ( $('.swm-sidepanel-trigger').length > 0 ) {
            $body.addClass("swm-sidePanelOn");
        }
        $('.swm-sp-icon-box').on('click', function(e) {
            $body.toggleClass("swm-sidepanel-open");
            if ( SWM.isMobile.any() ) {
                $body.toggleClass("overflow-hidden");
            }
            return false;
        });

        $('.swm-sidePanelOn .swm-sidepanel-body-overlay,.swm-sidepanel-close').on('click', function(e) {
            $body.toggleClass("swm-sidepanel-open");
            return false;
        });

        var $wpAdminBar = $('#wpadminbar');
        if( $wpAdminBar.length > 0 ) {
            var wpAdminBar_height = $wpAdminBar.height();
            $('#swm-sidepanel-container').css('top', wpAdminBar_height);
        }
    }

    function swmStickySidebar() {
        var $showStickySidebar = $('#sidebar.swm-sticky-sidebar');
        if( $showStickySidebar.length > 0 ) {
            $showStickySidebar .theiaStickySidebar({
                additionalMarginTop: 130
            });
        }
    }

    function swmSubHeaderTitle() {
        if ( $('#swm-wrap .header_2_t').length ){
            var windowSize = $(window).width();
            var headerHeight = $('.swm-infostack-header').innerHeight() + 67;
            $('#swm-sub-header').css('padding-top', headerHeight);
        }
    }

    /* Image Lightbox ------------------------- */

    function swm_magnificPopup() {

        $('.swm-popup-img').magnificPopup({
            type: 'image'
        });

        $('.swm-popup-gallery').magnificPopup({
            type: 'image',
            gallery:{
                enabled:true,
                tCounter:''
            },
            zoom: {
                enabled: true,
                duration: 300,
                easing: 'ease-in-out'
            }
        });

        $('.popup-youtube, .popup-vimeo, .popup-gmaps,.swm-popup-video').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false
        });

        $('.swm-popup-video-autoplay').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false,
            iframe: {
                    markup: '<div class="mfp-iframe-scaler">' +
                        '<div class="mfp-close"></div>' +
                        '<iframe class="mfp-iframe" frameborder="0" allow="autoplay"></iframe>' +
                        '</div>',
                    patterns: {
                        youtube: {
                            index: 'youtube.com/',
                            id: 'v=',
                            src: 'https://www.youtube.com/embed/%id%?autoplay=1'
                        }
                    }
                }
        });

        $('.swm-popup-gallery-alt').magnificPopup(
            {
                delegate: 'a',
                type: 'image',
                tLoading: 'Loading image #%curr%...',
                mainClass: 'mfp-img-mobile',
                gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0,1]
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                titleSrc: function(item) {
                    return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
                }
            }
        });

    }

    function swm_main_navigation() {

        /* create mobile menu */

        $(".swm-primary-nav-wrap > ul").clone().appendTo("#swm-mobi-nav");
        $('#swm-mobi-nav > ul').removeClass('swm-primary-nav');

        // remove mega menu class, styles
        $('#swm-mobi-nav ul#menu-all-pages > li.megamenu-on > ul > li,#swm-mobi-nav li.megamenu-on > ul > li').css('width','auto');
        $('#swm-mobi-nav ul#menu-all-pages > li.megamenu-on > ul ').css({'background-image':'', 'background-position':''});

        $('#swm-mobi-nav').find('.swm-nav_p_meta').remove();

        /* mobile dropdown menu */

        function swm_mobile_menu(swm_main_nav,click_button,nav_id,nav_box) {

            var swm_main_nav = $(swm_main_nav),
                nav_box = $(nav_box),
                wpAdminBarHeight = 0;

            if ( $('#wpadminbar').length ){
                wpAdminBarHeight = $('#wpadminbar').innerHeight();
                nav_box.css('margin-top',wpAdminBarHeight +'px');
            }

            $(click_button).on('click', function(){
                var swm_dd_menu = $(swm_main_nav);

                if (swm_dd_menu.hasClass('open')) {
                    swm_dd_menu.removeClass('open');
                } else {
                    swm_dd_menu.addClass('open');
                }

                var swm_mob_nav_overlay = $('#swm-mobi-nav-overlay-bg');

                if (swm_mob_nav_overlay.hasClass('m_toggle')) {
                    swm_mob_nav_overlay.removeClass('m_toggle');
                } else {
                    swm_mob_nav_overlay.addClass('m_toggle');
                }
            });

            $('.swm-mobi-nav-close').on('click', function(){
                    $(swm_main_nav).removeClass('open');
                    $('#swm-mobi-nav-overlay-bg').removeClass('m_toggle');
            });

            $('#swm-mobi-nav-overlay-bg').on('click', function(){
                    $(swm_main_nav).removeClass('open');
                    $('#swm-mobi-nav-overlay-bg').removeClass('m_toggle');
            });

            swm_main_nav.find('li ul').parent().addClass('swm-has-sub-menu');
            swm_main_nav.find(".swm-has-sub-menu").prepend('<span class="swm-mini-menu-arrow"></span>');

            swm_main_nav.find('.swm-mini-menu-arrow').on('click', function() {
                if ($(this).siblings('ul').hasClass('open')) {
                    $(this).siblings('ul').removeClass('open').slideUp();
                }
                else {
                    $(this).siblings('ul').addClass('open').slideDown();
                }
                if ($(this).hasClass('inactive')) {
                    $(this).removeClass('inactive');
                } else {
                    $(this).addClass('inactive');
                }
            });

        }

        swm_mobile_menu('#swm-mobi-nav','#swm-mobi-nav-icon span.swm-mobi-nav-btn-box>span','#swm-mobi-nav > ul','#swm-mobi-nav');

    }

    function swm_dropDownMenu() {

        // DROP DOWN MENU
        $('.swm-primary-nav > li').hover(
            function() {
                var $dropDowns = $('ul', this);
                $dropDowns.removeClass('invert');

                if (!$(this).hasClass('megamenu-on')) {
                    $dropDowns.css({top: ''});
                }

                if ($(this).hasClass('megamenu-on') ) {
                    return;
                }

                var dropDownCssTransformValue = 0;

                if ($('>ul', this).css('transform')) {
                    dropDownCssTransformValue = parseInt($('>ul', this).css('transform').split(',')[5]);
                }
                if (isNaN(dropDownCssTransformValue)) {
                    dropDownCssTransformValue = 0;
                }

                var windowScroll        = $(window).scrollTop(),
                    siteHeaderOffset    = $('#swm-header').offset(),
                    siteHeaderOffsetTop = siteHeaderOffset.top - windowScroll,
                    siteHeaderHeight    = $('#swm-header').outerHeight();

                $dropDowns.each(function() {

                    var $dropDown = $(this);
                    var self = this;

                    var itemOffset          = $dropDown.offset(),
                        dropDownTopDistance = itemOffset.top - windowScroll,
                        itemOffsetLeft      = itemOffset.left;

                    if(itemOffsetLeft - $('#swm-page').offset().left + $dropDown.outerWidth() > $('#swm-page').width()) {
                        $dropDown.addClass('invert');
                    }

                });
            },
            function() {}
        );

    }

    function swm_searchOverlay() {
        $('.swm_searchbox_close').slideUp();
        var open = false;

        $('.swm-header-search span').on('click', function() {
            if (open == false) {
                $('.swm_searchbox_holder, .swm_searchbox_close').slideDown();
                $('nav ul li, .btn-open').slideUp();
                open = true;
            } else {
                $('.swm_searchbox_holder, .swm_searchbox_close').slideUp();
                $('nav ul li, .btn-open').slideDown();
                open = false;
            }
        });
        $('.swm_searchbox_holder').on('mouseup', function() {
            $('.swm_searchbox_holder, .swm_searchbox_close').slideUp();
            $('nav ul li, .btn-open').slideDown();
            open = false;
        });
        $('.swm_overlay_search_box').on('mouseup', function() {
            return false;
        });
    }

    /* Document ready load functions =================== */

    $(document).ready(function() {

        $(".fitVids").fitVids();
        swm_retinaRatioCookies();
        swmPfGallery();
        swmGoTopScroll();
        swm_sharePostLinks();
        swm_js_H_Center();
        swm_js_V_Center();
        swm_WPGallery();
        swm_stickyHeader();
        swm_universalFilterItemsMenu();
        swm_smoothScroll();
        swm_listWidgets();
        swmSidePanel();
        swmSubHeaderTitle();
        swmStickySidebar();
        swm_magnificPopup();
        swm_main_navigation();
        swm_dropDownMenu();
        swm_searchOverlay();

    });

    /* Scroll Events ---------- */

    $(window).scroll(function(){
        swm_stickyHeader();
    });

    /* Window load functions =================== */

    var $window = $(window);

    $(window).load(function () {

        if ( $('.swm-site-loader').length ){
            $(".swm-site-loader").slideUp();
        }

        // Global masonry
        function swm_UniversalGridIsotope() {
           if ($("#swm-item-entries").hasClass('isotope')) {
                $('.swm-universal-grid-sort').imagesLoaded( function() {
                    $('.swm-universal-grid-sort').isotope({
                        itemSelector: '.swm-universal-grid'
                    });
                });
            }
        }

        swm_UniversalGridIsotope();

        $window.resize(function () {
            swm_UniversalGridIsotope();
            swmSubHeaderTitle();
            swm_stickyHeader();
        });
        window.addEventListener("orientationchange", function() {
            swm_UniversalGridIsotope();
        });

        $('iframe').css('max-width','100%').css('width','100%');

    });

})(jQuery);