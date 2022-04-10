let filesTreeView = $('#tree')
let show_list;
var sort_type = 'alphabetic';

const tree = (data) => {
    if (filesTreeView.length) {
        filesTreeView.jstree({
            core: {
                themes: {
                    dots: false
                },
                data: data
            },
            plugins: ['types'],
            types: {
                default: {
                    icon: 'far fa-folder font-medium-1'
                },
                jpg: {
                    icon: 'far fa-file-image text-info font-medium-1'
                }
            }
        });
    }
}

$(document).on('click', '[data-view]', function () {
    show_list = $(this).data('view');
    console.log(show_list);
    loadItems();
});

function setOpenFolders() {
    $('#tree [data-path]').each(function (index, folder) {
        // close folders that are not parent
        var should_open = ($('#working_dir').val() + '/').startsWith($(folder).data('path') + '/');
        // $(folder).children('i')
        //     .toggleClass('fa-folder-open', should_open)
        //     .toggleClass('fa-folder', !should_open);
    });

    $('#tree .list-group-item').removeClass('active');
    $('#tree .list-group [data-path="' + $('#working_dir').val() + '"]').addClass('active');
}

function loadItems(page) {
    performLfmRequest(route('filemanager.getItems'), {
        show_list: show_list,
        sort_type: sort_type,
        page: page || 1
    }, 'json').done(function (data) {
        console.log(data);
    })
}

loadItems();
//load direktori
function loadFolders() {
    performLfmRequest(route('filemanager.getFolders'), {}, 'json')
        .done(function (data) {
            // tree(data.root_folders)
            for (let i = 0; i < data.root_folders.length; i++) {
                const element = data.root_folders[i];
                console.log(element);
                // console.log(data);
            }
            // $('#tree').html(data);
            // loadItems();
        });
}

loadFolders();
//request uri route
function performLfmRequest(url, parameter, type) {
    var data = defaultParameters();

    if (parameter != null) {
        $.each(parameter, function (key, value) {
            data[key] = value;
        });
    }

    return $.ajax({
        type: 'GET',
        beforeSend: function (request) {
            var token = getUrlParam('token');
            if (token !== null) {
                request.setRequestHeader("Authorization", 'Bearer ' + token);
            }
        },
        dataType: type || 'text',
        url: url,
        data: data,
        cache: false
    }).fail(function (jqXHR, textStatus, errorThrown) {
        displayErrorResponse(jqXHR);
    });
}

function getUrlParam(paramName) {
    var reParam = new RegExp('(?:[\?&]|&)' + paramName + '=([^&]+)', 'i');
    var match = window.location.search.match(reParam);
    return (match && match.length > 1) ? match[1] : null;
}


//others

function defaultParameters() {
    return {
        working_dir: $('#working_dir').val(),
        type: $('#type').val()
    };
}

function displayErrorResponse(jqXHR) {
    notify('<div style="max-height:50vh;overflow: scroll;">' + jqXHR.responseText + '</div>');
}

function notify(body, callback) {
    $('#notify').find('.btn-primary').toggle(callback !== undefined);
    $('#notify').find('.btn-primary').unbind().click(callback);
    $('#notify').modal('show').find('.modal-body').html(body);
}
