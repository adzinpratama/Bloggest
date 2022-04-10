$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').val()
    }
});

//generate slug
$('#blog-edit-title').generateSlug();

var select = $('#tag-list');
var blogImageInput = $('#blogCustomFile');
var blogFeatureImage = $('#blog-feature-image');
var blogImageText = document.getElementById('blog-image-text');

select.each(function () {
    var $this = $(this);
    $this.wrap('<div class="position-relative"></div>');
    $this.select2({
        // the following code is used to disable x-scrollbar when click in select input and
        // take 100% width in responsive also
        dropdownAutoWidth: true,
        width: '100%',
        dropdownParent: $this.parent(),
        language: 'id',
        allowClear: true,
        ajax: {
            url: route('tags.list'),
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
});
// category treeview
categoryTree = $('#category-view');
const treeview = (route) => {
    return categoryTree.jstree({
        core: {
            data: {
                url: route,
                dataType: 'json',
                data: function (node) {
                    return {
                        id: node.id,
                    };
                }
            }
        },
        checkbox: {
            keep_selected_style: true,
            tie_selection: false,
            three_state: false,
            two_state: false,
        },
        plugins: ['types', 'checkbox'],
        types: {
            default: {
                icon: 'far fa-caret-square-up'
            }
        }
    })
}

if (location.href != route('post.create')) {
    let id = location.pathname.split('/')[3];
    treeview(route('post.list', { id }));
} else {
    treeview(route('category.list'))
}

$('#btnSave').click(() => {
    data = {};
    let id = location.pathname.split('/')[3];
    if (id != 'create') {
        data.id = id;
    }
    data.content = tinymce.get("editor").getContent();
    data.title = $('#blog-edit-title').val();
    data.slug = $('#blog-edit-slug').val();
    data.description = $('#blog-edit-description').val();
    let checkedNode = categoryTree.jstree("get_checked", true);
    data.category = [];
    $.each(checkedNode, function () {
        data.category.push(this.id);
    })
    data.thumbnail = $('#thumbnail').val();
    data.tag = $('#tag-list').val();
    console.log(data);
    $.post(route('post.store'), data).then(res => {
        if (res.success) {
            notif('success', { message: res.message });
        }
    }).catch(({ responseJSON: er }) => {
        $.each(er, function (key, val) {
            notif('error', { message: val });
        })
    })
})


var route_prefix = "filemanager";
$('#lfm').filemanager('image');



var useDarkMode = $('html').hasClass('dark-layout');

var editor_config = {
    path_absolute: "/",
    selector: '#editor',
    relative_urls: false,
    plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
    imagetools_cors_hosts: ['picsum.photos'],
    menubar: 'file edit view insert format tools table help',
    toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
    toolbar_sticky: true,
    autosave_ask_before_unload: true,
    autosave_interval: '30s',
    autosave_prefix: '{path}{query}-{id}-',
    autosave_restore_when_empty: false,
    autosave_retention: '2m',
    image_advtab: true,
    importcss_append: true,
    file_picker_callback: function (callback, value, meta) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
            'body')[0].clientWidth;
        var y = window.innerHeight || document.documentElement.clientHeight || document
            .getElementsByTagName('body')[0].clientHeight;

        var cmsURL = editor_config.path_absolute + 'filemanager?editor=' + meta.fieldname;
        if (meta.filetype == 'image') {
            cmsURL = cmsURL + "&type=Images";
        } else {
            cmsURL = cmsURL + "&type=Files";
        }

        tinyMCE.activeEditor.windowManager.openUrl({
            url: cmsURL,
            title: 'Filemanager',
            width: x * 0.9,
            height: y * 0.9,
            resizable: "yes",
            close_previous: "no",
            onMessage: (api, message) => {
                callback(message.content);
            }
        });
    },
    templates: [{
        title: 'New Table',
        description: 'creates a new table',
        content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>'
    },
    {
        title: 'Starting my story',
        description: 'A cure for writers block',
        content: 'Once upon a time...'
    },
    {
        title: 'New list with dates',
        description: 'New List with dates',
        content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>'
    }
    ],
    template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
    template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
    height: 600,
    image_caption: true,
    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
    noneditable_noneditable_class: 'mceNonEditable',
    toolbar_mode: 'floating',//'sliding',
    contextmenu: 'link image imagetools table',
    skin: useDarkMode ? 'oxide-dark' : 'oxide',
    content_css: useDarkMode ? 'dark' : 'default',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
    images_upload_handler: function (blobInfo, success, failure, progress) {
        var xhr, formData;

        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('post', route('post.tiny'));

        xhr.upload.onprogress = function (e) {
            progress(e.loaded / e.total * 100);
        };

        xhr.onload = function () {
            var json;

            if (xhr.status === 403) {
                failure('HTTP Error: ' + xhr.status, { remove: true });
                return;
            }

            if (xhr.status < 200 || xhr.status >= 300) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }

            json = JSON.parse(xhr.responseText);

            if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }

            success(json.location);
        };

        xhr.onerror = function () {
            failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
        };
        console.log(blobInfo.name());
        formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        formData.append('name', blobInfo.filename());
        xhr.send(formData);
    }
};

tinymce.init(editor_config);


