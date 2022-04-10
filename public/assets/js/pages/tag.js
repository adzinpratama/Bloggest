
'use strict';

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    });

    var composeModal = $('#compose-mail'),
        menuToggle = $('.menu-toggle'),
        sidebarToggle = $('.sidebar-toggle'),
        sidebarLeft = $('.sidebar-left'),
        sidebarMenuList = $('.sidebar-menu-list'),
        tagList = $('.tags-list'),
        tagListInput = $('.tag-user-list .custom-checkbox'),
        tagScroollArea = $('.tag-scroll-area'),
        listGroupMsg = $('.list-group-messages'),
        tagSearch = $('#tag-search'),
        overlay = $('.body-content-overlay'),
        isRtl = $('html').attr('data-textdirection') === 'rtl';

    let listWraper = $('#tag-list'),
        newTaskModal = $('.sidebar-tag-modal'),
        addBtn = $('.add-tag-item'),
        changeBtn = $('.change-btn'),
        modalTitle = $('.modal-title'),
        formModal = $('#form-modal-tag'),
        tagBtn = $('.tag-btn button'),
        inputSlug = $('#tag_slug'),
        inputTitle = $('#tag_title'),
        areaInput = $('.area-input'),
        btnSave = $('#tag-btn-save'),
        btnUpdate = $('#tag-btn-update'),
        btnDelete = $('#tag-btn-delete'),
        btnConfirm = $('#btn-confirm'),
        searchBox = $('#tag-search');

    if ($('body').attr('data-framework') === 'laravel') {
        assetPath = $('body').attr('data-asset-path');
    }
    getTag();
    // listWraper.load(route('tags.index'))

    // if it is not touch device
    if (!$.app.menu.is_touch_device()) {
        // Email left Sidebar
        if ($(sidebarMenuList).length > 0) {
            var sidebar_menu_list = new PerfectScrollbar(sidebarMenuList[0]);
        }

        // User list scroll
        if ($(tagList).length > 0) {
            var users_list = new PerfectScrollbar(tagList[0]);
        }

        // Email detail section
        if ($(tagScroollArea).length > 0) {
            var users_list = new PerfectScrollbar(tagScroollArea[0]);
        }
    }
    // if it is a touch device
    else {
        $(sidebarMenuList).css('overflow', 'scroll');
        $(tagList).css('overflow', 'scroll');
        $(tagScroollArea).css('overflow', 'scroll');
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



    // Add class active on click of sidebar list
    if (listGroupMsg.find('a').length) {
        listGroupMsg.find('a').on('click', function () {
            if (listGroupMsg.find('a').hasClass('active')) {
                listGroupMsg.find('a').removeClass('active');
            }
            $(this).addClass('active');
        });
    }


    // For app sidebar on small screen
    if ($(window).width() > 768) {
        if (overlay.hasClass('show')) {
            overlay.removeClass('show');
        }
    }
    //single select list
    $(document).on('click', '#tag-list li .media-body', function () {
        let t = $(this);
        areaInput.removeClass('is-invalid');
        inputTitle.val(t.data('title'));
        inputSlug.val(t.data('slug'));
        changeBtn.data('id', t.data('id'));
        changeBtn.removeClass('d-none');
        addBtn.addClass('d-none');
        $('#new-tag-modal').modal('show');
    })
    // single checkbox select
    if (tagListInput.length) {
        tagListInput.on('click', function (e) {
            e.stopPropagation();
        });
        tagListInput.find('input').on('change', function (e) {
            e.stopPropagation();
            var $this = $(this);
            if ($this.is(':checked')) {
                $this.closest('.media').addClass('selected-row-bg');
            } else {
                $this.closest('.media').removeClass('selected-row-bg');
            }
        });
    }

    $(document).on('change', '.tag-app-list .selectSingle input', function () {
        if ($(this).is(':checked')) {
            $(this).closest('.media').addClass('selected-row-bg');
            // $('.tag-app-list .selectAll input').prop('checked', this.checked)
        } else {
            $(this).closest('.media').removeClass('selected-row-bg');
            $('.tag-app-list .selectAll input').prop('checked', this.checked)
        }
    })


    // select all
    $(document).on('click', '.tag-app-list .selectAll input', function () {
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
    $(document).on('click', '.tag-delete', () => {
        $(document).find('.tag-app-list .selectAll input').prop('checked', false);
        let checkboxId = []
        $(document).find('.custom-checkbox input:checked').each(function (val) {
            checkboxId.push($(this).data('id'));
        })
        $(document).find('.custom-checkbox input').prop('checked', '');
        if (checkboxId.length == 0) {
            return notif('error', 'Belum Ada Data Yang Terpilih');
        }
        return destroy(checkboxId);
    })

    // Filter
    if (tagSearch.length) {
        tagSearch.on('keyup', delay(function () {
            return getTag()
        }, 500));
    }

    function delay(fn, ms) {
        let timer = 0
        return function (...args) {
            clearTimeout(timer)
            timer = setTimeout(fn.bind(this, ...args), ms || 0)
        }
    }


    // On navbar search and bookmark Icon click, hide compose mail
    $('.nav-link-search, .bookmark-star').on('click', function () {
        composeModal.modal('hide');
    });



    const overlays = () => {
        sidebarLeft.removeClass('show');
        overlay.removeClass('show');
        $(newTaskModal).modal('hide');
    }
    overlays();
    //shortcut new Tag
    document.onkeyup = function (e) {
        if (e.ctrlKey && e.altKey && e.which == 78) {
            tagBtn.click();
        } else if (e.which == 191) {
            document.getElementById('tag-search').focus();
        }
    };

    inputTitle.keyup((e) => {
        return inputSlug.val(generateSlug(inputTitle.val()));
    })

    tagBtn.on('click', function () {
        // e.preventDefault();
        addBtn.removeClass('d-none');
        changeBtn.addClass('d-none');
        modalTitle.text('Add Tag');
        return clearForm();
    })
    btnSave.click((e) => {
        e.preventDefault();
        return action(route('tags.store'), 'post');
    })

    btnUpdate.click((e) => {
        e.preventDefault();
        let id = changeBtn.data('id');
        return action(route('tags.update', { id }), 'put');
    })

    btnDelete.click((e) => {
        e.preventDefault();
        let id = changeBtn.data('id');
        return destroy(id);
    })

    const destroy = (id) => {
        Swal.fire({
            title: btnConfirm.data('title'),
            text: btnConfirm.data('text'),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: btnConfirm.data('accept'),
            cancelButtonText: btnConfirm.data('reject'),
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-outline-danger ml-1'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.value) {
                return send(route('tags.destroy', { id }), { method: 'delete' });
            }
        });
    }

    $(document).on('click', '#link a', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        return getTag(url);
    })

    const action = (route, method) => {
        areaInput.removeClass('is-invalid');
        let data = formModal.serialize();
        return send(route, { method, data });
    }
    const send = (route, option) => {
        let beforeSend = { beforeSend: () => { return loader() } };
        // let push = { ...option, ...beforeSend };
        let push = Object.assign(beforeSend, option);
        // $(document).ajaxStart(() => { return loader() });
        return $.ajax(route, push).then(res => {
            if (res.status) {
                notif(res.status, res.message);
                overlays();
                return getTag();
            }
        }).catch(({ responseJSON: e }) => {
            if (typeof (e) == 'object') {
                $.each(e, (key, value) => {
                    $('#tag_' + key).addClass('is-invalid');
                    $('#valid-' + key).text(value);
                })
            }
            if (e.message) notif('error', e.message);
        })
    }

    const clearForm = () => {
        // document.getElementById('tag_title').focus();
        areaInput.val('');
        areaInput.removeClass('is-invalid');
    }

    const generateSlug = (value) => {
        return value.trim()
            .toLowerCase()
            .replace(/[^a-z\d-]/gi, '-')
            .replace(/-+/g, '-').replace(/^-|-$/g, "");
    }
    const notif = (type, message) => {
        return toastr[type](message, {
            closeButton: true,
            tapToDismiss: false,
            rtl: isRtl
        });
    }

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

    function getTag(url = route('tags.index')) {

        $.get(url, {
            beforeSend: () => { loader('list') },
            search: searchBox.val()
        }).then(res => {
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

$('#new-tag-modal').on('shown.bs.modal', function () {
    document.getElementById('tag_title').focus();
})
