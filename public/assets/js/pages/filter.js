/*=========================================================================================
    File Name: app-email.js
    Description: Email Page js
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

'use strict';

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    });
    // Register Quill Fonts
    var Font = Quill.import('formats/font');
    Font.whitelist = ['sofia', 'slabo', 'roboto', 'inconsolata', 'ubuntu'];
    Quill.register(Font, true);

    var compose = $('.compose-email'),
        composeModal = $('#compose-mail'),
        menuToggle = $('.menu-toggle'),
        sidebarToggle = $('.sidebar-toggle'),
        sidebarLeft = $('.sidebar-left'),
        sidebarMenuList = $('.sidebar-menu-list'),
        emailAppList = $('.email-app-list'),
        emailUserList = $('.email-user-list'),
        emailUserListInput = $('.email-user-list .custom-checkbox'),
        emailScrollArea = $('.email-scroll-area'),
        emailTo = $('#email-to'),
        emailCC = $('#emailCC'),
        emailBCC = $('#emailBCC'),
        toggleCC = $('.toggle-cc'),
        toggleBCC = $('.toggle-bcc'),
        wrapperCC = $('.cc-wrapper'),
        wrapperBCC = $('.bcc-wrapper'),
        emailDetails = $('.email-app-details'),
        listGroupMsg = $('.list-group-messages'),
        goBack = $('.go-back'),
        favoriteStar = $('.email-application .email-favorite'),
        userActions = $('.user-action'),
        mailDelete = $('.mail-delete'),
        mailUnread = $('.mail-unread'),
        emailSearch = $('#email-search'),
        editorEl = $('#message-editor .editor'),
        overlay = $('.body-content-overlay'),
        isRtl = $('html').attr('data-textdirection') === 'rtl';
    let listWraper = $('#app-list'),
        searchBox = $('#app-search');


    if ($('body').attr('data-framework') === 'laravel') {
        assetPath = $('body').attr('data-asset-path');
    }


    // if it is not touch device
    if (!$.app.menu.is_touch_device()) {
        // Email left Sidebar
        if ($(sidebarMenuList).length > 0) {
            var sidebar_menu_list = new PerfectScrollbar(sidebarMenuList[0]);
        }

        // User list scroll
        if ($(emailUserList).length > 0) {
            var users_list = new PerfectScrollbar(emailUserList[0]);
        }

        // Email detail section
        if ($(emailScrollArea).length > 0) {
            var users_list = new PerfectScrollbar(emailScrollArea[0]);
        }
    }
    // if it is a touch device
    else {
        $(sidebarMenuList).css('overflow', 'scroll');
        $(emailUserList).css('overflow', 'scroll');
        $(emailScrollArea).css('overflow', 'scroll');
    }

    // compose email
    if (compose.length) {
        compose.on('click', function () {
            // showing rightSideBar
            overlay.removeClass('show');
            // hiding left sidebar
            sidebarLeft.removeClass('show');
            // all input forms
            $('.compose-form input').val('');
            emailTo.val([]).trigger('change');
            emailCC.val([]).trigger('change');
            emailBCC.val([]).trigger('change');
            wrapperCC.hide();
            wrapperBCC.hide();

            // quill editor content
            var quill_editor = $('.compose-form .ql-editor');
            quill_editor[0].innerHTML = '';
        });
    }

    // Main menu toggle should hide app menu
    if (menuToggle.length) {
        menuToggle.on('click', function (e) {
            sidebarLeft.removeClass('show');
            overlay.removeClass('show');
        });
    }

    // Email sidebar toggle
    if (sidebarToggle.length) {
        sidebarToggle.on('click', function (e) {
            e.stopPropagation();
            sidebarLeft.toggleClass('show');
            overlay.addClass('show');
        });
    }

    // Overlay Click
    if (overlay.length) {
        overlay.on('click', function (e) {
            sidebarLeft.removeClass('show');
            overlay.removeClass('show');
        });
    }

    // Email Right sidebar toggle
    if (emailUserList.find('li').length) {
        emailUserList.find('li').on('click', function (e) {
            emailDetails.toggleClass('show');
        });
    }

    // Add class active on click of sidebar list
    if (listGroupMsg.find('a').length) {
        listGroupMsg.find('a').on('click', function () {
            if (listGroupMsg.find('a').hasClass('active')) {
                listGroupMsg.find('a').removeClass('active');
            }
            $(this).addClass('active');
            loadData({ load: $(this).data('toggle') });
        });

    }

    // Email detail view back button click
    if (goBack.length) {
        goBack.on('click', function (e) {
            e.stopPropagation();
            emailDetails.removeClass('show');
        });
    }

    // Favorite star click
    if (favoriteStar.length) {
        favoriteStar.on('click', function (e) {
            $(this).find('svg').toggleClass('favorite');
            e.stopPropagation();
            // show toast only have favorite class
            if ($(this).find('svg').hasClass('favorite')) {
                toastr['success']('Updated mail to favorite', 'Favorite Mail ⭐️', {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: isRtl
                });
            }
        });
    }

    // For app sidebar on small screen
    if ($(window).width() > 768) {
        if (overlay.hasClass('show')) {
            overlay.removeClass('show');
        }
    }

    // single checkbox select
    if (emailUserListInput.length) {
        emailUserListInput.on('click', function (e) {
            e.stopPropagation();
        });
        emailUserListInput.find('input').on('change', function (e) {
            e.stopPropagation();
            var $this = $(this);
            if ($this.is(':checked')) {
                $this.closest('.media').addClass('selected-row-bg');
            } else {
                $this.closest('.media').removeClass('selected-row-bg');
            }
        });
    }

    // select all
    $(document).on('click', '.email-app-list .selectAll input', function () {
        if ($(this).is(':checked')) {
            $(document)
                .find('.custom-checkbox input')
                .prop('checked', this.checked)
                .closest('.media')
                .addClass('selected-row-bg');
        } else {
            $(document).find('.custom-checkbox input')
                .prop('checked', '')
                .closest('.media')
                .removeClass('selected-row-bg');
        }
    });

    // Delete selected Mail from list
    if (mailDelete.length) {
        mailDelete.on('click', function () {
            if (userActions.find('.custom-checkbox input:checked').length) {
                userActions.find('.custom-checkbox input:checked').closest('.media').remove();
                emailAppList.find('.selectAll input').prop('checked', false);
                toastr['error']('You have removed email.', 'Mail Deleted!', {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: isRtl
                });
                userActions.find('.custom-checkbox input').prop('checked', '');
            }
        });
    }

    // Mark mail unread
    if (mailUnread.length) {
        mailUnread.on('click', function () {
            userActions.find('.custom-checkbox input:checked').closest('.media').removeClass('mail-read');
        });
    }

    // Filter
    if (emailSearch.length) {
        emailSearch.on('keyup', function () {
            var value = $(this).val().toLowerCase();
            if (value !== '') {
                emailUserList.find('.email-media-list li').filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
                var tbl_row = emailUserList.find('.email-media-list li:visible').length;

                //Check if table has row or not
                if (tbl_row == 0) {
                    emailUserList.find('.no-results').addClass('show');
                    emailUserList.animate({ scrollTop: '0' }, 500);
                } else {
                    if (emailUserList.find('.no-results').hasClass('show')) {
                        emailUserList.find('.no-results').removeClass('show');
                    }
                }
            } else {
                // If filter box is empty
                emailUserList.find('.email-media-list li').show();
                if (emailUserList.find('.no-results').hasClass('show')) {
                    emailUserList.find('.no-results').removeClass('show');
                }
            }
        });
    }

    // Email compose Editor
    if (editorEl.length) {
        var emailEditor = new Quill(editorEl[0], {
            bounds: '#message-editor .editor',
            modules: {
                formula: true,
                syntax: true,
                toolbar: '.compose-editor-toolbar'
            },
            placeholder: 'Message',
            theme: 'snow'
        });
    }

    // On navbar search and bookmark Icon click, hide compose mail
    $('.nav-link-search, .bookmark-star').on('click', function () {
        composeModal.modal('hide');
    });

    function loader(type = '') {
        let option = {
            message:
                '<div class="spinner-border text-primary" role="status"></div>',
            css: {
                backgroundColor: 'transparent',
                color: '#fff',
                border: '0'
            },
            overlayCSS: {
                opacity: 0.5
            }
        };
        if (type == 'list') {
            return listWraper.block(option);
        } else {
            return $.blockUI(option);
        }
    }

    function loadData(param) {
        if (!param.url) param.url = route('filter.index')
        param.beforeSend = () => { loader('list') }
        param.search = searchBox.val();
        $.get(param.url, param).then(res => {
            return listWraper.html(res);
        })
        return $(document).ajaxComplete(() => { return $.unblockUI() })

        // return listWraper.load(route('tags.index'))
    }
});

$(window).on('resize', function () {
    var sidebarLeft = $('.sidebar-left');
    // remove show classes from sidebar and overlay if size is > 992
    if ($(window).width() > 768) {
        if ($('.app-content .body-content-overlay').hasClass('show')) {
            sidebarLeft.removeClass('show');
            $('.app-content .body-content-overlay').removeClass('show');
        }
    }
});
