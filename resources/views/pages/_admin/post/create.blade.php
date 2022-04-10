<x-posts.admin-main>
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Blog Edit</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Pages</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Blog</a>
                                    </li>
                                    <li class="breadcrumb-item active">Edit
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrumb-right">
                        <div class="dropdown">
                            <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                    data-feather="grid"></i></button>
                            <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                    href="app-todo.html"><i class="mr-1" data-feather="check-square"></i><span
                                        class="align-middle">Todo</span></a><a class="dropdown-item"
                                    href="app-chat.html"><i class="mr-1"
                                        data-feather="message-square"></i><span class="align-middle">Chat</span></a><a
                                    class="dropdown-item" href="app-email.html"><i class="mr-1"
                                        data-feather="mail"></i><span class="align-middle">Email</span></a><a
                                    class="dropdown-item" href="app-calendar.html"><i class="mr-1"
                                        data-feather="calendar"></i><span class="align-middle">Calendar</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Blog Edit -->
                <div class="blog-edit-wrapper">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="avatar mr-75">
                                            <img src="../../../app-assets/images/portrait/small/avatar-s-9.jpg"
                                                width="38" height="38" alt="Avatar" />
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mb-25">{{ auth()->user()->name }}</h6>
                                            <p class="card-text">{{ date('d M, Y') }}</p>
                                        </div>
                                        <div class="pull-right">
                                            <a href="{{ route('post.index') }}" class="btn btn-primary"><i
                                                    data-feather='corner-up-left'></i>
                                                Back</a>
                                        </div>
                                    </div>
                                    <!-- Form -->
                                    <form action="javascript:;" class="mt-2" id="form-post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group mb-2">
                                                    <label for="blog-edit-title">Title</label>
                                                    <input type="text" id="blog-edit-title" class="form-control"
                                                        data-slug="blog-edit-slug" name="title"
                                                        value="{{ $post->title ?? '' }}" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group mb-2">
                                                    <label for="blog-edit-slug">Slug</label>
                                                    <input type="text" id="blog-edit-slug" class="form-control"
                                                        name="slug" value="{{ $post->slug ?? '' }}" />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group mb-2">
                                                    <label for="blog-edit-description">Description</label>
                                                    <textarea name="description" id="blog-edit-description" cols="5"
                                                        rows="3" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <div class="border rounded p-2">
                                                    <h4 class="mb-1">Featured Image</h4>
                                                    <div class="media flex-column flex-md-row">
                                                        <img src="{{ $post->thumbnail ?? '/app-assets/images/slider/03.jpg' }}"
                                                            id="blog-feature-image" class="rounded mr-2 mb-1 mb-md-0"
                                                            width="170" height="110" alt="Blog Featured Image" />
                                                        <div class="media-body">
                                                            <small class="text-muted">Required image resolution
                                                                800x400, image size 10mb.</small>
                                                            <p class="my-50">
                                                                {{-- <a href="javascript:void(0);"
                                                                    id="blog-image-text">C:\fakepath\banner.jpg</a> --}}
                                                            </p>
                                                            <div class="d-inline-block">
                                                                <div class="form-group mb-0">
                                                                    <div class="input-group">
                                                                        <div class="input-group-append" id="lfm"
                                                                            data-input="thumbnail" data-name="thumbs"
                                                                            data-preview="blog-feature-image">
                                                                            <button class="btn btn-outline-primary"
                                                                                type="button">Browse</button>
                                                                        </div>
                                                                        <input type="text" class="form-control"
                                                                            id="thumbs" aria-describedby="lfm"
                                                                            name="thumbnail" disabled />
                                                                        <input type="hidden" id="thumbnail"
                                                                            value="{{ $post->thumbnail ?? '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-9 col-12">
                                                <div class="form-group mb-2">
                                                    <label>Content</label>
                                                    <div id="blog-editor-wrapper">
                                                        {{-- <div id="blog-editor-container">
                                                            <div class="editor">
                                                            </div>
                                                        </div> --}}
                                                        <textarea id="editor" name="content"
                                                            style="min-height: 70vh; width: 100%;">
                                                            {{ $post->content ?? '' }}
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group mb-2">
                                                    <label for="category-view">Category</label>
                                                    <div id="category-view">

                                                    </div>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label for="tag-list">Tags</label>
                                                    <select id="tag-list" class="select2 form-control" name="tags[]"
                                                        data-locale="{{ app()->getLocale() }}"
                                                        data-placeholder="Pilih Tags" multiple>
                                                        @isset($tags)
                                                            @foreach ($tags as $tag)
                                                                <option value="{{ $tag->id }}" selected>
                                                                    {{ $tag->title }}
                                                                </option>
                                                            @endforeach
                                                        @endisset
                                                    </select>
                                                </div>
                                                <div class="form-group border rounded p-2">
                                                    {{-- <button type="submit" id="btnSave" class="btn btn-primary"
                                                        data-toggle="tooltip" data-placement="top" title="Save Change">
                                                        <i data-feather="save"></i></button> --}}
                                                    <button class="btn btn-primary" id="btnSave" data-toggle="tooltip"
                                                        data-placement="top" title="Draft Change">Draft <i
                                                            data-feather="hard-drive"></i></button>
                                                    <button type="reset" class="btn btn-danger" data-toggle="tooltip"
                                                        data-placement="top" title="Delete Change"><i
                                                            data-feather="trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!--/ Form -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Blog Edit -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
    <x-slot name="css_vendor">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('app-assets/fonts/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('app-assets/vendors/css/extensions/jstree.min.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('app-assets/css/plugins/extensions/ext-component-tree.css') }}">

    </x-slot>
    <x-slot name="js_page">

        {{-- <script src="https://cdn.ckeditor.com/ckeditor5/29.2.0/classic/ckeditor.js"></script> --}}
        {{-- <script src="https://ckeditor.com/apps/ckfinder/3.5.0/ckfinder.js"></script> --}}
        <script src="https://cdn.tiny.cloud/1/1dxkt86ssl2ewt18fvrkm751otgi19tt0zebtfaov80g9xoy/tinymce/5/tinymce.min.js"
                referrerpolicy="origin"></script>
        <script src="{{ asset('app-assets/vendors/js/extensions/jstree.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/forms/select/i18n/' . app()->getLocale() . '.js') }}"></script>
        {{-- <script src="{{ asset('vendor/n1ed/plugins/n1ed/plugin.min.js') }}"></script> --}}
        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
        {{-- <script src="{{ asset('app-assets/vendors/js/ckeditor5-classic/ckeditor.js') }}"></script> --}}
        {{-- <script src="{{ asset('app-assets/vendors/js/ckeditor5-classic/ckeditor.js.map') }}"></script> --}}

        {{-- <script src="{{ asset('app-assets/js/scripts/pages/page-blog-edit.js') }}"></script> --}}
        <script src="/assets/js/pages/posts/create.js"></script>
        <script>

        </script>
    </x-slot>
</x-posts.admin-main>
