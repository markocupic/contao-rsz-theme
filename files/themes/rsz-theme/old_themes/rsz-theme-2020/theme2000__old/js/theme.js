/**
 * Created by Marko on 18.02.2017.
 */
(function ($) {
    $().ready(function () {


        /**
         * Ajax News Pagination Home-Site
         * @param href
         */
        $('.ajax-pagination .pagination a').click(function (event) {
            event.preventDefault();
            $(this).closest('.mod_pagination').css('visibility', 'hidden');
            loadData(this.href);
        });

        /**
         * Ajax News Pagination Home-Site
         * @param href
         */
        function loadData(href) {

            $.get(href, function (html) {
                var items = $(html).find('.mod_newslist.ajax-pagination > div');
                if (items.length > 0) {
                    var $insertContainer = $('.mod_newslist.ajax-pagination').first()
                    $insertContainer.html('');
                    $.each(items, function (key) {
                        $(items[key]).hide().appendTo($insertContainer).fadeIn(200);
                    });
                    $insertContainer.find('.mod_pagination').first().addClass('col-12');

                    // Rebind event
                    $('.ajax-pagination .pagination a').click(function (event) {
                        event.preventDefault();
                        $(this).closest('.mod_pagination').css('visibility', 'hidden');
                        loadData(this.href);
                    });
                }
            });
        }


        // Animate with wow
        new WOW().init();


        // Offset for Main Navigation
        if ($(window).scrollTop() < 200) {
            $('body').addClass('affix-top');
        }

        $(window).scroll(function () {
            var height = $(window).scrollTop();
            if (height < 200) {
                $('body').addClass('affix-top');
            } else {
                $('body').removeClass('affix-top');
            }
        });


        // Add image overlay effect to each image
        $('.image-overlay-effect .image_container').prepend('<div class="image-overlay"></div>');
        $('.image-overlay-effect .image_container .image-overlay').each(function () {
            var isLightbox = false;
            var href = $(this).next('a');
            if ($(href).attr('data-lightbox') != undefined) {
                isLightbox = true;
            }
            if ($(href).attr('href') != '') {
                $(this).on('click', function () {
                    if (isLightbox) {
                        $(href).trigger('click');
                    } else {
                        location.href = location.protocol + '//' + location.host + '/' + $(href).attr('href');
                    }
                });
            }
        });


        $('body').append('<div class="scroll-to-top"><a href="#"><span class="fa fa-chevron-up"></span></a></div>');

        //Check to see if the window is top if not then display button
        $(window).on('scroll', function () {
            if ($(this).scrollTop() > 100) {
                $('.scroll-to-top').fadeIn();
            } else {
                $('.scroll-to-top').fadeOut();
            }
        });

        //Click event to scroll to top
        $('.scroll-to-top').click(function () {
            $('html, body').animate({scrollTop: 0}, 800);
            return false;
        });


        /** Dropdown navigation **/
        $('.main-navigation-desktop ul.level_1 > li.submenu').addClass('dropdown');
        $('.main-navigation-desktop ul.level_1 > li.submenu > a').addClass('dropdown-toggle');
        $('.main-navigation-desktop ul.level_1 > li.submenu > strong').addClass('dropdown-toggle');
        $('.main-navigation-desktop ul.level_1 > li.submenu > a, .main-navigation-desktop ul.level_1 > li.submenu > strong')
            .attr('data-toggle', 'dropdown')
            .attr('aria-haspopup', 'true')
            .attr('aria-expanded', 'false');

        $('.main-navigation-desktop ul.level_1 > li.submenu > a').attr('data-target', '#');
        $('.main-navigation-desktop  ul.level_1 > li.submenu.dropdown > ul').addClass('dropdown-menu');
        $('.main-navigation-desktop ul.dropdown-menu > li').addClass('dropdown-item');


        $('.main-navigation-desktop ul.level_2 > li > a').each(function () {
            $(this).attr('data-target', $(this).attr('href'));
        });

        /** Ipad does not react when touching the links **/
        $('.main-navigation-desktop ul.level_2 > li > a').on('touchstart click', function (event) {

            event.stopPropagation();
            event.preventDefault();
            if (event.handled !== true) {

                if ($(this).attr('href') != '') {
                    window.location.href = $(this).attr('href');
                    return false;
                }

                event.handled = true;
            } else {
                return false;
            }
        });


        /** colorbox long title problem **/
        /*
         $('a[data-lightbox]').colorbox({onComplete:function(){
         $("#cboxTitle").hide();
         $("#cboxLoadedContent").append($("#cboxTitle").html()).css({color: $("#cboxTitle").css("color")});
         $("#cboxLoadedContent").css({
         "background": "#111",
         "color": "#ddd",
         "font-size": "12px"
         });
         $.fn.colorbox.resize();
         }});
         */


        /** shorten download links **/
        if (window.screen.width < 800) {
            var maxStringLength = 18;

        } else {
            maxStringLength = 40;
        }
        var classes = ['.ce_downloads a', '.ce_download a'];
        $.each(classes, function (index, strClass) {
            $(strClass).each(function (index, el) {
                var strFilename = el.innerHTML;
                var match = strFilename.match(/(.*)\<span(.*)/);
                if (match) {
                    var filename = match[1];
                    if (filename.length > maxStringLength) {
                        var filenameShortened = filename.substring(0, maxStringLength) + ' ... ';
                        el.innerHTML = filenameShortened + '<span' + match[2];
                    }
                }
            });
        });


        // add/remove classes for bootstrap pagination
        $('div.pagination ul').addClass('pagination pagination-sm');
        $('div.pagination').removeClass('pagination');
        $('ul.pagination li').addClass('page-item');
        $('ul.pagination li > *').addClass('page-link');

        // add class for bootstrap buttons
        $('.submit').addClass('btn btn-primary');

        // add bootstrap class for ce_downloads
        $('#main .ce_download, #main .ce_downloads, #main .ce_hyperlink').addClass('well well-downloads');
        // add bootstrap class for formbody
        $('#main .formbody').addClass('well');
        $('<span style="margin-right:5px;" class="fa fa-calendar"> </span> ').insertBefore(".mod_newslist time");
        $('<br><span style="margin-right:5px;" class="fa fa-user"> </span> ').insertAfter("#main .mod_newslist time");
        $('<span style="margin-right:5px;" class="fa fa-calendar"> </span> ').insertBefore(".mod_newsreader time");
        $('<span style="margin-right:2px;" class="fa fa-user"> </span> ').insertAfter("#main .mod_newsreader time");
        $('<span style="margin-right:5px;" class="fa fa-calendar"> </span> ').insertBefore(".mod_jahresprogramm_next_event time");
        $('<span style="margin-right:5px;" class="fa fa-user"> </span> ').insertBefore(".mod_jahresprogramm_next_event .trainer");


    });


})(jQuery);
