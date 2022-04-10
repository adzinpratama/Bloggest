<x-layouts.admin-main>
    <x-slot name="title">{{ trans('common.link.tag') }}</x-slot>
    <div class="app-content content tag-application">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-area-wrapper container-xxl p-0">
            <div class="sidebar-left">
                <div class="sidebar">
                    <div class="sidebar-content tag-app-sidebar">
                        <div class="tag-app-menu">
                            <div class="form-group-add text-center tag-btn">
                                <button type="button" class="compose-email btn btn-primary btn-block"
                                    data-backdrop="false" data-toggle="modal" data-target="#new-tag-modal">
                                    Add Tag
                                </button>
                            </div>
                            <div class="sidebar-menu-list">
                                <div class="list-group list-group-messages">
                                    <a href="javascript:void(0)" class="list-group-item list-group-item-action active">
                                        <i data-feather="book" class="font-medium-3 mr-50"></i>
                                        <span class="align-middle">Post</span>
                                        <span class="badge badge-light-primary badge-pill float-right">3</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="content-right">
                <div class="content-wrapper container-xxl p-0">
                    <div class="content-header row">
                    </div>
                    <div class="content-body">
                        <div class="body-content-overlay"></div>
                        <!-- Email list Area -->
                        <div class="tag-app-list">
                            <!-- Email search starts -->
                            <div class="app-fixed-search d-flex align-items-center">
                                <div class="sidebar-toggle d-block d-lg-none ml-1">
                                    <i data-feather="menu" class="font-medium-5"></i>
                                </div>
                                <div class="d-flex align-content-center justify-content-between w-100">
                                    <div class="input-group input-group-merge">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i data-feather="search"
                                                    class="text-muted"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="tag-search"
                                            placeholder="Search Tag" aria-label="Search..."
                                            aria-describedby="tag-search" />
                                    </div>
                                </div>
                            </div>
                            <!-- Email search ends -->

                            <!-- Email actions starts -->
                            <div class="app-action">
                                <div class="action-left">
                                    <div class="custom-control custom-checkbox selectAll">
                                        <input type="checkbox" class="custom-control-input" id="selectAllCheck" />
                                        <label class="custom-control-label font-weight-bolder pl-25"
                                            for="selectAllCheck">Select All</label>
                                    </div>
                                </div>
                                <div class="action-right">
                                    <ul class="list-inline m-0">
                                        {{-- <li class="list-inline-item">
                                            {{ $tags->links('vendor.pagination.vuexy') }}
                                        </li> --}}
                                        <li class="list-inline-item tag-delete">
                                            <span class="action-icon"><i data-feather="trash-2"
                                                    class="font-medium-2"></i></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Email actions ends -->

                            <!-- Email list starts -->
                            <div class="tags-list" id="tag-list">


                            </div>
                            <!-- Email list ends -->
                        </div>
                        <!--/ Email list Area -->

                        <!-- Right Sidebar starts -->
                        <div class="modal modal-slide-in sidebar-tag-modal fade" id="new-tag-modal">
                            <div class="modal-dialog sidebar-lg">
                                <div class="modal-content p-0">
                                    <form id="form-modal-tag" class="needs-validation" novalidate
                                        onsubmit="return false">
                                        @csrf
                                        <div class="modal-header align-items-center mb-1">
                                            <h5 class="modal-title"
                                                data-title="{{ trans('category.form.modal_title') }}">Add Task</h5>
                                            <div
                                                class="todo-item-action d-flex align-items-center justify-content-between ml-auto">
                                                <button type="button"
                                                    class="close font-large-1 font-weight-normal mr-20 mb-3"
                                                    data-dismiss="modal" aria-label="Close">
                                                    ×
                                                </button>
                                            </div>
                                        </div>
                                        <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                            <div class="action-tags">
                                                <div class="form-group">
                                                    <label for="tag_title"
                                                        class="form-label">{{ trans('category.form.title') }}</label>
                                                    <input type="text" id="tag_title" name="title"
                                                        class="form-control area-input"
                                                        placeholder="{{ trans('category.form.title') }}" />
                                                    <div class="invalid-feedback" id="valid-title"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tag_slug"
                                                        class="form-label">{{ trans('category.form.slug') }}</label>
                                                    <input type="text" id="tag_slug" name="slug"
                                                        class="form-control area-input"
                                                        placeholder="{{ trans('category.form.slug') }}" readonly />
                                                    <div class="invalid-feedback" id="valid-slug"></div>
                                                </div>
                                            </div>
                                            {{-- <input type="hidden" name="id" id="tag_id"> --}}
                                            <div class="form-group my-1">
                                                <button type="submit" class="btn btn-primary d-none add-tag-item mr-1"
                                                    id="tag-btn-save"><i data-feather="save"></i> Save</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary add-tag-item d-none"
                                                    data-dismiss="modal">
                                                    {{ trans('category.button.cancel') }}
                                                </button>
                                                <button type="button" id="tag-btn-update"
                                                    class="btn btn-primary d-none change-btn"><i
                                                        data-feather="save"></i> change</button>
                                                <button type="button" id="tag-btn-delete"
                                                    class="btn btn-danger d-none change-btn mr-4"><i
                                                        data-feather="trash"></i> Delete</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary change-btn d-none"
                                                    data-dismiss="modal">{{ trans('category.button.cancel') }}</button>
                                                <div id="btn-confirm" data-title="{{ trans('alert.confirm.title') }}"
                                                    data-text="{{ trans('alert.confirm.text', ['name' => 'Tag']) }}"
                                                    data-accept="{{ trans('alert.confirm.buttonAccept') }}"
                                                    data-reject="{{ trans('alert.confirm.buttonReject') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Right Sidebar ends -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="css_vendor">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="stylesheet" type="text/css"
            href="https://fonts.googleapis.com/css2?family=Inconsolata&amp;family=Roboto+Slab&amp;family=Slabo+27px&amp;family=Sofia&amp;family=Ubuntu+Mono&amp;display=swap">
    </x-slot>
    <x-slot name="css_page">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('app-assets/css/plugins/extensions/ext-component-sweet-alerts.css') }}">
        {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-email.css') }}"> --}}
        <link rel="stylesheet" href="/assets/css/pages/tag.css">
    </x-slot>
    <x-slot name="js_vendor">
        <script src="{{ asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
        <script src="{{ asset('app-assets/js/scripts/extensions/ext-component-blockui.js') }}"></script>
    </x-slot>
    <x-slot name="js_page">
        {{-- <script src="{{ asset('app-assets/js/scripts/pages/app-email.js') }}"></script> --}}
        <script src="/assets/js/pages/tag.js"></script>
    </x-slot>
</x-layouts.admin-main>
