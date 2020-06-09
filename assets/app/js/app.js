
/* ----------------------------------------- */
/*                 ~ CSS ~                   */
/* ----------------------------------------- */

import '../scss/app.scss';

/* ----------------------------------------- */
/*                  ~ JS ~                   */
/* ----------------------------------------- */

// Avoid `console` errors in browsers that lack a console.
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeline', 'timelineEnd', 'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

import $ from 'jquery';
import 'bootstrap';
import './libraries/scrollup';
import './libraries/jquery-easing';
import 'owl.carousel2';

// -- https://github.com/desandro/imagesloaded
import imagesLoaded from 'imagesloaded';
imagesLoaded.makeJQueryPlugin( $ );

// -- https://isotope.metafizzy.co/extras.html
import jQueryBridget from 'jquery-bridget';
import isotope from 'isotope-layout';
jQueryBridget( 'isotope', isotope, $ );

import readmore from 'readmore-js';
import './libraries/waypoints';
import 'slicknav/dist/jquery.slicknav';
import 'magnific-popup';
import './libraries/counter-up';
import WOW from 'wow.js';

// ------------------------------------- Display Date with Moment ------------------------------------- //

import * as moment from 'moment';
import 'moment/locale/fr';

$('time.sl-date').each(function (t, e) {
    const time = moment($(e).attr('datetime'));
    $(e).html('<span>' + time.from(moment()) +'</span>');
});

(function($) {
    "use strict";


    /*----------------------------
     comment page ajax call -- Load chapters based on BookId
    ------------------------------ */
    $('#rsv_public_comment_book').change(function () {

        const bookSelector = $(this);

        // Request the verses of the selected book.
        $.ajax({
            url: xhrCommentChapters,
            type: "GET",
            dataType: "JSON",
            data: {
                bookId: bookSelector.val()
            },
            success: function (chapters) {

                const chaptersSelect = $("#rsv_public_comment_chapter");

                // Remove current options
                chaptersSelect.html('');

                // Empty value ...
                chaptersSelect.append(`
                    <option selected value> 
                        ${bookSelector.find("option:selected").text()} chapitre...
                    </option>`);


                $.each(chapters, function (key, chapter) {
                    chaptersSelect.append('<option value="' + chapter.id + '">' + chapter.name + '</option>');
                });
            },
            error: function (err) {
                console.log("Ooops, nous ne sommes pas parvenu à charger les chapitres de ce livre...");
                console.log("Contactez l'administrateur par email sur : admin[at]retablirsaverite.org");
                console.log(err);
            }
        });
    });

    /*----------------------------
     comment page ajax call -- Load verses based on BookId and Chapters
    ------------------------------ */
    $('#rsv_public_comment_chapter').change(function () {

        const bookSelector = $("#rsv_public_comment_book");
        const chapterSelector = $(this);

        // Request the verses of the selected book.
        $.ajax({
            url: xhrCommentVerses,
            type: "GET",
            dataType: "JSON",
            data: {
                bookId: bookSelector.val(),
                chapterId: chapterSelector.val()
            },
            success: function (verses) {

                const versesSelect = $("#rsv_public_comment_verse");

                // Remove current options
                versesSelect.html('');

                // Empty value ...
                versesSelect.append(`
                    <option selected value>
                        ${bookSelector.find("option:selected").text()} ${chapterSelector.find("option:selected").val()} verset...
                    </option>`);

                $.each(verses, function (key, verse) {
                    versesSelect.append('<option value="' + verse.id + '" data-value="' + verse.text + '">' + verse.name + '</option>');
                });
            },
            error: function (err) {
                console.log("Ooops, nous ne sommes pas parvenu à charger les versets de ce livre...");
                console.log("Contactez l'administrateur par email sur : admin[at]retablirsaverite.org");
                console.log(err);
            }
        });
    });

    /*----------------------------
     comment page ajax call -- Load verses based on BookId and Chapters
    ------------------------------ */
    $('#rsv_public_comment_verse').change(function () {

        const bookSelector = $("#rsv_public_comment_book");
        const chapterSelector = $("#rsv_public_comment_chapter");
        const verseSelector = $(this);
        const bibleVerseSelect = $('.bible__verset');
        const verseTextHidden = $("#rsv_public_comment_verseText");

        bibleVerseSelect.html(`${bookSelector.find("option:selected").text()} ${chapterSelector.find("option:selected").val()} - ${verseSelector.find("option:selected").val()} : ${verseSelector.find("option:selected").attr('data-value')}`);
        bibleVerseSelect.parent().show();
        verseTextHidden.val(bibleVerseSelect.html());

    });

    /*----------------------------
     wow js active
    ------------------------------ */
    new WOW().init();

    // Read More Section
    // https://github.com/jedfoster/Readmore.js/tree/version-3.0
    new readmore('.readmore', {
        speed: 75,
        lessLink: '<a class="btn btn-primary" href="javascript:void(0)">Réduire</a>',
        moreLink: '<a class="btn btn-primary" href="javascript:void(0)">Voir l\'éclairage complet</a>'
    });

    /*------------- preloader js --------------*/
    $(window).on('load', function() { // makes sure the whole site is loaded
        $('.preloder-wrap').fadeOut(); // will first fade out the loading animation
        $('.loader').delay(150).fadeOut('slow'); // will fade out the white DIV that covers the website.
        $('body').delay(150).css({ 'overflow': 'visible' })
    })

    // slider-active
    $('.slider-active').owlCarousel({
        margin: 0,
        loop: true,
        autoplay: true,
        autoplayTimeout: 4000,
        nav: true,
        smartSpeed: 800,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        responsive: {
            0: {
                items: 1
            },
            450: {
                items: 1
            },
            768: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });

    // slider-active2
    $('.slider-active2').owlCarousel({
        margin: 0,
        loop: true,
        nav: true,
        smartSpeed: 800,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        responsive: {
            0: {
                items: 1
            },
            450: {
                items: 1
            },
            768: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });
    //slider-area background setting
    function sliderBgSetting() {
        if ($(".slider-area .slider-items,.slider-active2 .slider-item2").length) {
            $(".slider-area .slider-items,.slider-active2 .slider-item2").each(function() {
                var $this = $(this);
                var img = $this.find(".slider").attr("src");

                $this.css({
                    backgroundImage: "url(" + img + ")",
                    backgroundSize: "cover",
                    backgroundPosition: "center center"
                })
            });
        }
    }

    // tending-active
    $('.tending-active').owlCarousel({
        margin: 0,
        loop: true,
        autoplay: true,
        autoplayTimeout: 4000,
        nav: true,
        smartSpeed: 800,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        URLhashListener: true,
        startPosition: 'URLHash',
        responsive: {
            0: {
                items: 1
            },
            450: {
                items: 1
            },
            768: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
    // teanding-active2
    $('.teanding-active2').owlCarousel({
        margin: 0,
        loop: true,
        autoplay: true,
        autoplayTimeout: 4000,
        nav: true,
        smartSpeed: 800,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        URLhashListener: true,
        startPosition: 'URLHash',
        responsive: {
            0: {
                items: 1
            },
            450: {
                items: 1
            },
            768: {
                items: 2
            },
            1000: {
                items: 2
            }
        }
    });

    // team-active
    $('.team-active').owlCarousel({
        margin: 5,
        loop: true,
        autoplay: true,
        autoplayTimeout: 4000,
        nav: true,
        smartSpeed: 800,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        responsive: {
            0: {
                items: 1
            },
            450: {
                items: 2
            },
            768: {
                items: 4
            },
            1000: {
                items: 5
            }
        }
    });



    // blog-active
    $('.blog-active').owlCarousel({
        margin: 5,
        loop: true,
        autoplay: true,
        autoplayTimeout: 4000,
        nav: true,
        smartSpeed: 800,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        responsive: {
            0: {
                items: 1
            },
            450: {
                items: 1
            },
            768: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });
    /*==========================================================================
        WHEN DOCUMENT LOADING
    ==========================================================================*/
    $(window).on('load', function() {
        sliderBgSetting()
    });

    // Parallax background
    function bgParallax() {
        if ($(".parallax").length) {
            $(".parallax").each(function() {
                var height = $(this).position().top;
                var resize = height - $(window).scrollTop();
                var parallaxSpeed = $(this).data("speed");
                var doParallax = -(resize / parallaxSpeed);
                var positionValue = doParallax + "px";
                var img = $(this).data("bg-image");

                $(this).css({
                    backgroundImage: "url(" + img + ")",
                    backgroundPosition: "50%" + positionValue,
                    backgroundSize: "cover",
                });

                if (window.innerWidth < 768) {
                    $(this).css({
                        backgroundPosition: "center center"
                    });
                }
            });
        }
    }
    bgParallax();

    $(window).on("scroll", function() {
        bgParallax();
    });


    // // stickey menu
    $(window).on('scroll', function() {
        var scroll = $(window).scrollTop(),
            mainHeader = $('#sticky-header'),
            mainHeaderHeight = mainHeader.innerHeight();

        // console.log(mainHeader.innerHeight());
        if (scroll > 1) {
            $("#sticky-header").addClass("sticky-menu");
        } else {
            $("#sticky-header").removeClass("sticky-menu");
        }
    });

    /*--------------------------
     scrollUp
    ---------------------------- */
    $.scrollUp({
        scrollText: '<i class="fa fa-arrow-up"></i>',
        easingType: 'linear',
        scrollSpeed: 900,
        animation: 'fade'
    });

    /*--
    Magnific Popup
    ------------------------*/
    $('.popup').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        }

    });

    $('.video-popup').magnificPopup({
        type: 'iframe',
        gallery: {
            enabled: true
        }

    });

    // counter up
    $('.counter').counterUp({
        delay: 10,
        time: 1000
    });


    // slicknav
    $('ul#navigation').slicknav({
        prependTo: ".responsive-menu-wrap"
    });

    $('.grid').imagesLoaded(function() {

        // filter items on button click
        $('.project-menu').on('click', 'button', function() {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({ filter: filterValue });
        });

        // init Isotope
        var $grid = $('.grid').isotope({
            itemSelector: '.project',
            percentPosition: true,
            masonry: {
                // use outer width of grid-sizer for columnWidth
                columnWidth: '.project',
            }
        });
    });

    $('.project-menu button').on('click', function(event) {
        $(this).siblings('.active').removeClass('active');
        $(this).addClass('active');
        event.preventDefault();
    });

    /*-------------------------------------------------------
        blog details
    -----------------------------------------------------*/
    if ($(".post-area,.baking-news-area,.featured-post-area,.about-area").length) {
        var post = $(".post-area .post-img,.booking-img,.featured-post-wrap .featured-post-img,.about-images");

        post.each(function() {
            var $this = $(this);
            var entryMedia = $this.find("img");
            var entryMediaPic = entryMedia.attr("src");

            $this.css({
                backgroundImage: "url(" + entryMediaPic + ")",
                backgroundSize: "cover",
                backgroundPosition: "center center",
            })
        })
    }

    function setTwoColEqHeight($col1, $col2) {
        var firstCol = $col1,
            secondCol = $col2,
            firstColHeight = $col1.innerHeight(),
            secondColHeight = $col2.innerHeight();

        if (firstColHeight > secondColHeight) {
            secondCol.css({
                "height": firstColHeight + 1 + "px"
            })
        } else {
            firstCol.css({
                "height": secondColHeight + 1 + "px"
            })
        }
    }


    $(window).on("load", function() {
        setTwoColEqHeight($(".post-area .post-img,.booking-img,.featured-post-wrap .featured-post-img,.about-images"), $(".post-area .post-content,.booking-form,.featured-post-wrap .featured-post-content,.about-text"));

    });

    /*---------------------
    // Ajax Contact Form
    --------------------- */

    $('.cf-msg').hide();
    $('form#cf button#submit').on('click', function() {
        var fname = $('#fname').val();
        var subject = $('#subject').val();
        var email = $('#email').val();
        var msg = $('#msg').val();
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if (!regex.test(email)) {
            alert('Please enter valid email');
            return false;
        }

        fname = $.trim(fname);
        subject = $.trim(subject);
        email = $.trim(email);
        msg = $.trim(msg);

        if (fname != '' && email != '' && msg != '') {
            var values = "fname=" + fname + "&subject=" + subject + "&email=" + email + " &msg=" + msg;
            $.ajax({
                type: "POST",
                url: "mail.php",
                data: values,
                success: function() {
                    $('#fname').val('');
                    $('#subject').val('');
                    $('#email').val('');
                    $('#msg').val('');

                    $('.cf-msg').fadeIn().html('<div class="alert alert-success"><strong>Success!</strong> Email has been sent successfully.</div>');
                    setTimeout(function() {
                        $('.cf-msg').fadeOut('slow');
                    }, 4000);
                }
            });
        } else {
            $('.cf-msg').fadeIn().html('<div class="alert alert-danger"><strong>Warning!</strong> Please fillup the informations correctly.</div>')
        }
        return false;
    });

})(jQuery);