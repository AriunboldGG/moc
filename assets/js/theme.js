jQuery(document).ready(function ($) {
    'use strict';
    /* Footer Link target */
    if ( $('footer a').length ) {
        $('footer a').attr('target','_blank');
    }


    /* Calendar */
    $( document ) . on( 'click', '.tw-events-calendar:not(.tw-events-calendar-weekly) .tw-events-list-container', function(e) { e.preventDefault();
        var $this = $( this );
        var $more = $this.siblings( '.tw-events-calendar-more-list' );
        var $moreTarget = $this . closest( '.tw-events-calendar' ) .addClass( 'tw-calendar-expanded' ) . find( '.tw-events-calendar-more .tw-events-calendar-more-body' );
        if ( $more.length && $moreTarget.length ) {
            if ( $this.closest('table').find('.tw-day-expanded').length ) {
                $this.closest('table').find('.tw-day-expanded').removeClass('tw-day-expanded');
            }
            $this.closest('td').addClass('tw-day-expanded');
            $moreTarget.html( $more.clone() ).closest( '.tw-events-calendar-more' ).removeClass( 'uk-hidden' );
        }
    });
    
    $( document ) . on( 'click', '.tw-events-calendar-more-head .tw-btn-close', function(e) { e.preventDefault();
        var $this = $( this );
        if ( $this . closest( '.tw-events-calendar' ) . find( '.tw-day-expanded' ) . length ) {
            $this . closest( '.tw-events-calendar' ) . find( '.tw-day-expanded' ) . removeClass('tw-day-expanded');
        }
        $this.closest('.tw-events-calendar-more').addClass('uk-hidden'). closest( '.tw-events-calendar' ) .removeClass( 'tw-calendar-expanded' );
        $this.closest('.tw-events-calendar-more-head').siblings('.tw-events-calendar-more-body').html('');
    });

    /* Accessibility */
    $( document ) . on( 'change', '.tw-form-acc-field-container [name="color"]', function(e) {e.preventDefault();
        $('body').attr('data-acc-color', $(this).val() );
    });

    $( document ) . on( 'change', '.tw-form-acc-field-container [name="size"]', function(e) {e.preventDefault();
        $('body').attr('data-acc-size', $(this).val() );
    });

    $( document ) . on( 'change', '.tw-form-acc-field-container [name="hide_image"]', function(e) {e.preventDefault();
        $('body').attr('data-acc-hide-image', $(this).val() );
    });

    $( document ) . on( 'click', '.tw-form-acc-field-container .tw-form-acc-btn-size', function(e) {e.preventDefault();
        var $cr_size_field = $('.tw-form-acc-field-container [name="size"]');
        if ( $cr_size_field .length  ) {
            var $cr_val = parseInt( $cr_size_field .val() );
            if (  $(this).hasClass( 'increase' ) ) {
                $cr_val ++;
            } else {
                $cr_val --;
            }
        }

        if ( $cr_val>2 ) {
            $cr_val = 3;
        } else if( $cr_val < 0 ){
            $cr_val = 0;
        }

        $cr_size_field.val( $cr_val ).change();
    });

    $( document ) . on( 'click', '.tw-form-acc-field-container .tw-form-acc-reset', function(e) {e.preventDefault();
        if ( $('.tw-form-acc-field-container [name="color"]') .length ) {
            $('.tw-form-acc-field-container [name="color"]').val( 'normal' ).change();
        }
        if ( $('.tw-form-acc-field-container [name="size"]') .length ) {
            $('.tw-form-acc-field-container [name="size"]').val( '0' ).change();
        }
        if ( $('.tw-form-acc-field-container [name="size"]') .length ) {
            $('.tw-form-acc-field-container [name="hide_image"]').val( '' ).change();
        }
        if ( $('.tw-form-acc-field-container [type="submit"]') .length ) {
            $('.tw-form-acc-field-container [type="submit"]').click();
        }
    });

    $( document ) . on( 'submit', '#tw-accessibility-form', function(e) {e.preventDefault();
        var $crrForm = $( this );
        $.ajax({
            type: "GET",
            url:  lvly_script_data.ajaxurl,
            data: $crrForm.serialize()
        });
        if ( $( '#tw-accessibility-modal .uk-close' ) . length ) {
            $( '#tw-accessibility-modal .uk-close' ).click();
        }
    } );

    /* iMap */
    $( '.tw-imap' ) . each( function(){
        if ( $( '#map', $(this) ).length ) {
            var map  = L.map('map').setView( [ 47.91950097225595, 106.91776901382933 ], 13 );
            var tile = $(this).data('tile') ? $(this).data('tile') : 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

            L.tileLayer(tile, {
                minZoom: 6,
                maxZoom: 17,
                // attribution: '© iMap'
            }).addTo(map);
            map.zoomControl.setPosition('topright');

            var $items = $( '.tw-filter-item', $(this) );

            $items . each( function(){
                var $crItem = $( this );
                var $crItemTitle = $( '.tw-item-title', $crItem );
                var $crItemLink  = $( '.tw-item-link', $crItem );

                var $crItemColor   = $crItem.data( 'color' );
                var $crItemIcon = '<svg width="41" height="40" viewBox="0 0 41 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="40.0016" height="40" rx="20" fill="' + $crItemColor + '"/><path d="M8.86275 13.7226C10.0778 11.6977 11.698 10.0776 13.7232 8.86266C16.1534 7.64768 18.5836 7.24269 18.5836 10.8876V12.1026V15.7476C18.5836 17.7726 17.7735 18.5825 15.7484 18.5825H12.103H10.8879C7.24262 18.5825 7.64765 15.7476 8.86275 13.7226Z" fill="white"/><path d="M31.1389 13.7226C29.9238 11.6977 28.3036 10.0776 26.2784 8.86266C24.2532 7.64768 21.418 7.24269 21.418 10.8876V12.1026V15.7476C21.418 17.7726 22.2281 18.5825 24.2533 18.5825H27.8986H29.1137C32.759 18.5825 32.354 15.7476 31.1389 13.7226Z" fill="white"/><path d="M31.1389 26.2778C29.9238 28.3028 28.3036 29.9228 26.2784 31.1378C24.2532 32.3528 21.418 32.7578 21.418 29.1128V27.8979V24.2529C21.418 22.2279 22.2281 21.418 24.2533 21.418H27.8986H29.1137C32.759 21.418 32.354 24.2529 31.1389 26.2778Z" fill="white"/><path d="M8.86275 26.2778C10.0778 28.3028 11.698 29.9228 13.7232 31.1378C16.1534 32.3528 18.5836 32.7578 18.5836 29.1128V27.8979V24.2529C18.5836 22.2279 17.7735 21.418 15.7484 21.418H12.103H10.8879C7.24262 21.418 7.64765 24.2529 8.86275 26.2778Z" fill="white"/></svg>';
                var $crItemLatLong = $crItem.data( 'lat-long' ) ? $crItem.data( 'lat-long' ).split(',') : '';
                var $crItemPopup = '';

                if ( $crItemColor && $crItemLatLong && $crItemLatLong.length === 2 && $crItemTitle.length && $crItemLink.length ) {
                    $crItemPopup = '<div class="tw-imap-popup">';
                        $crItemPopup += '<div class="tw-item-left">' + $crItemIcon + '</div>';
                        $crItemPopup += '<div class="tw-item-right">';
                            $crItemPopup += '<h4 class="tw-item-title">';
                                $crItemPopup += $crItemTitle.text();
                            $crItemPopup += '</h4>';
                            $crItemPopup += $crItemLink[0]['outerHTML'];
                        $crItemPopup += '</div>';
                    $crItemPopup += '</div>';

                    
                    var $crMarker = L.marker($crItemLatLong, { icon: L.divIcon({
                        html: $crItemIcon,
                        className: "tw-imap-marker",
                        iconSize:   [ 40, 40 ],
                        iconAnchor: [ 20, 20 ],
                    }) }).bindPopup( $crItemPopup )
                    
                    $crMarker.addTo(map);
                    
                    $crItem.bind( 'tw-add-marker', function(){
                        $crMarker.addTo(map);
                    } )
                    $crItem.bind( 'tw-remove-marker', function(){
                        $crMarker.remove(map);
                    } )

                    $crItemTitle.on('click', function(e){e.preventDefault();
                        $crMarker.openPopup();
                        map.setView($crItemLatLong, 17);
                    });
                }
            } );

            $( '#tw-imap-filter' ).on( 'change', function(e){e.preventDefault();
                var $crFilter    = $( this );
                var $crFilterVal = $crFilter.val();

                if ( $( 'option[value="'+$crFilterVal+'"]', $crFilter ) . length && $( 'option[value="'+$crFilterVal+'"]', $crFilter ).data('location') ) {
                    map.setView( $( 'option[value="'+$crFilterVal+'"]', $crFilter ).data('location').split(','), 13);
                } 

                var $crActiveItems = [];
                var $crInActiveItems = [];

                if ( $crFilterVal ) {
                    $crActiveItems   = $items.filter('[data-city*="-' + $crFilterVal + '-"]');
                    $crInActiveItems = $items.filter(':not([data-city*="-' + $crFilterVal + '-"])');
                } else {
                    $crActiveItems = $items;
                }

                if ( $crActiveItems.length ) {
                    $crActiveItems.show().trigger( 'tw-add-marker' );;
                }

                if ( $crInActiveItems.length ) {
                    $crInActiveItems.hide().trigger( 'tw-remove-marker' );
                }
            } );

            if ( $( '.tw-filter-button', $(this) ) . length && $( '.tw-filter-container', $(this) ) . length ) {
                var $crCntrnr = $( '.tw-filter-container', $(this) );
                $( '.tw-filter-button', $(this) ).on( 'click', function(e){e.preventDefault();
                    $crCntrnr . toggleClass('opened');
                });
            }
        }
    });

    /* like */
    $( document ) . on( 'click', '.tw-like-button', function(e) {e.preventDefault();
        var $crr_btn = $( this );
        var $crr_pid = parseInt( $crr_btn.data('id'), 10 );
        if ( $crr_pid && ! $crr_btn.hasClass( 'waiting-ajax' ) ) {
            if ( $crr_btn.find( '.tw-like-count' ).length ) {
                var $likeCountItem = $crr_btn.find( '.tw-like-count' );
                var $likeCount = parseInt( $likeCountItem.text(), 10 ) + ( $crr_btn.hasClass( 'tw-liked' ) ? -1 : 1 );
                $likeCountItem.text( $likeCount > 0 ? $likeCount : 0 );
            }
            $crr_btn.toggleClass( 'tw-liked' );
            $crr_btn.addClass( 'waiting-ajax' );
            $.ajax({
                type: "GET",
                url:  lvly_script_data.ajaxurl,
                data: {
                    action: 'lvly_like_ajax',
                    pid: $crr_pid
                },
                success: function() {
                    $crr_btn.removeClass( 'waiting-ajax' );
                }
            });
        }
    } )


    /* Filter Form */
    $( '.tw-filter-form' ) . each( function(){
        var $crrForm = $(this);
        var $typeTimeout = false;

        
        if ( $( 'select', $crrForm ) .length ) {
            $( 'select', $crrForm ).change( function(){
                $crrForm.submit();
            } )
        }

        if ( $( 'input', $crrForm ) .length ) {
            $( 'input', $crrForm ).on( 'input', function(){
                if ( $typeTimeout !== false ) {
                    clearTimeout( $typeTimeout );
                }
                $typeTimeout = setTimeout(function(){
                    $crrForm.submit();
                    $typeTimeout = false;
                }, 2000);
            } )
        }

        $crrForm . submit(function(e){e.preventDefault();
            if ( ! $crrForm . hasClass( 'tw-waiting' ) ) {
                $crrForm . addClass( 'tw-waiting' );
                var $crrItemsContainer = $crrForm . siblings( '.tw-filter-items' );
                var $crrPagination     = $crrForm . siblings( '.tw-pagination' );
                
                if ( $crrItemsContainer . length ) {
                    $crrItemsContainer . remove();
                }

                if ( $crrPagination . length ) {
                    $crrPagination . remove();
                }

                $crrForm . after( '<div data-uk-spinner></div>' );

                $.ajax({
                    type: "GET",
                    url:  $crrForm.attr('action'),
                    data: $crrForm.serialize(),
                    success: function( response ) {

                        if ( $(response ) . find( '.tw-pagination' ) . length ) {
                            $crrForm . after( $(response ) . find( '.tw-pagination' ) );
                        }
                        if ( $(response ) . find( '.tw-filter-items' ) . length ) {
                            $crrForm . after( $(response ) . find( '.tw-filter-items' ) );
                        }

                        $( window ) . trigger( 'tw-init' );
                        $crrForm . removeClass( 'tw-waiting' );

                        if ( $crrForm . siblings( '.uk-spinner' ) . length ) {
                            $crrForm . siblings( '.uk-spinner' ) .remove();
                        }
                    }
                });
            }
        });

    });

    /* Organization Menu */
    $( '.organization-menu' ) . each( function(){
        if ( $(this).closest('.menu-item').length ) {
            $(this).closest('.menu-item').addClass('tw-org-menu-parent-container menu-item-has-children');
        }
    });
    /* Mobile Menu */
    $( '#mobile-menu-modal' ) . each( function(){
        if ( $(this).closest('.menu-item').length ) {
            $(this).closest('.menu-item').addClass('menu-item-has-children');
        }
    });

    /* Calendar Drop */
    $('.tw-events-calendar-weekly').each(function(){
        if ( $(this).closest( '.tw-row' ).length ) {
            $(this).closest( '.tw-row' ).css( 'z-index', '9999' );
        }
    });
    $(document).on( 'tw-drop-pos-check', '.em-calendar .uk-drop', function() {
        var $top =parseInt($(this).css('top').replace('px', ''), 10);
        if ( $(this).siblings('.tw-events-list-container').length ) {
            $(this).siblings('.tw-events-list-container').removeClass('tw-drop-pos-top');
            if ( $top<0 ) {
                $(this).siblings('.tw-events-list-container').addClass('tw-drop-pos-top');
            }
        }
    } )

    UIkit.util.on('.em-calendar .uk-drop', 'show', function () {
        $(this).trigger('tw-drop-pos-check');
    });

    /* Sidebar Navigation Menu */
    $('.sidebar-area .widget .menu li>a').each(function () {
        $(this).prepend( '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 11H19V13H5V11Z" fill="#95A1BB"/></svg>' );
    });
    
    /* Title First Word */
    $('.tw-title,.bottom-area h3.widget-title').each(function () {
        var $this = $(this);
        var $texts = $this.text().split(' ');
        $this.html( '<span>' + $texts . shift() + '</span> ' + $texts . join(' ') );
    });

    /* Filter With Title BG */
    $('.tw-filter-list-outer.filter-with-title').each(function () {
        var $crFilterCont = $(this);
        $crFilterCont
            .closest('.uk-section')
            .addClass('uk-position-relative')
            .prepend(
                '<div class="tw-absolute-helper" style="' +
                    $crFilterCont.data('abs') +
                    '"></div>'
            );
    });
    /* Clients */
    $('.tw-clients').each(function () {
        var $crClients = $(this);
        var $crRows = $('>.uk-grid', $crClients);
        if ($crRows.length > 1) {
            $crRows
                .addClass('uk-grid-divider')
                .find('.client-item')
                .addClass('uk-padding');
        }
    });
    /* Page List to Menu */
    $('ul.tw-main-menu.tw-list-pages').each(function () {
        $(this).find('li').addClass('menu-item');
        $(this)
            .find('ul')
            .addClass('sub-menu uk-animation-fade')
            .closest('li')
            .addClass('menu-item-has-children');
    });
    /* Page List to Topbar Menu */
    $('ul.tw-top-menu.tw-list-pages').each(function () {
        $(this).find('li').addClass('menu-item');
        $(this)
            .find('ul')
            .addClass('sub-menu uk-animation-fade')
            .closest('li')
            .addClass('menu-item-has-children');
    });
    /* Page List to Mobile Menu */
    $('ul.tw-mobile-list-pages').each(function () {
        $(this).find('li').addClass('menu-item');
        $(this)
            .find('ul')
            .addClass('uk-nav-sub')
            .closest('li')
            .addClass('uk-parent menu-item-has-children');
    });
    /* Animation */
    tw_anim_init('[data-anim]');

    /* Animated Background Colors */
    $('.uk-button-border.invert-colors').each(function () {
        var $color = $(this).css('color');
        var $bcolor = $(this).css('border-color');
        $(this).hover(
            function () {
                $(this).css(
                    'color',
                    $color.replace(/ /gi, '') === 'rgb(255,255,255)' ||
                        $color === '#ffffff' ||
                        $color === '#fff'
                        ? '#1f1f1f'
                        : '#fff'
                );
                $(this).css('background-color', $color);
                $(this).css('border-color', $color);
            },
            function () {
                $(this).css('color', $color);
                $(this).css('border-color', $bcolor);
                $(this).css('background-color', '');
            }
        );
    });
    $('.uk-button-flat.invert-colors').each(function () {
        var $bcolor = $(this).css('background-color');
        var $color = $(this).css('color');
        $(this).hover(
            function () {
                $(this).css('color', $bcolor);
                $(this).css('border-color', $bcolor);
                $(this).css('background-color', 'transparent');
            },
            function () {
                $(this).css('color', $color);
                $(this).css('background-color', $bcolor);
            }
        );
    });
    /* Fancybox Hover */
    $('.tw-fancybox > .tw-box').mouseover(function () {
        $(this).css('background', $(this).data('background-color'));
    });
    $('.tw-fancybox > .tw-box').mouseleave(function () {
        $(this).css('background', '');
    });
    /* MagazinePage */
    if ($('body').hasClass('page-template-page-magazinepage')) {
        jQuery(window).on('tw-magazine-light', function () {
            var $cHdr = $('.tw-header');
            var $cHdrCol = 'dark';
            var $cHdrR = $('.uk-navbar-right i');
            jQuery('.main-container>.uk-section,.main-container>.tw-section')
                .each(function () {
                    var $cSec = jQuery(this);
                    var $cSecTop = $cSec.offset().top;
                    var $cSecAllH = $cSecTop + $cSec.height();
                    var $hdrTop = jQuery(window).scrollTop();
                    var $hdrAllH = $hdrTop + $cHdr.height();
                    if ($hdrAllH <= $cSecAllH && $hdrTop >= $cSecTop) {
                        if ($cSec.hasClass('uk-light')) {
                            $cHdrCol = 'light';
                        }
                        return false;
                    }
                })
                .promise()
                .done(function () {
                    setTimeout(function () {
                        if (
                            $cHdr.hasClass('uk-sticky-fixed') ||
                            window.matchMedia('(max-width: 1199px)').matches
                        ) {
                            $cHdrR
                                .removeClass('uk-light')
                                .removeClass('uk-dark');
                        } else {
                            if ($cHdrCol === 'dark') {
                                $cHdrR
                                    .removeClass('uk-light')
                                    .addClass('uk-dark');
                            } else {
                                $cHdrR
                                    .removeClass('uk-dark')
                                    .addClass('uk-light');
                            }
                        }
                    }, 200);
                });
        });
        jQuery(window).scroll(function () {
            jQuery(window).trigger('tw-magazine-light');
        });
        jQuery(window).resize(function () {
            jQuery(window).trigger('tw-magazine-light');
        });
    }

    /* Full and Split Page */
    var $crPage = $('.main-container');
    /* SplitPage */
    if ($().multiscroll !== undefined && $().multiscroll !== 'undefined') {
        var $crSs = $('>div>.ms-section', $crPage);
        var $indL = 0;
        var $indR = -1;
        $('>.uk-section,>.tw-section', $crSs).addClass(
            'uk-flex uk-flex-center uk-flex-middle'
        );
        $('>.ms-left>.ms-section', $crPage)
            .addClass('ms-left-item')
            .each(function (i) {
                $indL += i % 2 ? 3 : 1;
                var $idSec = $(this)
                    .find('.uk-section[id],.tw-section[id]')
                    .first();
                $(this)
                    .attr('data-index', i)
                    .attr(
                        'data-index-small',
                        $idSec.length ? $idSec.attr('id') : $indL
                    );
            });
        $('>.ms-right>.ms-section', $crPage)
            .addClass('ms-right-item')
            .each(function (i) {
                $indR += i % 2 ? 1 : 3;
                var $idSec = $(this)
                    .find('.uk-section[id],.tw-section[id]')
                    .first();
                $(this)
                    .attr('data-index', i)
                    .attr(
                        'data-index-small',
                        $idSec.length ? $idSec.attr('id') : $indR
                    );
            });
        jQuery(window).on('tw-split-light', function () {
            var $spLeft = $('.tw-logo .site-name a');
            var $spLeftImgD = $('.tw-logo .logo-img:not(.logo-light)');
            var $spLeftImgL = $('.tw-logo .logo-img.logo-light');
            var $spRight = $('.uk-navbar-right i,#multiscroll-nav ul');
            var $crLeft = $(
                '.ms-left>.ms-section.active>.uk-section,.ms-left>.ms-section.active>.tw-section',
                $crPage
            );
            var $crRight = $(
                '.ms-right>.ms-section.active>.uk-section,.ms-right>.ms-section.active>.tw-section',
                $crPage
            );
            if ($crLeft.length && $crLeft.first().hasClass('uk-light')) {
                if ($spLeft.length) {
                    $spLeft.removeClass('uk-dark').addClass('uk-light');
                } else if ($spLeftImgD.length && $spLeftImgL.length) {
                    $spLeftImgD.css('opacity', 0);
                    $spLeftImgL.css('opacity', 1);
                }
            } else {
                if ($spLeft.length) {
                    $spLeft.removeClass('uk-light').addClass('uk-dark');
                } else if ($spLeftImgD.length && $spLeftImgL.length) {
                    $spLeftImgL.css('opacity', 0);
                    $spLeftImgD.css('opacity', 1);
                }
            }
            if ($crRight.length && $crRight.first().hasClass('uk-light')) {
                $spRight.removeClass('uk-dark').addClass('uk-light');
            } else {
                $spRight.removeClass('uk-light').addClass('uk-dark');
            }
        });
        $crPage.multiscroll({
            verticalCentered: false,
            navigation: true,
            scrollingSpeed: 700,
            keyboardScrolling: true,
            easing: 'easeInQuart',
            afterRender: function (anchorLink, index) {
                jQuery(window).trigger('tw-split-light');
                var changeLogo = jQuery(
                    '.tw-logo .site-name a,#multiscroll-nav ul'
                );
                var changeLogo2 = jQuery('.tw-header-meta .mobile-menu i');
                changeLogo.addClass('uk-dark');
                changeLogo2.addClass('uk-light');
                tw_anim_data_con($('[data-uk-scrollspy],[uk-scrollspy]'));
                tw_in(
                    $crSs
                        .filter('.active')
                        .find('[data-uk-scrollspy],[uk-scrollspy]')
                );
                tw_out(
                    $crSs
                        .filter(':not(.active)')
                        .find('[data-uk-scrollspy],[uk-scrollspy]')
                );
            },
            afterLoad: function (anchorLink, index) {
                jQuery(window).trigger('tw-split-light');
                tw_in(
                    $crSs
                        .filter('.active')
                        .find('[data-uk-scrollspy],[uk-scrollspy]')
                );
                tw_out(
                    $crSs
                        .filter(':not(.active)')
                        .find('[data-uk-scrollspy],[uk-scrollspy]')
                );
            },
        });
        jQuery(window).on('tw-resize', function () {
            if (window.matchMedia('(min-width: 960px)').matches) {
                if ($('body').hasClass('tw-split-small')) {
                    $('>.ms-left>.ms-right-item', $crPage).appendTo(
                        $('>.ms-right', $crPage)
                    );
                    $('>.ms-left>.ms-section', $crPage)
                        .sort(function (a, b) {
                            return (
                                parseInt($(a).attr('data-index'), 10) -
                                parseInt($(b).attr('data-index'), 10)
                            );
                        })
                        .appendTo($('>.ms-left', $crPage));
                    $('>.ms-right>.ms-section', $crPage)
                        .sort(function (a, b) {
                            return (
                                parseInt($(b).attr('data-index'), 10) -
                                parseInt($(a).attr('data-index'), 10)
                            );
                        })
                        .appendTo($('>.ms-right', $crPage));

                    $('body').addClass('tw-split-small');
                    $('body').removeClass('tw-split-small');
                    $.fn.multiscroll.build();
                }
            } else {
                if (!$('body').hasClass('tw-split-small')) {
                    $.fn.multiscroll.destroy();
                    $('>.ms-right>.ms-right-item', $crPage).appendTo(
                        $('>.ms-left', $crPage)
                    );
                    $('body').addClass('tw-split-small');
                    $('>.ms-left>.ms-section', $crPage)
                        .sort(function (a, b) {
                            return (
                                parseInt($(a).attr('data-index-small'), 10) -
                                parseInt($(b).attr('data-index-small'), 10)
                            );
                        })
                        .appendTo($('>.ms-left', $crPage));
                }
            }
        });
    }
    /* FullPage */
    if ($().fullpage !== undefined && $().fullpage !== 'undefined') {
        var $crFooter =
            $('footer').length &&
            ($('footer').children().length || $('footer').text().trim().length)
                ? $('footer')
                : false;
        var $secSel = 'tw-fullpage-section';
        $('>*:not(footer)', $crPage).addClass($secSel);
        $secSel = '.' + $secSel;
        var $secAll = $('>' + $secSel, $crPage);
        var $secLast = $secAll.last();
        var $navigation = $secAll.length > 1 ? true : false;
        var $scrollingSpeed = parseInt($crPage.data('speed'), 10);
        var $DownIn = $crPage.data('down-in');
        var $DownInDelay = $crPage.data('down-in-delay')
            ? parseInt($crPage.data('down-in-delay'), 10)
            : 0;
        var $DownOut = $crPage.data('down-out');
        var $DownOutDelay = $crPage.data('down-out-delay')
            ? parseInt($crPage.data('down-out-delay'), 10)
            : 0;
        var $UpIn = $crPage.data('up-in');
        var $UpInDelay = $crPage.data('up-in-delay')
            ? parseInt($crPage.data('up-in-delay'), 10)
            : 0;
        var $UpOut = $crPage.data('up-out');
        var $UpOutDelay = $crPage.data('up-out-delay')
            ? parseInt($crPage.data('up-out-delay'), 10)
            : 0;
        tw_anim_data_con($('[data-uk-scrollspy],[uk-scrollspy]'));
        $crPage.fullpage({
            navigation: $navigation,
            verticalCentered: true,
            responsiveWidth: 959,
            css3: true,
            fixedElements: 'footer',
            scrollingSpeed: $scrollingSpeed,
            sectionSelector: $secSel,
            afterRender: function () {
                if (
                    $('.tw-header').length &&
                    $('#fp-nav>ul').length &&
                    $('.tw-header').hasClass('uk-light')
                ) {
                    $('#fp-nav>ul').addClass('uk-light');
                }
            },
            onLeave: function (index, nextIndex, direction) {
                if (window.matchMedia('(min-width: 960px)').matches) {
                    if (
                        $crFooter &&
                        ($crFooter.hasClass('footer-up') ||
                            $crFooter.hasClass('footer-down'))
                    ) {
                        $crFooter.trigger('tw-footer-down');
                        return false;
                    }
                    var $out = $('>' + $secSel, $crPage).eq(index - 1);
                    var $in = $('>' + $secSel, $crPage)
                        .eq(nextIndex - 1)
                        .addClass('tw-visible');
                    var $crDownInDelay = $DownInDelay;
                    var $crDownOutDelay = $DownOutDelay;
                    var $crUpInDelay = $UpInDelay;
                    var $crUpOutDelay = $UpOutDelay;
                    var $crDownIn = $DownIn;
                    var $crDownOut = $DownOut;
                    var $crUpIn = $UpIn;
                    var $crUpOut = $UpOut;
                    if (
                        $in.data('down-in-delay') !== 'undefined' &&
                        $in.data('down-in-delay') !== undefined
                    ) {
                        $crDownInDelay = parseInt(
                            $in.data('down-in-delay'),
                            10
                        );
                    }
                    if (
                        $in.data('down-out-delay') !== 'undefined' &&
                        $in.data('down-out-delay') !== undefined
                    ) {
                        $crDownOutDelay = parseInt(
                            $in.data('down-out-delay'),
                            10
                        );
                    }
                    if (
                        $in.data('up-in-delay') !== 'undefined' &&
                        $in.data('up-in-delay') !== undefined
                    ) {
                        $crUpInDelay = parseInt($in.data('up-in-delay'), 10);
                    }
                    if (
                        $in.data('up-out-delay') !== 'undefined' &&
                        $in.data('up-out-delay') !== undefined
                    ) {
                        $crUpOutDelay = parseInt($in.data('up-out-delay'), 10);
                    }

                    if ($in.data('down-in')) {
                        $crDownIn = $in.data('down-in');
                    }
                    if ($out.data('down-out')) {
                        $crDownOut = $out.data('down-out');
                    }
                    if ($in.data('up-in')) {
                        $crUpIn = $in.data('up-in');
                    }
                    if ($out.data('up-out')) {
                        $crUpOut = $out.data('up-out');
                    }
                    /* For Owl ReAnimate */
                    if ($('.tw-owl-item-in-view', $in).length) {
                        $('.tw-owl-item-in-view', $in).removeClass(
                            'tw-owl-item-in-view'
                        );
                    }

                    if (direction === 'down') {
                        if ($crDownIn) {
                            $in.addClass('tw-in-delaying');
                            setTimeout(function () {
                                $in.removeClass('tw-in-delaying').addClass(
                                    $crDownIn
                                );
                                tw_in(
                                    $('[data-uk-scrollspy],[uk-scrollspy]', $in)
                                );
                                setTimeout(function () {
                                    $in.removeClass($crDownIn);
                                }, $scrollingSpeed);
                            }, $crDownInDelay);
                        }
                        if ($crDownOut) {
                            $out.addClass('tw-out-delaying');
                            setTimeout(function () {
                                $out.addClass($crDownOut);
                                setTimeout(function () {
                                    $out.removeClass('tw-out-delaying')
                                        .removeClass('tw-visible')
                                        .removeClass($crDownOut);
                                }, $scrollingSpeed);
                                tw_out(
                                    $(
                                        '[data-uk-scrollspy],[uk-scrollspy]',
                                        $in.siblings('section')
                                    )
                                );
                            }, $crDownOutDelay);
                        }
                    } else {
                        if ($crUpIn) {
                            $in.addClass('tw-in-delaying');
                            setTimeout(function () {
                                $in.removeClass('tw-in-delaying').addClass(
                                    $crUpIn
                                );
                                tw_in(
                                    $('[data-uk-scrollspy],[uk-scrollspy]', $in)
                                );
                                setTimeout(function () {
                                    $in.removeClass($crUpIn);
                                }, $scrollingSpeed);
                            }, $crUpInDelay);
                        }
                        if ($crUpOut) {
                            $out.addClass('tw-out-delaying');
                            setTimeout(function () {
                                $out.addClass($crUpOut);
                                setTimeout(function () {
                                    $out.removeClass('tw-out-delaying')
                                        .removeClass('tw-visible')
                                        .removeClass($crUpOut);
                                }, $scrollingSpeed);
                                tw_out(
                                    $(
                                        '[data-uk-scrollspy],[uk-scrollspy]',
                                        $in.siblings('section')
                                    )
                                );
                            }, $crUpOutDelay);
                        }
                    }
                }
            },
        });
        if ($crFooter) {
            var $crFooterH = $crFooter.outerHeight();
            $crFooter.bind('tw-footer-up', function () {
                if (!$crFooter.hasClass('footer-up')) {
                    $crFooter.addClass('footer-up').removeClass('footer-down');
                    $crPage.css('margin-top', '-' + $crFooterH + 'px');
                }
            });
            $crFooter.bind('tw-footer-down', function () {
                if (!$crFooter.hasClass('footer-down')) {
                    $crFooter.addClass('footer-down').removeClass('footer-up');
                    setTimeout(function () {
                        $crFooter.removeClass('footer-down');
                    }, $scrollingSpeed);
                    $crPage.css('margin-top', '');
                }
            });
            $secLast.add($crFooter).bind('mousewheel', function (e) {
                if (window.matchMedia('(min-width: 960px)').matches) {
                    if (
                        e.originalEvent.wheelDelta <= -10 &&
                        $(this).hasClass('active')
                    ) {
                        $crFooter.trigger('tw-footer-up');
                    } else if (
                        e.originalEvent.wheelDelta >= 10 &&
                        $secAll.length <= 1 &&
                        $crFooter.hasClass('footer-up')
                    ) {
                        $crFooter.trigger('tw-footer-down');
                    }
                }
            });
        }
        jQuery(window).on('tw-resize', function () {
            var $ = jQuery;
            var $crPageH = $('body').height() - $('body').offset().top;
            if ($('.tw-topbar').length) {
                $crPageH -= $('.tw-topbar').outerHeight();
            }
            $crPage.css('max-height', $crPageH + 'px');

            if ($crFooter && $crFooter.hasClass('footer-up')) {
                $crFooter.trigger('tw-footer-down');
            }
        });
    }
});
jQuery(window).on('load', function () {
    'use strict';
    var $ = jQuery;
    /* Nested BG */
    $('.tw-nested-bg').each(function () {
        var $curr = $(this).css('backgound-color', '');
        var $currColor = 'red';
        $curr
            .parents()
            .each(function () {
                var $subColor = $(this)
                    .css('background-color')
                    .replace(/ /gi, '');
                if (
                    $subColor !== '' &&
                    $subColor !== 'transparent' &&
                    $subColor !== 'rgba(0,0,0,0)'
                ) {
                    $currColor = $subColor;
                    return false;
                }
            })
            .promise()
            .done(function () {
                $curr.css('background-color', $currColor);
            });
    });
    //Preloader
    if ($('body').hasClass('loading')) {
        var $preLoader = $('body>.tw-preloader');
        if ($preLoader.length) {
            $preLoader.animate(
                {
                    opacity: 0,
                    visibility: 'hidden',
                },
                500
            );
            $('body').removeClass('loading');
            $(window).trigger('tw-resize');
        } else {
            $('body').removeClass('loading');
        }
    }

    /* Google Map Style */
    $('.tw-map').each(function (i) {
        var $currMapID = 'lvly-map-styled-' + i;
        var $currMap = $(this);
        var $currMapStyle = $currMap.data('style');
        var $currMapMouse = $currMap.data('mouse');
        var $currMapLat = $currMap.data('lat');
        var $currMapLng = $currMap.data('lng');
        var $currMapZoom = $currMap.data('zoom');
        var $currMapArea = $currMap.children('.map').attr('id', $currMapID);

        var $map;
        var $center = new google.maps.LatLng($currMapLat, $currMapLng);
        var MY_MAPTYPE_ID = 'custom_style_' + i;
        $map = new google.maps.Map(document.getElementById($currMapID), {
            zoom: $currMapZoom,
            center: $center,
            mapTypeControlOptions: {
                mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID],
            },
            mapTypeId: MY_MAPTYPE_ID,
        });

        if ($('body').hasClass('page-template-page-splitpage')) {
            var $currContSec = $(
                '>.uk-section,>.tw-section',
                $currMap.closest('.ms-section')
            ).first();
            jQuery(window).on('tw-resize', function () {
                $currMap.width($currContSec.width());
                var $center = $map.getCenter();
                google.maps.event.trigger($map, 'resize');
                $map.setCenter($center);
            });
        }

        $map.setOptions({ scrollwheel: $currMapMouse });
        var $featureOpts = eval($currMap.data('json'));

        $map.mapTypes.set(
            MY_MAPTYPE_ID,
            new google.maps.StyledMapType($featureOpts, { name: $currMapStyle })
        );
        /* markers */
        var $mapMarker = true;
        $(window).scroll(function () {
            var addH = 500;
            var $lnkAllH = $currMap.offset().top + $currMap.height();
            var $wndAllH = $(window).scrollTop() + $(window).height() + addH;
            if ($mapMarker && $lnkAllH < $wndAllH) {
                $mapMarker = false;
                $currMapArea
                    .siblings('.map-markers')
                    .children('.map-marker')
                    .each(function (j) {
                        var $currMar = $(this);
                        var $currMarTitle = $currMar.data('title');
                        var $currMarLat = $currMar.data('lat');
                        var $currMarLng = $currMar.data('lng');
                        var $currMarIconSrc = $currMar.data('iconsrc');
                        var $currMarIconWidth = $currMar.data('iconwidth');
                        var $currMarIconHeight = $currMar.data('iconheight');

                        var markerOp = {
                            position: new google.maps.LatLng(
                                $currMarLat,
                                $currMarLng
                            ),
                            map: $map,
                            title: $currMarTitle,
                            animation: google.maps.Animation.DROP,
                            zIndex: j,
                        };
                        if (
                            $currMarIconSrc &&
                            $currMarIconWidth &&
                            $currMarIconHeight
                        ) {
                            markerOp.icon = {
                                url: $currMarIconSrc,
                                size: new google.maps.Size(
                                    $currMarIconWidth,
                                    $currMarIconHeight
                                ),
                                origin: new google.maps.Point(0, 0),
                                anchor: new google.maps.Point(
                                    parseInt($currMarIconWidth, 10) / 2,
                                    $currMarIconHeight
                                ),
                            };
                        }
                        setTimeout(function () {
                            var marker = new google.maps.Marker(markerOp);
                            var infowindow = new google.maps.InfoWindow({
                                content: $currMar.html(),
                            });
                            google.maps.event.addListener(
                                marker,
                                'click',
                                function () {
                                    if (infowindow.getMap()) {
                                        infowindow.close();
                                    } else {
                                        infowindow.open($map, marker);
                                    }
                                }
                            );
                        }, j * 300);
                    });
            }
        });
    });

    $('.tw-lovely-slider').each(function () {
        var $cFeatPost = $(this);
        var $cFeatPostItems = $cFeatPost.children('.post-item');
        var $auto = $(this).data('autoplay');
        var $autoplay = $auto;
        var $time = 0;
        var $timeInt = 1000;
        var $timeMax = 3000;
        $cFeatPostItems.each(function () {
            var $cFeatPostItem = $(this);
            $cFeatPostItem.on({
                mouseenter: function () {
                    $cFeatPostItem
                        .addClass('active')
                        .siblings('.post-item')
                        .removeClass('active');
                    $auto = false;
                },
                mouseleave: function () {
                    $time = 0;
                    $auto = $autoplay;
                },
            });
        });
        if ($cFeatPostItems.length > 1) {
            setInterval(function () {
                if ($auto && $time > $timeMax) {
                    $time = 0;
                    var $activeItem = $cFeatPost.children('.post-item.active');
                    var $nextItem = $activeItem
                        .next('.post-item')
                        .hasClass('post-item')
                        ? $activeItem.next('.post-item')
                        : $cFeatPostItems.eq(0);
                    $nextItem.addClass('active');
                    $activeItem.removeClass('active');
                } else {
                    $time += $timeInt;
                }
            }, $timeInt);
        }
    });

    $('.tw-text-animate').each(function () {
        var $this = $(this);
        var arr = $this.html().trim().split('');
        var $html = '';
        var $tag = false;
        var $delay = 0;
        arr.forEach(function (element) {
            if (element === '<') {
                $tag = true;
            }
            if (!$tag) {
                $delay += 0.04;
                $html +=
                    '<span style="transition-delay: ' +
                    $delay +
                    's">' +
                    element +
                    '</span>';
            } else {
                $html += element;
            }
            if (element === '>') {
                $tag = false;
            }
        });
        $this.html($html);
        setTimeout(function () {
            $this.addClass('active');
        }, 500);
    });

    // justifiedGallery
    if (
        $().justifiedGallery !== undefined &&
        $().justifiedGallery !== 'undefined'
    ) {
        $('.tw-justified-gallery-container').each(function () {
            var $crJstGallCont = $(this);
            var $crJstGall = $('.tw-justified-gallery', $crJstGallCont);
            var $margins =
                undefined === $crJstGallCont.data('margins')
                    ? 40
                    : parseInt($crJstGallCont.data('margins'), 10);
            var $rowHeight =
                undefined === $crJstGallCont.data('row-height')
                    ? 400
                    : parseInt($crJstGallCont.data('row-height'), 10);
            var $rowHeightMax =
                undefined === $crJstGallCont.data('row-height-max') ||
                !$crJstGallCont.data('row-height-max')
                    ? false
                    : $rowHeight;
            $crJstGall.justifiedGallery({
                lastRow: 'justify',
                border: 0,
                margins: $margins,
                rowHeight: $rowHeight,
                maxRowHeight: $rowHeightMax,
            });
        });
    }

    // theiaStickySidebar
    if (
        $().theiaStickySidebar !== undefined &&
        $().theiaStickySidebar !== 'undefined'
    ) {
        var $additionalMarginTop = 90;
        var $additionalMarginBottom = 0;
        if ($('header[data-uk-sticky]').length) {
            $additionalMarginTop += 40;
        }
        if ($('body.single-portfolio').length) {
            $additionalMarginBottom += 40;
        }
        $('.content-area, .sidebar-area, .sticky-sidebar').theiaStickySidebar({
            // Settings
            additionalMarginTop: $additionalMarginTop,
            additionalMarginBottom: $additionalMarginBottom,
        });
    }

    // OwlCarousel
    if ($().owlCarousel !== undefined && $().owlCarousel !== 'undefined') {
        $('.owl-carousel:not(.thumbs)').each(function () {
            var $this = $(this);
            var $cont = $this
                .closest('.tw-owl-carousel-container,.tw-gallery-carousel')
                .first();
            var $responsive = {};
            var $responsiveRefreshRate = 1100;
            var $thumbs = [];
            var $animateOut = false;
            var $animDoneDelay = 0;
            var $singleItem = false;
            var $autoHeight = true;

            var $nav =
                undefined === $cont.data('nav') ? false : $cont.data('nav');
            var $loop =
                undefined === $cont.data('loop') ? true : $cont.data('loop');
            var $dots =
                undefined === $cont.data('dots') ? true : $cont.data('dots');
            var $center =
                undefined === $cont.data('center')
                    ? false
                    : $cont.data('center');
            var $autoWidth =
                undefined === $cont.data('auto-width')
                    ? false
                    : $cont.data('auto-width');
            var $autoHeightLowest =
                undefined === $cont.data('auto-height-lowest')
                    ? false
                    : $cont.data('auto-height-lowest');
            var $dotsEach =
                undefined === $cont.data('dots-each')
                    ? false
                    : $cont.data('dots-each');
            var $autoplay =
                undefined === $cont.data('autoplay')
                    ? false
                    : $cont.data('autoplay');
            var $autoplayHoverPause =
                undefined === $cont.data('autoplay-hover-pause')
                    ? false
                    : $cont.data('autoplay-hover-pause');

            var $autoplayTimeout = parseInt(
                undefined === $cont.data('autoplay-timeout')
                    ? 5000
                    : $cont.data('autoplay-timeout'),
                10
            );
            var $items = parseInt(
                undefined === $cont.data('items') ? 1 : $cont.data('items'),
                10
            );
            var $margin = parseInt(
                undefined === $cont.data('margin') ? 0 : $cont.data('margin'),
                10
            );

            if ($items === 1) {
                $singleItem = true;
            } else if ($items > 3) {
                $responsive = {
                    0: { items: 1 },
                    360: { items: 2 },
                    640: { items: 3 },
                    960: { items: $items },
                };
            } else if ($items === 3) {
                $responsive = {
                    0: { items: 1 },
                    640: { items: 2 },
                    960: { items: 3 },
                };
            } else if ($items < 3) {
                $responsive = {
                    0: { items: 1 },
                    360: { items: $items },
                };
            }

            if ($this.hasClass('big-images')) {
                $thumbs = $this
                    .closest('.uk-grid-collapse')
                    .find('.owl-carousel.thumbs');
                $margin = 30;
                $items = 1;
                $center = true;
                $loop = true;
                $nav = true;
                $dots = false;
                $animateOut =
                    'uk-animation-fade uk-animation-reverse uk-animation-fast';
            } else if ($this.hasClass('instagram-pics')) {
                if ($this.data('auto-play')) {
                    $autoplay = true;
                    $autoplayTimeout = parseInt($this.data('auto-play'), 10);
                }
                $items = 8;
                $responsive = {
                    0: {
                        items: 3,
                    },
                    640: {
                        items: 4,
                    },
                    960: {
                        items: 6,
                    },
                };
            }

            /* SetTimeout is for carousel-testimonial with scrollspy */
            setTimeout(function () {
                var $animGens = $cont.filter(
                    '[data-uk-scrollspy],[uk-scrollspy]'
                );
                $this.on('initialized.owl.carousel', function () {
                    var $animDatas = tw_anim_data_con(
                        $animGens,
                        '.owl-item.active:not(.tw-owl-item-in-view) ',
                        '.owl-item:not(.active) '
                    );
                    if ($animDatas.length && $animDatas[0].delay) {
                        $animDoneDelay =
                            $items * parseInt($animDatas[0].delay, 10);
                    }
                    tw_anim_data_con(
                        $('[data-uk-scrollspy],[uk-scrollspy]', $this)
                    );
                    $('.owl-item.active', $this).addClass(
                        'tw-owl-item-in-view'
                    );
                    tw_out(
                        $animGens.add(
                            $(
                                '.owl-item:not(.active)[data-uk-scrollspy],.owl-item:not(.active)[uk-scrollspy],.owl-item:not(.active) [data-uk-scrollspy],.owl-item:not(.active) [uk-scrollspy]',
                                $this
                            )
                        )
                    );
                    //Fix width bug for window no scroll
                    setTimeout(function () {
                        $('.owl-item:not(.cloned)', $this).each(function (i) {
                            $(this).attr('tw-index', i);
                        });
                        $this.trigger('refresh.owl.carousel');
                    });
                });
                $this.owlCarousel({
                    singleItem: $singleItem,
                    autoWidth: $autoWidth,
                    autoHeight: $autoHeight,
                    // navText: [
                    //     '<i data-uk-slidenav-previous></i>',
                    //     '<i data-uk-slidenav-next></i>',
                    // ],
                    nav: $nav,
                    dots: $dots,
                    loop: $loop,
                    autoplay: $autoplay,
                    autoplayTimeout: $autoplayTimeout,
                    autoplayHoverPause: $autoplayHoverPause,
                    smartSpeed: 500,
                    items: $items,
                    center: $center,
                    responsiveRefreshRate: $responsiveRefreshRate,
                    responsive: $responsive,
                    margin: $margin,
                    dotsEach: $dotsEach,
                    animateOut: $animateOut,
                });
                $this.on('resized.owl.carousel', function () {
                    setTimeout(function () {
                        // Waves Custom Auto Height Lowest
                        $this.trigger('tw-auto-height-lowest');
                    }, 500);
                });
                $this.on('changed.owl.carousel', function () {
                    setTimeout(function () {
                        // Waves Custom Auto Height Lowest
                        $this.trigger('tw-auto-height-lowest');
                        // BG Video
                        tw_bg_video(
                            $('.owl-item.active .tw-owl-bg-video', $this),
                            'owl'
                        );
                        $(
                            '.owl-item:not(.active) .tw-owl-bg-video',
                            $this
                        ).html('');
                        // Animate
                        $this.trigger('tw-animate');
                    });
                });
                $this.on('tw-auto-height-lowest', function () {
                    if ($autoHeightLowest) {
                        var $min = false;
                        $('.owl-item.active', $this)
                            .each(function () {
                                var $crH = $(this).height();
                                if ($min === false || $min > $crH) {
                                    $min = $crH;
                                }
                            })
                            .promise()
                            .done(function () {
                                $('.owl-stage-outer', $this).animate(
                                    { maxHeight: $min },
                                    500
                                );
                            });
                    }
                });
                $this.on('tw-animate', function () {
                    var $in = $(
                        '.owl-item.active:not(.tw-owl-item-in-view)[data-uk-scrollspy],.owl-item.active:not(.tw-owl-item-in-view)[uk-scrollspy],.owl-item.active:not(.tw-owl-item-in-view) [data-uk-scrollspy],.owl-item.active:not(.tw-owl-item-in-view) [uk-scrollspy]',
                        $this
                    );
                    var $out = $(
                        '.owl-item:not(.active)[data-uk-scrollspy],.owl-item:not(.active)[uk-scrollspy],.owl-item:not(.active) [data-uk-scrollspy],.owl-item:not(.active) [uk-scrollspy]',
                        $this
                    );
                    tw_in($animGens.add($in));
                    tw_out($animGens.add($out));
                    setTimeout(function () {
                        $('.owl-item:not(.active)', $this)
                            .removeClass('tw-owl-item-in-view')
                            .siblings('.owl-item.active')
                            .each(function () {
                                var $crAnimEl = $(this);
                                var $crAnimElInd = $crAnimEl.attr('tw-index');
                                $crAnimEl.addClass('tw-owl-item-in-view');
                                if ($crAnimElInd) {
                                    var $crAnimElEq = $crAnimEl.siblings(
                                        '[tw-index="' + $crAnimElInd + '"]'
                                    );
                                    if ($crAnimElEq.length) {
                                        $crAnimElEq
                                            .addClass('tw-owl-item-in-view')
                                            .removeClass('tw-outview');
                                        tw_in(
                                            $crAnimElEq
                                                .filter(
                                                    '[data-uk-scrollspy],[uk-scrollspy]'
                                                )
                                                .add(
                                                    $(
                                                        '[data-uk-scrollspy],[uk-scrollspy]',
                                                        $crAnimElEq
                                                    )
                                                )
                                        );
                                    }
                                }
                            });
                    }, $animDoneDelay);
                });
                if ($thumbs.length) {
                    var $flag = false;
                    var $duration = 300;
                    $this.on('changed.owl.carousel', function (el) {
                        var current =
                            el.item.index - el.relatedTarget._clones.length / 2;
                        $thumbs
                            .find('.owl-item')
                            .removeClass('current')
                            .eq(current)
                            .addClass('current');
                        var onscreen =
                            $thumbs.find('.owl-item.active').length - 1;
                        var start = $thumbs
                            .find('.owl-item.active')
                            .first()
                            .index();
                        var end = $thumbs
                            .find('.owl-item.active')
                            .last()
                            .index();
                        if (current > end) {
                            $thumbs.data('owl.carousel').to(current, 100, true);
                        }
                        if (current < start) {
                            $thumbs
                                .data('owl.carousel')
                                .to(current - onscreen, 100, true);
                        }
                        setTimeout(function () {
                            $('.owl-item.active', $this)
                                .first()
                                .addClass('active-first')
                                .siblings('.owl-item')
                                .removeClass('active-first');
                        }, $animDoneDelay);
                    });

                    $thumbs
                        .on('initialized.owl.carousel', function () {
                            $thumbs.find('.owl-item').eq(0).addClass('current');
                            /* Resize fire for main slider width bug fix */
                            $this.trigger('refresh.owl.carousel');
                        })
                        .owlCarousel({
                            margin: 0,
                            items: 4,
                            nav: false,
                            dots: false,
                            mouseDrag: false,
                        });

                    $thumbs
                        .on('click', '.owl-item', function () {
                            $this.trigger('to.owl.carousel', [
                                $(this).index(),
                                $duration,
                                true,
                            ]);
                        })
                        .on('changed.owl.carousel', function (e) {
                            if (!$flag) {
                                $flag = true;
                                $this.trigger('to.owl.carousel', [
                                    e.item.index,
                                    $duration,
                                    true,
                                ]);
                                $flag = false;
                            }
                        });
                }
            }, 100);
        });
    }

    // PROGRESS
    $('.progress-item').each(function () {
        var $crProgCont = $(this);
        var $crProg = $('progress', $crProgCont);
        var $crVal = $crProg.attr('value');
        $crProg
            .on('tw-animate', function () {
                $crProg.addClass('no-trans').val(0);
                setTimeout(function () {
                    $crProg.removeClass('no-trans').val($crVal);
                }, 100);
            })
            .trigger('tw-animate');
        $crProgCont.on('inview', function () {
            $crProg.trigger('tw-animate');
        });
    });
    // Counter Up
    $('.tw-counterup').each(function () {
        /*  data-txt="$" data-sep="," data-dur="3000" */
        var $crCntrUpCont = $(this);
        var $crSlctr = $crCntrUpCont.data('slctr')
            ? $crCntrUpCont.data('slctr')
            : 'h1';
        var $crCntrUp = $($crSlctr, $crCntrUpCont);
        var $crCnt = parseInt($crCntrUp.text().replace(/ /gi, ''), 10);
        var $crDur = $crCntrUpCont.data('dur')
            ? parseInt($crCntrUpCont.data('dur'), 10)
            : 300;
        var $crTxt = $crCntrUpCont.data('txt') ? $crCntrUpCont.data('txt') : '';
        var $crSep = $crCntrUpCont.data('sep') ? $crCntrUpCont.data('sep') : '';
        var $crInt = 3;
        if ($crInt > $crDur) {
            $crInt = $crDur;
        }
        var $crStp = $crCnt / ($crDur / $crInt);
        if ($crStp <= 0 || isNaN($crStp)) {
            $crStp = $crCnt;
        }
        $crCntrUp
            .on('tw-animate', function () {
                if ($crCntrUp.data('tw-counting') !== 'true') {
                    $crCntrUp.data('tw-counting', 'true');
                    var $i = 0;
                    var $iTxt = '';
                    var $iTmp = '';
                    var $ml = setInterval(function () {
                        $iTxt = '';
                        $i = $i + $crStp;
                        if ($i >= $crCnt) {
                            $i = $crCnt;
                            clearInterval($ml);
                            $crCntrUp.data('tw-counting', 'false');
                        }
                        $iTmp = (parseInt($i, 10) + '').split('');
                        for (var i = 0, l = $iTmp.length; i < l; i++) {
                            if (i !== 0 && i % 3 === 0) {
                                $iTxt = $crSep + $iTxt;
                            }
                            $iTxt = $iTmp[l - 1 - i] + $iTxt;
                        }
                        $crCntrUp.text($iTxt + $crTxt);
                    }, $crInt);
                }
            })
            .trigger('tw-animate');
        $crCntrUpCont.on('inview', function () {
            $crCntrUp.trigger('tw-animate');
        });
    });
    // Chart Circle
    $('.tw-chart-circle').each(function () {
        var $currentCircleChartCont = $(this);
        var $currentCircleChart = $('>.tw-chart', $currentCircleChartCont);
        $currentCircleChart.easyPieChart({
            animate: 1000,
            lineWidth: $currentCircleChart.attr('data-width'),
            size: $currentCircleChart.attr('data-size'),
            barColor: $currentCircleChart.attr('data-color'),
            trackColor: $currentCircleChart.attr('data-trackcolor'),
            scaleColor: false,
            lineCap: 'butt',
            onStep: function () {
                $currentCircleChart.css(
                    'line-height',
                    $currentCircleChart.attr('data-size') + 'px'
                );
                $currentCircleChart.css(
                    'width',
                    $currentCircleChart.attr('data-size') + 'px'
                );
                $currentCircleChart.css(
                    'height',
                    $currentCircleChart.attr('data-size') + 'px'
                );
            },
        });
        $currentCircleChartCont.on('inview', function () {
            $currentCircleChart
                .data('easyPieChart')
                .disableAnimation()
                .update(0)
                .enableAnimation()
                .update($currentCircleChart.attr('data-percent'));
        });
    });
    $('.tw-flipbox').on({
        mouseenter: function () {
            $(this).addClass('flipped');
        },
        mouseleave: function () {
            $(this).removeClass('flipped');
        },
    });

    // Animated Background Colors
    $('.tw-hover-btn').each(function () {
        var $color = $(this).css('background-color');
        $(this).on({
            mouseenter: function () {
                $(this).css('background-color', 'transparent');
                $(this).css('border-color', $color);
                $(this).css('color', $color);
            },
            mouseleave: function () {
                $(this).css('color', '#fff');
                $(this).css('background-color', $color);
            },
        });
    });

    // init Isotope
    $('.tw-isotope-container').each(function () {
        var $crCont = $(this);
        var $crLayout = $crCont.data('layout');
        var $layoutMode = 'masonry';
        var $itemSelector = $crCont.data('item-selector')
            ? $crCont.data('item-selector')
            : '.uk-grid>*';
        var $crGrid = $('.isotope-container', $crCont);
        if ($crGrid.length) {
            if ($crLayout === 'grid') {
                $layoutMode = 'fitRows';
            }
            if ($('.grid-sizer', $crGrid).length === 0) {
                $crGrid.append('<div class="grid-sizer"></div>');
            }
            $crGrid.isotope({
                isResizeBound: false,
                percentPosition: true,
                itemSelector: $itemSelector,
                layoutMode: $layoutMode, //fitRows
                masonry: {
                    // use outer width of grid-sizer for columnWidth
                    columnWidth: '.grid-sizer',
                },
            });
            var $tw_iso_conts = $(window).data('tw_iso_conts') || [];
            $tw_iso_conts.push($crGrid);
            $(window).data('tw_iso_conts', $tw_iso_conts);
        }
    });
    // Filter
    $('.tw-filter-container').each(function () {
        var $crCont = $(this);
        var $crFltr = $('.tw-filter-list', $crCont);
        var $crFltrType = $crCont.data('filter');
        var $itemSelector = $crCont.data('item-selector')
            ? $crCont.data('item-selector')
            : '.uk-grid>*';
        // bind filter button click
        if ($('li.is-checked', $crFltr).length === 0) {
            $('li', $crFltr).first().addClass('is-checked');
        }
        $('li', $crFltr).on('click', function () {
            var $crBtn = $(this);
            var $crFltrVal = $('span', $crBtn).data('filter');
            var $crFltrChkd = $('.is-checked', $crFltr);
            if ($crFltrType === 'multi') {
                if ($crFltrVal === '*') {
                    $crFltrChkd.removeClass('is-checked');
                    $crBtn.addClass('is-checked');
                } else {
                    $('[data-filter="*"]', $crFltr)
                        .closest('li')
                        .removeClass('is-checked');
                    $crBtn.toggleClass('is-checked');
                }
            } else {
                if ($crBtn.is('.is-checked')) {
                    return false;
                }
                $crFltrChkd.removeClass('is-checked');
                $crBtn.addClass('is-checked');
            }
            $crFltrVal = '';
            $('.is-checked [data-filter]', $crFltr).each(function (i) {
                $crFltrVal += (i ? ',' : '') + $(this).data('filter');
            });
            if ($crFltrVal === '') {
                $crFltrVal = '*';
                $('[data-filter="*"]', $crFltr)
                    .closest('li')
                    .addClass('is-checked')
                    .siblings('li')
                    .removeClass('is-checked');
            }
            if ($crCont.is('.tw-isotope-container')) {
                $('.isotope-container', $crCont).isotope({
                    filter: $crFltrVal,
                });
                $($itemSelector, $crCont).each(function () {
                    var $SSFixer = $(this);
                    if ($SSFixer.hasClass('uk-scrollspy-inview')) {
                        $SSFixer.addClass('tw-scrollspy-fixer');
                    }
                });
            } else if (
                $crCont.is('.tw-justified-gallery-container') &&
                $().justifiedGallery !== undefined &&
                $().justifiedGallery !== 'undefined'
            ) {
                $('.tw-justified-gallery', $crCont).justifiedGallery({
                    filter: $crFltrVal,
                });
            }
        });
    });
    //Bg Video
    $('.tw-owl-carousel-container .tw-background-video').addClass(
        'tw-owl-bg-video'
    );
    tw_bg_video('.tw-background-video:not(.tw-owl-bg-video)');

    /* Video Modal Autoplay */
    $('.tw-video').each(function () {
        var $crVideo = $(this);
        var $crVideoBtn = $('.tw-video-icon', $crVideo);
        var $crTarget = $crVideo.data('video-target')
            ? $($crVideo.data('video-target'), $crVideo)
            : false;
        if ($crTarget && $crTarget.length) {
            $crVideoBtn.on('click', function () {
                if ($crVideo.hasClass('with-modal')) {
                    UIkit.modal($crTarget, { center: true }).show();
                } else {
                    $crTarget.siblings().addClass('tw-invis');
                }
                /* -------------- */
                $crTarget.removeClass('tw-invis').trigger('show');
            });
            var $crFrm = $('.tw-video-frame', $crTarget);
            if ($crFrm.length) {
                var $crEmbed = decodeURIComponent($crFrm.data('video-embed'));
                $crTarget.on('show', function () {
                    $crFrm.html($crEmbed);
                    setTimeout(function () {
                        tw_if_res($('iframe', $crFrm));
                    }, 1000);
                });
                $crTarget.on('hide', function () {
                    $crFrm.html('');
                });
            }
        }
    });
    /* Mobile Menu Animation */
    $('#mobile-menu-modal').each(function () {
        var $crMobMod = $(this);
        $('ul.uk-nav', $crMobMod).on('show hide', function (e) {
            e.preventDefault();
            return false;
        });
        tw_anim_data_con($('[data-uk-scrollspy],[uk-scrollspy]', $crMobMod));
        $crMobMod.on('show', function () {
            tw_in($('[data-uk-scrollspy],[uk-scrollspy]', $crMobMod));
        });
        $crMobMod.on('hide', function () {
            tw_out($('[data-uk-scrollspy],[uk-scrollspy]', $crMobMod));
        });
        $('a', $crMobMod).on('click', function () {
            if (
                $(this).attr('href') &&
                $(this).attr('href') !== '#' &&
                $(this).attr('href').indexOf('#') !== -1
            ) {
                $('#mobile-menu-modal .uk-close').trigger('click');
            }
        });
    });
    /* Init */
    $(window).trigger('tw-init');
    /* Resize */
    var $twResIntStep = 100;
    var $twRes = $twResIntStep;
    $(window).resize(function () {
        $twRes = 1000;
    });
    setInterval(function () {
        if ($twRes !== 'no-resize') {
            $twRes -= $twResIntStep;
            if ($twRes <= 0) {
                $twRes = 'no-resize';
                $(window).trigger('tw-resize');
            }
        }
    }, $twResIntStep);
    $(window).trigger('tw-resize');
    /* Scroll */
    $(window).scroll();
});
jQuery(window).on('tw-init', function () {
    'use strict';
    var $ = jQuery;
    
    // Blog hover
    $('.tw-blog .blog-inside-hover:not(.blog-inside-noexcerpt)').each(
        function () {
            var $cArt = $(this);
            if ($cArt.data('tw-blog-overlay-hover') !== 'true') {
                $cArt.data('tw-blog-overlay-hover', 'true');
                $('>.article-inner', $cArt).on({
                    mouseenter: function () {
                        var $height =
                            $(
                                '.entry-content p:not(.more-link)',
                                this
                            ).height() + 20;
                        $('.entry-title, .entry-date, .entry-cats', this).css(
                            'top',
                            -$height
                        );
                    },
                    mouseleave: function () {
                        $('.entry-title, .entry-date, .entry-cats', this).css(
                            'top',
                            0
                        );
                    },
                });
            }
        }
    );
    
    //Infinite
    setTimeout(function(){
        $('.tw-infinite-container').each(function (i) {
            var $cr = $(this);
            var $crSlctr = $cr.data('item-selector');
            var $crArticles = $cr.find($crSlctr);
            if ($crSlctr && $crArticles.length) {
                var $crInfinite = $cr.children('.tw-infinite-scroll');
                if ( $crInfinite.length && $crInfinite.data( 'tw-infinite' ) !== 'true' ) {
                    $crInfinite.data( 'tw-infinite', 'true' );
                    var $crNextLink = $crInfinite.find('a.next');
                    if ($crNextLink.length) {
                        $crNextLink.off('click').on('click', function (e) {
                            e.preventDefault();
                            if ($crInfinite.attr('data-has-next') === 'true') {
                                var $infiniteURL = $crNextLink.attr('href');
                                $crInfinite.addClass('waiting');
                                $.ajax({
                                    type: 'GET',
                                    url: $infiniteURL,
                                    success: function (response) {
                                        $crArticles = $cr.find($crSlctr);
                                        var $newInfCont = $(response)
                                            .find('.tw-infinite-container')
                                            .eq(i);
                                        var $newURL = $newInfCont.find(
                                            '.tw-infinite-scroll a.next'
                                        ).length
                                            ? $newInfCont
                                                .find(
                                                    '.tw-infinite-scroll a.next'
                                                )
                                                .attr('href')
                                            : false;
                                        var $hasNext = $newInfCont
                                            .find('.tw-infinite-scroll')
                                            .attr('data-has-next');
                                        var $newArticles =
                                            $newInfCont.find($crSlctr);
                                        if (
                                            $crArticles.length &&
                                            $newArticles.length
                                        ) {
                                            $crArticles.last().after($newArticles);
                                            if (
                                                $hasNext === 'false' ||
                                                $newURL === false
                                            ) {
                                                $crInfinite.attr(
                                                    'data-has-next',
                                                    'false'
                                                );
                                            } else {
                                                $crNextLink.attr('href', $newURL);
                                            }
                                            /* Relayout */
                                            var $infIntCnt = 3;
                                            var $infIntTimeout = 1500;
                                            var $crIsotopeContainer = $(
                                                '.isotope-container',
                                                $cr
                                            );
                                            if ($crIsotopeContainer.length) {
                                                if (
                                                    $crIsotopeContainer.find('img')
                                                        .length
                                                ) {
                                                    $infIntCnt = 1;
                                                    $infIntTimeout = 5000;
                                                    $crIsotopeContainer
                                                        .find('img')
                                                        .off('load')
                                                        .on('load', function () {
                                                            $(window).trigger(
                                                                'tw-init'
                                                            );
                                                            $(window).trigger(
                                                                'tw-resize'
                                                            );
                                                        });
                                                }
                                                var $infInt = setInterval(
                                                    function () {
                                                        if ($infIntCnt-- < 0) {
                                                            clearInterval($infInt);
                                                        }
                                                        $(window).trigger(
                                                            'tw-init'
                                                        );
                                                        $(window).trigger(
                                                            'tw-resize'
                                                        );
                                                    },
                                                    $infIntTimeout
                                                );
                                            } else {
                                                $(window).trigger('tw-init');
                                                $(window).trigger('tw-resize');
                                            }
                                        } else {
                                            $crInfinite.attr(
                                                'data-has-next',
                                                'false'
                                            );
                                        }
                                        $crInfinite.removeClass('waiting');
                                    },
                                }).fail(function () {
                                    $crInfinite.removeClass('waiting');
                                    $crInfinite.attr('data-has-next', 'false');
                                });
                            }
                        });
                        if ( $crInfinite.hasClass('infinite-auto') && $crNextLink.length ) {
                            $(window).scroll(function () {
                                var $infAutOffset = $crInfinite.data( 'infinite-auto-offset' )? parseInt( $crInfinite.data('infinite-auto-offset'), 10 ) * -1 : 0;
                                var $lnkAllH = $crNextLink.offset().top + $crNextLink.height();
                                var $wndAllH = $(window).scrollTop() + $(window).height() + $infAutOffset;
                                if ( !$crInfinite.hasClass('waiting') && $lnkAllH < $wndAllH ) {
                                    if ($cr.css('display') !== 'none') {
                                        $crNextLink.trigger('click');
                                    }
                                }
                            });
                        }
                    }
                }
            }
        });
    }, 2000)
    
});

jQuery(window).on('tw-resize', function () {
    'use strict';
    var $ = jQuery;
    
    /* iMap */
    $('.tw-filter-container').each(function(){
        var $crCont   = $( this );
        var $crHeader = $( '>.tw-filter-header', $crCont );
        var $crBody   = $( '>.tw-filter-body', $crCont );
        if ( $crHeader.length && $crBody.length ) {
            $crBody.height( $crCont.outerHeight() - $crHeader.outerHeight() );
        }
    });

    /* Organization Menu */
    $('.tw-org-menu-parent-container').each(function(){
        var $orgMenuCont = $( this );
        var $orgMenu = $( '>.organization-menu', $orgMenuCont );
        var $orgMenuContOL   = $orgMenuCont.offset().left;
        if ( $orgMenu.length ) {
            $orgMenu.css( { left: '-' + $orgMenuContOL + 'px', width: $('body').width() } )
        }
    })

    /* Main Menu - Submenu responsive */
    $('.tw-main-menu>.menu-item').each(function () {
        var $crMenuItem = $(this).removeClass('sub-rev');
        var $crMenuItemLeft = $crMenuItem.offset().left;
        var $crSubMenus = $crMenuItem.find('.sub-menu');
        var $windowWidth = $(window).width();
        var $crSubMenuMaxWidth = 0;
        if ($crMenuItemLeft && $crSubMenus.length) {
            $crSubMenus.css({
                opacity: 0,
                visibility: 'hidden',
                display: 'block',
            });
            $crSubMenus
                .each(function () {
                    var $crSubMenu = $(this);
                    var $crSubMenuAllWidth =
                        $crSubMenu.offset().left + $crSubMenu.outerWidth();
                    if ($crSubMenuMaxWidth < $crSubMenuAllWidth) {
                        $crSubMenuMaxWidth = $crSubMenuAllWidth;
                    }
                })
                .promise()
                .done(function () {
                    $crSubMenus.css({
                        opacity: '',
                        visibility: '',
                        display: '',
                    });
                    if ($windowWidth < $crSubMenuMaxWidth) {
                        $crMenuItem.addClass('sub-rev');
                    }
                });
        }
    });
    /* Sidebar Menu */
    $('.tw-header-sidebar .sub-menu').each(function () {
        var $crSub = $(this).css({
            opacity: '0',
            display: 'block',
            marginTop: 0,
        });
        var $crSubH = $crSub.outerHeight();
        var $crSubChildH = 0;
        var $crSubHeight =
            $crSub.offset().top - $(window).scrollTop() + $crSubH;
        var $wH = $(window).height();
        var $mT = '';
        var $oF = 'visible';
        if ($crSubHeight > $wH) {
            $mT = $wH - $crSubHeight + 'px';
        }
        $crSub.children().each(function () {
            $crSubChildH += $(this).outerHeight();
        });
        if ($crSubH > 0 && $crSubChildH > 0 && $crSubH < $crSubChildH) {
            $oF = 'scroll';
        }
        $crSub.css({
            opacity: '',
            display: '',
            marginTop: $mT,
            overflowX: $oF,
        });
    });

    var $tw_iso_conts = $(window).data('tw_iso_conts') || [];
    setTimeout(function () {
        $tw_iso_conts.forEach(function ($crIsoCont) {
            var $crIsoContOuter = $crIsoCont.closest('.tw-isotope-container');
            var $crItemSelector =
                ($crIsoContOuter.data('item-selector')
                    ? $crIsoContOuter.data('item-selector')
                    : '.uk-grid>*') + ',>.grid-sizer';
            var $crItems = $($crItemSelector, $crIsoCont);
            var $crLayout = $crIsoContOuter.data('layout');
            $('.tw-filter-list li.hidden [data-filter]', $crIsoContOuter).each(
                function () {
                    if ($crItems.filter($(this).data('filter')).length) {
                        $(this).closest('li').removeClass('hidden');
                    }
                }
            );
            $($crItemSelector, $crIsoCont).each(function () {
                var $SSFixer = $(this);
                if ($SSFixer.hasClass('uk-scrollspy-inview')) {
                    $SSFixer.addClass('tw-scrollspy-fixer');
                }
            });
            if ($crLayout === 'metro') {
                var $metroHeight = $crIsoContOuter.data('metro-height')
                    ? Math.abs(
                          parseInt($crIsoContOuter.data('metro-height'), 10)
                      )
                    : false;
                var $crIsoContW = $crIsoCont.width();
                var $crIsoCol = tw_get_child_col($crIsoCont);
                var $crIsoColW =
                    parseInt($crIsoContW / $crIsoCol, 10) -
                    twItemORL($crItems.first());

                $crItems
                    .each(function () {
                        var $crIsIt = $(this);
                        var $crSize = $crIsIt.data('size');
                        var $crSizeW = 1;
                        var $crSizeH = 1;
                        var $crIsItW = $crIsoColW;
                        var $crIsItH = $crIsItW;
                        if ($metroHeight) {
                            var $winH = $(window).height();
                            if ($('#wpadminbar').length) {
                                $winH -= $('#wpadminbar').height();
                            }
                            $crIsItH = Math.ceil(
                                ($winH / $crIsoCol / 100) * $metroHeight -
                                    twItemOTB($crIsIt)
                            );
                        }

                        $crIsIt.css('height', '');

                        switch ($crSize) {
                            case 'vertical':
                                $crSizeH = 2;
                                break;
                            case 'horizontal':
                                $crSizeW = 2;
                                break;
                            case 'large':
                                $crSizeW = $crSizeH = 2;
                                break;
                            case 'full':
                                $crSizeW = $crSizeH = $crIsoCol;
                                break;
                        }
                        $crIsItW =
                            $crIsItW * $crSizeW +
                            twItemORL($crIsIt) * ($crSizeW - 1);
                        $crIsItH =
                            $crIsItH * $crSizeH +
                            twItemOTB($crIsIt) * ($crSizeH - 1);
                        $crIsIt.css('width', $crIsItW + 'px');
                        $crIsIt.css('height', $crIsItH + 'px');

                        if ($('>.article-inner', $crIsIt).length) {
                            $('>.article-inner', $crIsIt).css(
                                'height',
                                $crIsItH + 'px'
                            );
                        }
                        var $crIm = $('.portfolio-media>img', $crIsIt);
                        if ($crIm.length) {
                            $crIm.css({
                                maxWidth: '',
                                width: '',
                                height: '',
                                left: '',
                                top: '',
                            });
                            $crIsItW = $crIsIt.width();
                            $crIsItH = $crIsIt.height();
                            var $crImW = $crIm.width();
                            var $crImH = $crIm.height();
                            var $crImD = $crImH / $crImW;
                            var $top = 0;
                            var $left = 0;
                            if ($crIsItH < $crImH) {
                                $top = ($crIsItH - $crImH) / 2;
                            } else if ($crIsItH > $crImH) {
                                $crImW = $crIsItH / $crImD;
                                $crIm.css({
                                    maxWidth: $crImW + 'px',
                                    width: $crImW + 'px',
                                });
                                $left = ($crIsItW - $crImW) / 2;
                            }
                            $crIm.css({
                                marginTop: $top + 'px',
                                marginLeft: $left + 'px',
                            });
                        }
                    })
                    .promise()
                    .done(function () {
                        $crIsoCont
                            .isotope('reloadItems')
                            .isotope({ sortBy: 'original-order' });
                    });
            } else {
                $crIsoCont
                    .isotope('reloadItems')
                    .isotope({ sortBy: 'original-order' });
            }
        });
    }, 100);
    /* Filter Init */
    $('.tw-filter-container').each(function () {
        var $crCont = $(this);
        var $crFltr = $('.tw-filter-list', $crCont);
        var $crItemSelector = $crCont.data('item-selector')
            ? $crCont.data('item-selector')
            : '.uk-grid>*';
        var $crItems = $($crItemSelector, $crCont);
        $('li.hidden [data-filter]', $crFltr).each(function () {
            if ($crItems.filter($(this).data('filter')).length) {
                $(this).closest('li').removeClass('hidden');
            }
        });
    });
    /* Modal Video Responsive */
    tw_if_res('#modal-close iframe,.tw-video-container iframe');
    /* Dimension */
    $('[data-tw-dimension-type]').each(function () {
        var $crDim = $(this);
        var $crDimType = $crDim.data('tw-dimension-type');
        var $crDimH = $(window).height();
        if ($crDimType === 'custom-min-height') {
            if ($crDim.hasClass('tw-slider')) {
                $crDimH = parseInt($crDim.data('tw-dimension-height'), 10);
                if ($crDimH) {
                    $('.owl-item>.tw-row-inner', $crDim).css(
                        'min-height',
                        $crDimH + 'px'
                    );
                }
            }
        } else {
            var $headerNotTrnsfrnt = $(
                '.tw-header:not(.tw-header-transparent):not(.tw-header-sidebar)'
            );
            if ($crDimType === 'fullscreen-offset') {
                $headerNotTrnsfrnt.each(function () {
                    $crDimH -= $(this).outerHeight();
                });
            }

            if ($('#wpadminbar').length) {
                $crDimH -= $('#wpadminbar').height();
            }
            $crDim.css({
                'min-height': $crDimH + 'px',
                height: $crDimH + 'px',
            });

            $crDim.closest('.uk-section,.tw-section').css('padding', 0);
            $crDim
                .closest('.uk-container')
                .css({
                    padding: 0,
                    width: '100%',
                    maxWidth: '100%',
                    minWidth: '100%',
                });
        }
        /* -------------- */
        if (!$crDim.hasClass('tw-slider')) {
            $crDim.css('height', '');
            $crDim.css('height', $crDim.height() + 'px');
        }
    });
});

function tw_if_res($ifS) {
    'use strict';
    var $ = jQuery;
    $($ifS).each(function () {
        var $cr = $(this);
        $cr.css('height', '');
        var $aW = parseInt($cr.attr('width'), 10);
        var $aH = parseInt($cr.attr('height'), 10);
        var $aD = $aW / $aH;
        var $w = $cr.width();
        $cr.height($w / $aD);
    });
}
function tw_get_child_col($cr, $colPtrn) {
    'use strict';
    if (!$colPtrn) {
        $colPtrn = 'uk-child-width-1-';
    }
    var $crClasses = $cr.attr('class').split(' ');
    var $crClsWs = [];
    var $crSize = 'default';
    var $col = 1;
    var $sizes = {
        xxs: '(max-width: 380px)',
        xs: '(max-width: 639px)',
        s: '(min-width: 640px)',
        m: '(min-width: 960px)',
        l: '(min-width: 1200px)',
        xl: '(min-width: 1600px)',
    };
    for (var i = 0; i < $crClasses.length; i++) {
        if ($crClasses[i].search($colPtrn) > -1) {
            var $crClsW = $crClasses[i].split('@');
            $crClsWs[$crClsW.length > 1 ? $crClsW[1] : 'default'] = $crClsW[0];
        }
    }
    for (var size in $sizes) {
        if (
            window.matchMedia($sizes[size]).matches &&
            $crClsWs.hasOwnProperty(size)
        ) {
            $crSize = size;
        }
    }
    if (Object.keys($crClsWs).length) {
        if ($crClsWs.hasOwnProperty($crSize)) {
            $col = parseInt($crClsWs[$crSize].replace($colPtrn, ''), 10);
        }
    }
    return $col;
}
jQuery(window).scroll(function () {
    'use strict';
    var $ = jQuery;

    setTimeout( function(){
        if ( $('.em-calendar .uk-drop.uk-open') . length ) {
            $('.em-calendar .uk-drop.uk-open').trigger('tw-drop-pos-check');
        }
    }, 500 )

    $('[id]:not(.wc-tab):not(.uk-switcher)').each(function () {
        var $cElm = $(this);
        var $cID = $cElm.attr('id');
        var $cElmTop = $cElm.offset().top;
        var $wndTop = $(window).scrollTop();
        var $round = 100;
        if ($cID) {
            var $cA = $('a[href$="#' + $cID + '"]');
            if (
                $cA.length &&
                $wndTop - $round < $cElmTop &&
                $wndTop + $round > $cElmTop
            ) {
                if ($cA.parent('li').length) {
                    $cA.parent('li').addClass('uk-active');
                    if ($cA.parent('li').parents('li').length) {
                        $cA.parent('li').parents('li').addClass('uk-active');
                    }
                }
            } else {
                if ($cA.parent('li').length) {
                    $cA.parent('li').removeClass('uk-active');
                    if ($cA.parent('li').parents('li').length) {
                        $cA.parent('li').parents('li').removeClass('uk-active');
                    }
                }
            }
        }
    });
});
function tw_anim_init($items) {
    'use strict';
    var $ = jQuery;
    $($items).each(function () {
        var $sAc = $(this);
        var $sAcAnim = $sAc.data('anim');
        var $sAcAnimTarget = $sAcAnim ? $($sAcAnim, $sAc) : false;
        var $sAcAnimIn = $sAc.data('anim-in');
        if ($sAcAnimTarget && $sAcAnimTarget.length && $sAcAnimIn) {
            $sAcAnimTarget.addClass('tw-outview');
        }
    });
}
function tw_out($outs) {
    'use strict';
    var $ = jQuery;
    $outs.each(function () {
        var $sAc = $(this);
        var $sAcAnim = $sAc.data('anim-out-target')
            ? $sAc.data('anim-out-target')
            : $sAc.data('anim');
        var $sAcAnimTarget = $sAcAnim ? $($sAcAnim, $sAc) : $sAc;
        var $sAcAnimOut = $sAc.data('anim-out')
            ? $sAc.data('anim-out')
            : 'tw-anim-hide';
        var $sAcAnimDelay = $sAc.data('anim-delay')
            ? parseInt($sAc.data('anim-delay'), 10)
            : 0;
        if ($sAcAnimTarget.length && $sAcAnimOut) {
            $sAcAnimTarget.each(function (i) {
                var $delAnim = $(this)
                    .removeClass($sAcAnimOut)
                    .removeClass('tw-outview')
                    .css({ opacity: '', visibility: '' });
                setTimeout(function () {
                    if (!$delAnim.hasClass('active')) {
                        $delAnim.addClass($sAcAnimOut);
                        setTimeout(function () {
                            $delAnim.removeClass($sAcAnimOut);
                            if (!$delAnim.hasClass('tw-owl-item-in-view')) {
                                $delAnim.addClass('tw-outview');
                            }
                        }, 500);
                    }
                }, i * $sAcAnimDelay);
            });
        }
    });
}
function tw_in($ins) {
    'use strict';
    var $ = jQuery;
    $ins.each(function (j) {
        var $sAc = $(this);
        var $sAcAnim = $sAc.data('anim');
        var $sAcAnimTarget = $sAcAnim ? $($sAcAnim, $sAc) : $sAc;
        var $sAcAnimIn = $sAc.data('anim-in');
        var $sAcAnimDelay = $sAc.data('anim-delay')
            ? parseInt($sAc.data('anim-delay'), 10)
            : 0;
        if ($sAcAnimTarget.length && $sAcAnimIn) {
            $sAcAnimTarget.addClass('tw-outview');
            setTimeout(function () {
                $sAcAnimTarget.each(function (i) {
                    var $delAnim = $(this).removeClass($sAcAnimIn);
                    setTimeout(function () {
                        $delAnim
                            .removeClass('tw-outview')
                            .addClass($sAcAnimIn)
                            .css({ opacity: '', visibility: '' });
                        if ($delAnim[0]._scrollspy) {
                            $delAnim[0]._scrollspy.inview = true;
                        }
                        var $cntrUpAnim = $delAnim.filter('.tw-counterup')
                            .length
                            ? $delAnim.filter('.tw-counterup')
                            : $('.tw-counterup', $delAnim);
                        $cntrUpAnim.each(function () {
                            var $crCntrUpCont = $(this);
                            var $crSlctr = $crCntrUpCont.data('slctr')
                                ? $crCntrUpCont.data('slctr')
                                : 'h1';
                            var $crCntrUp = $($crSlctr, $crCntrUpCont);
                            if ($crCntrUp.length) {
                                $crCntrUp.trigger('tw-animate');
                            }
                        });
                        setTimeout(function () {
                            $delAnim.removeClass($sAcAnimIn);
                        }, tw_css_time_to_milliseconds(
                            $delAnim.css('animation-duration')
                        ));
                    }, (i + 1) * $sAcAnimDelay);
                });
            }, (j + 1) * $sAcAnimDelay);
        }
    });
}
function tw_css_time_to_milliseconds($css) {
    'use strict';
    return parseFloat($css, 10) * (/\ds$/.test($css) ? 1000 : 1);
}
function tw_data_parse($data) {
    'use strict';
    var $newData = [];
    if ($data) {
        $data.split(';').forEach(function ($item) {
            $item = $item.trim();
            if ($item) {
                $item = $item.split(':');
                $newData[$item[0].trim()] = $item[1].trim();
            }
        });
    }
    return $newData;
}
function tw_anim_data_con($els, $preIn, $preOut) {
    'use strict';
    var $ = jQuery;
    var $datas = [];
    $els.each(function () {
        var $el = $(this);
        var $elData = $el.data('uk-scrollspy')
            ? $el.data('uk-scrollspy')
            : $el.attr('uk-scrollspy')
            ? $el.attr('uk-scrollspy')
            : false;
        if ($elData) {
            $elData = tw_data_parse($elData);
            $datas.push($elData);
            /* use attr : if owl-loop=true clone is cleared data */
            if ($elData.target || $preIn) {
                $el.attr(
                    'data-anim',
                    ($preIn ? $preIn : '') +
                        ($elData.target ? $elData.target : '')
                );
            }
            if ($elData.target || $preOut) {
                $el.attr(
                    'data-anim-out-target',
                    ($preOut ? $preOut : '') +
                        ($elData.target ? $elData.target : '')
                );
            }
            if ($elData.cls) {
                $el.attr('data-anim-in', $elData.cls);
            }
            if ($elData.delay) {
                $el.attr('data-anim-delay', $elData.delay);
            }
        }
    });
    return $datas;
}
function tw_bg_video($els) {
    'use strict';
    var $ = jQuery;
    /* Video Background */
    $($els).each(function (i) {
        var $crBgVid = $(this);
        var $crEmbed = $('<div />')
            .html($crBgVid.data('video-embed'))
            .find('iframe');
        $crBgVid.html($crEmbed);
    });
}
/* Item Top Bottom Height */
/* ------------------------------------------------------------------- */
function twItemOTB($item) {
    'use strict';
    var $ = jQuery;
    $item = $($item).first();
    var $itemMarginTB =
        parseInt($item.css('margin-top').replace('px', ''), 10) +
        parseInt($item.css('margin-bottom').replace('px', ''), 10);
    var $itemBorderTB =
        parseInt($item.css('border-top-width').replace('px', ''), 10) +
        parseInt($item.css('border-bottom-width').replace('px', ''), 10);
    var $itemTB = $itemMarginTB + $itemBorderTB;
    return $itemTB;
}
function twItemTB($item) {
    'use strict';
    var $ = jQuery;
    $item = $($item).first();
    var $itemPaddingTB =
        parseInt($item.css('padding-top').replace('px', ''), 10) +
        parseInt($item.css('padding-bottom').replace('px', ''), 10);
    var $itemTB = $itemPaddingTB + twItemOTB($item);
    return $itemTB;
}
/* Item Right Left Width */
/* ------------------------------------------------------------------- */
function twItemORL($item) {
    'use strict';
    var $ = jQuery;
    $item = $($item).first();
    var $itemMarginRL =
        parseInt($item.css('margin-left').replace('px', ''), 10) +
        parseInt($item.css('margin-right').replace('px', ''), 10);
    var $itemBorderRL =
        parseInt($item.css('border-left-width').replace('px', ''), 10) +
        parseInt($item.css('border-right-width').replace('px', ''), 10);
    var $itemRL = $itemMarginRL + $itemBorderRL;
    return $itemRL;
}
function twItemRL($item) {
    'use strict';
    var $ = jQuery;
    $item = $($item).first();
    var $itemPaddingRL =
        parseInt($item.css('padding-left').replace('px', ''), 10) +
        parseInt($item.css('padding-right').replace('px', ''), 10);
    var $itemRL = $itemPaddingRL + twItemORL($item);
    return $itemRL;
}
