$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').val()
    }
});
let addBtn = $('.add-category-item'),
    updateBtns = $('.update-btn'),
    modalTitle = $('.modal-title'),
    dataTitle = modalTitle.attr('data-title'),
    sidebarLeft = $('.sidebar-left'),
    overlay = $('.body-content-overlay'),
    newTaskModal = $('.sidebar-category-modal'),
    categoryDesc = $('#category_description'),
    categoryTitle = $('#category_title'),
    addCategory = $('.add-category button'),
    parentSelected = $('#category_parent'),
    categorySlug = $('#category_slug'),
    language = parentSelected.attr('data-locale'),
    todoTaskListWrapper = $('.todo-task-list-wrapper'),
    listStart = $('#listStart'),
    sidebarMenuList = $('.sidebar-menu-list'),
    areaInput = $('.area-input'),
    modalStart = $('#new-category-modal'),
    sidebarToggle = $('.sidebar-toggle'),
    btnUpdate = $('#category-btn-update'),
    btnSave = $('#category-btn-save'),
    categorySearch = $('#category-search');

categorySearch.keyup((event) => {
    event.preventDefault();
    console.log(event);
    event.target.submit;
    // alert('ok')
})

if (addCategory.length) {
    addCategory.on('click', () => {
        addBtn.removeClass('d-none');
        updateBtns.addClass('d-none');
        modalTitle.text(dataTitle);
        clearForm();
    });
}

let selecter;
if (parentSelected.length) {
    parentSelected.wrap('<div class="position-relative"></div>');
    selecter = parentSelected.select2({
        language: language,
        allowClear: true,
        ajax: {
            url: route('category.select'),
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.title,
                            id: item.id
                        }
                    })
                }
            }
        },
    });
}

// Todo sidebar toggle
if (sidebarToggle.length) {
    sidebarToggle.on('click', function (e) {
        e.stopPropagation();
        sidebarLeft.toggleClass('show');
        overlay.addClass('show');
    });
}
// On Overlay Click
if (overlay.length) {
    overlay.on('click', function (e) {
        overlays();
    });
}

// if it is not touch device
if (!$.app.menu.is_touch_device()) {
    if (sidebarMenuList.length > 0) {
        var sidebarListScrollbar = new PerfectScrollbar(sidebarMenuList[0], {
            theme: 'dark'
        });
    }
    if (todoTaskListWrapper.length > 0) {
        var taskListScrollbar = new PerfectScrollbar(todoTaskListWrapper[0], {
            theme: 'dark'
        });
    }
    listStart.wrap('<div class="widget-content" id="list-kategori"></div');
    $('#list-kategori .list-group').sortable({
        opacity: 0.5,
        cursor: 'move',
        placeholder: 'ui-state-highlight',
        update: function () {
            var orderAll = [];
            $('.list-group').each(() => {
                orderAll.push($(this).find('li').attr('id').replace(/_/g, '[]='));
            });
            $.post(route('category.sort'), {
                orderAll
            }).then(res => {
                if (res.status) toast('success', res.alert_title, res.message)
            }).catch(er => {
                if (!er.responseJSON.status) toast('error', er.responseJSON.alert_title, er.responseJSON.message)
            })
        }
    });
}
// if it is a touch device
else {
    sidebarMenuList.css('overflow', 'scroll');
    todoTaskListWrapper.css('overflow', 'scroll');
}

function node(id, value, parent = null, hasNode = false) {
    html = `<li id="${id}" class="list-group-item li-parent"><a class="text-truncate list-title"
            href="#">${value}</a>
            <div class="float-right">
            <a href="#" class="btn btn-icon btn-info waves-effect waves-float waves-light" onclick="show(${id})">
                <i data-feather="eye"></i>
            </a>
            <a href="#" class="btn btn-icon btn-primary waves-effect waves-float waves-light" onclick="edit(${id})">
                <i data-feather="edit"></i>
            </a>
            <a href="#" onclick="destroy(${id})"
                class="btn btn-icon btn-flat-danger waves-effect waves-light">
                <i data-feather="delete"></i>
            </a>
            </div>
            </li>`;
    htmls = parent && !hasNode ? '<ul class="list-group hirarki kategori">' + html + '</ul>' : html;
    if (parent && !hasNode) {
        wraper = $('#' + parent);
    } else if (parent && hasNode) {
        wraper = $('#' + parent).children('ul.list-group');
    } else {
        wraper = listStart;
    }
    wraper.append(htmls);
    return loadFeather();
}

// node(100, 'fungsi node berhasil ', 83, true);
if (categoryTitle.length) {
    categoryTitle.keyup(function () {
        categorySlug.val(generateSlug($(this).val()));
    })
}

btnSave.click(function () {
    action(route('category.store'), 'post');
})

btnUpdate.click(() => {
    let id = btnUpdate.attr('data-id');
    action(route('category.update', {
        id
    }), 'put');
})

const action = (route, method) => {
    areaInput.removeClass('is-invalid');
    data = {};
    data.title = categoryTitle.val();
    data.slug = categorySlug.val();
    data.parent = parentSelected.val();
    data.description = categoryDesc.val();

    return $.ajax(route, {
        method,
        data
    })
        .then(res => {
            if (res.created) node(res.id, data.title, data.parent, res.hasNode);
            if (res.updated) {
                if (res.move) {
                    $('#' + res.id).remove();
                    node(res.id, data.title, data.parent, res.hasNode);
                } else $('#' + res.id).children('.list-title').text(res.title);
            }
            overlays();
            return toast(res.alert, res.alert_title, res.message);
        })
        .catch(({
            responseJSON: er
        }) => {
            if (er.error) {
                toast('error', 'Error', er.message)
                return overlays();
            }
            if (typeof er !== 'undefined') {
                $.each(er, (key, value) => {
                    if (key) {
                        $('#category_' + key).addClass('is-invalid');
                        $('#valid-' + key).text(value);
                        console.log(key);
                    }
                })
            }
        })
}

const loadFeather = () => {
    if (feather) {
        return feather.replace({
            width: 14,
            height: 14
        });
    }
}
const overlays = () => {
    sidebarLeft.removeClass('show');
    overlay.removeClass('show');
    $(newTaskModal).modal('hide');
}

const clearForm = () => {
    // newTaskModal.modal('show');
    sidebarLeft.removeClass('show');
    overlay.removeClass('show');
    parentSelected.val(null).trigger('change');
    areaInput.val('');
    areaInput.removeClass('is-invalid');
}

const generateSlug = (value) => {
    return value.trim()
        .toLowerCase()
        .replace(/[^a-z\d-]/gi, '-')
        .replace(/-+/g, '-').replace(/^-|-$/g, "");
}
const toast = (type, title, message) => {
    toastr[type](message, title, {
        closeButton: true,
        tapToDismiss: false,
    });
}

btnConfirmLocal = $('#btnConfirm');
const destroy = (id) => {
    Swal.fire({
        title: btnConfirmLocal.attr('data-title'),
        text: btnConfirmLocal.attr('data-text'),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: btnConfirmLocal.attr('data-btn'),
        cancelButtonText: btnConfirmLocal.attr('data-btnCancel'),
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-outline-danger ml-1'
        },
        buttonsStyling: false
    }).then(function (result) {
        if (result.value) {
            return $.ajax(route('category.destroy', {
                id
            }), {
                method: 'delete'
            }).then(res => {
                $('#' + id).remove();
                toast(res.alert, res.alert_title, res.message);
            }).catch(er => {
                toast(er.responseJSON.alert, er.responseJSON.alert_title, er.responseJSON.message)
            })
        }
    })
}

const edit = (id) => {
    parentSelected.val(null).trigger('change');
    $.get(route('category.edit', {
        id: id
    })).then(res => {
        categoryTitle.val(res.category.title);
        categorySlug.val(res.category.slug);
        let newOption = new Option(res.parent.title, res.parent.id, true, true)
        if (res.parent) parentSelected.append(newOption).trigger('change');
        categoryDesc.val(res.category.description);
        updateBtns.removeClass('d-none');
        addBtn.addClass('d-none');
        updateBtns.attr('data-id', res.category.id);
        $('#new-category-modal').modal('show');
    })
}
const show = (id) => {
    $.get(route('category.show', {
        id
    })).then(res => {
        addBtn.addClass('d-none');
        updateBtns.addClass('d-none');
        categoryTitle.val(res.category.title);
        categorySlug.val(res.category.slug);
        let newOption = new Option(res.parent.title, res.parent.id, true, true)
        if (res.parent) parentSelected.append(newOption).trigger('change');
        categoryDesc.val(res.category.description);
        $('#new-category-modal').modal('show');
    })
}


// 'use strict';

// $(function () {

//     let dndCategory = document.getElementById('list-ul');
//     dragula([dndCategory],{
//         moves:function(el,container,handle){
//             // return handle.classList.contains('list-group');
//         }
//     }).on('drag',function(el){
//         el.className += ' ui-state-highlight';
//     }).on('drop',function(el){
//         el.className = el.className.replace('ui-state-highlight', '');
//     }).on('over', function (el, container) {
//         el.className += ' ui-state-highlight';
//     }).on('out', function (el, container) {
//         el.className = el.className.replace('ui-state-highlight', '');
//     });
//     // if (typeof(dndCategory) != 'undefined' && dndCategory !== null) {
//     // }
// });
