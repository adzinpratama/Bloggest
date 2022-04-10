<x-layouts.admin-main>
    <x-slot name="title">{{ trans('common.link.category') }}</x-slot>
    <!-- BEGIN: Content-->
    <div class="app-content content todo-application">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-area-wrapper container-xxl p-0">
            <div class="sidebar-left">
                <div class="sidebar">
                    <div class="sidebar-content todo-sidebar">
                        <div class="todo-app-menu">
                            <div class="add-category">
                                <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                    data-target="#new-category-modal">
                                    {{ trans('category.button.add_category') }}
                                </button>
                            </div>
                            <div class="sidebar-menu-list">
                                <div class="list-group list-group-filters">
                                    <a href="javascript:void(0)" class="list-group-item list-group-item-action active">
                                        <i data-feather="mail" class="font-medium-3 mr-50"></i>
                                        <span class="align-middle"> {{ trans('category.button.article') }}</span>
                                    </a>
                                    <a href="javascript:void(0)" class="list-group-item list-group-item-action">
                                        <i data-feather="star" class="font-medium-3 mr-50"></i> <span
                                            class="align-middle">{{ trans('category.button.page') }}</span>
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
                        <div class="todo-app-list">
                            <!-- Todo search starts -->
                            <div class="app-fixed-search d-flex align-items-center">
                                <div class="sidebar-toggle d-block d-lg-none ml-1">
                                    <i data-feather="menu" class="font-medium-5"></i>
                                </div>
                                <div class="d-flex align-content-center justify-content-between w-100">
                                    <form action="{{ route('category.index') }}" method="get" id="form-search">
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i data-feather="search"
                                                        class="text-muted"></i></span>
                                            </div>
                                            <input type="search" name="keyword"
                                                value="{{ request()->get('keyword') }}" class="form-control"
                                                id="category-search"
                                                placeholder="{{ trans('category.label.search') }}"
                                                aria-label="{{ trans('category.area-label.search') }}"
                                                aria-describedby="todo-search" />
                                            <button type="submit" class="d-none">Cari</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle hide-arrow mr-1"
                                        id="todoActions" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i data-feather="more-vertical" class="font-medium-2 text-body"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="todoActions">
                                        <a class="dropdown-item sort-asc" href="javascript:void(0)">Sort A - Z</a>
                                        <a class="dropdown-item sort-desc" href="javascript:void(0)">Sort Z - A</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Sort Assignee</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Sort Due Date</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Sort Today</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Sort 1 Week</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Sort 1 Month</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Todo search ends -->
                            <!-- Todo List starts -->
                            <div class="todo-task-list-wrapper list-group">
                                <!-- /widget-content -->
                                <ul class="list-group hirarki kategori" id="listStart">
                                    @if (count($categories))
                                        @include('pages._admin.category._category-list',[
                                        'categories'=>$categories
                                        ])
                                    @else
                                        @if (request()->get('keyword'))

                                            <li class="list-group-item li-parent"><a class="text-truncate list-title"
                                                    href="#">Data Tidak Ditemukan</a>
                                            </li>
                                        @else
                                            <li class="list-group-item li-parent"><a class="text-truncate list-title"
                                                    href="#">Oops Belum Ada Data</a>
                                            </li>
                                        @endif
                                    @endif
                                </ul>
                                <ul class="list-group mb-3 ml-1">
                                    <div class="float-right">
                                        {{ $categories->links('vendor.pagination.vuexy') }}
                                    </div>
                                </ul>

                            </div>
                            <!-- Todo List ends -->



                        </div>

                        <!-- Right Sidebar starts -->
                        <div class="modal modal-slide-in sidebar-category-modal fade" id="new-category-modal">
                            <div class="modal-dialog sidebar-lg">
                                <div class="modal-content p-0">
                                    <form id="form-modal-category" class="todo-modal needs-validation" novalidate
                                        onsubmit="return false">
                                        @csrf
                                        <div class="modal-header align-items-center mb-1">
                                            <h5 class="modal-title"
                                                data-title="{{ trans('category.form.modal_title') }}">Add Task</h5>
                                            <div
                                                class="todo-item-action d-flex align-items-center justify-content-between ml-auto">
                                                <span class="todo-item-favorite cursor-pointer mr-75"><i
                                                        data-feather="star" class="font-medium-2"></i></span>
                                                <button type="button" class="close font-large-1 font-weight-normal py-0"
                                                    data-dismiss="modal" aria-label="Close">
                                                    ×
                                                </button>
                                            </div>
                                        </div>
                                        <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                            <div class="action-tags">
                                                <div class="form-group">
                                                    <label for="category_title"
                                                        class="form-label">{{ trans('category.form.title') }}</label>
                                                    <input type="text" id="category_title" name="title"
                                                        class="form-control area-input"
                                                        placeholder="{{ trans('category.form.title') }}" />
                                                    <div class="invalid-feedback" id="valid-title"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="category_slug"
                                                        class="form-label">{{ trans('category.form.slug') }}</label>
                                                    <input type="text" id="category_slug" name="slug"
                                                        class="form-control area-input"
                                                        placeholder="{{ trans('category.form.slug') }}" readonly />
                                                    <div class="invalid-feedback" id="valid-slug"></div>
                                                </div>
                                                <div class="form-group position-relative">
                                                    <label for="category_parent"
                                                        class="form-label d-block">{{ trans('category.form.parent') }}</label>
                                                    <select class="select2 form-control" id="category_parent"
                                                        data-locale="{{ app()->getLocale() }}" name="parent"
                                                        data-placeholder="{{ trans('category.form.select_parent') }}">
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        class="form-label">{{ trans('category.form.description') }}</label>
                                                    <textarea name="description" id="category_description" rows="4"
                                                        class="form-control area-input"
                                                        placeholder="{{ trans('category.message.message_description') }}"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group my-1">
                                                <button type="submit"
                                                    class="btn btn-primary d-none add-category-item mr-1"
                                                    id="category-btn-save">{{ trans('category.button.add') }}</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary add-category-item d-none"
                                                    data-dismiss="modal">
                                                    {{ trans('category.button.cancel') }}
                                                </button>
                                                <button type="button" id="category-btn-update"
                                                    class="btn btn-primary d-none update-btn update-todo-item mr-1">{{ trans('category.button.update') }}</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary update-btn d-none"
                                                    data-dismiss="modal">{{ trans('category.button.cancel') }}</button>
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
    <div id="btnConfirm" data-title="{{ trans('category.button.confirm.title') }}"
        data-text="{{ trans('category.button.confirm.text') }}"
        data-btn="{{ trans('category.button.confirm.buttonText') }}"
        data-btnCancel="{{ trans('category.button.cancel') }}"></div>
    <!-- END: Content-->
    <x-slot name="css_vendor">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('app-assets/vendors/js/jquery-ui/jquery-ui.min.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('app-assets/vendors/css/extensions/sweetalert2.min.css') }}">

    </x-slot>
    <x-slot name="css_page">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('app-assets/css/plugins/extensions/ext-component-sweet-alerts.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-todo.css') }}">
    </x-slot>
    <x-slot name="js_vendor">
        <script src="{{ asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/forms/select/i18n/' . app()->getLocale() . '.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/jquery-ui/jquery-ui.min.js') }}"></script>
    </x-slot>
    <x-slot name="js_page">
        {{-- <script src="{{ asset('app-assets/js/scripts/pages/app-todo.js') }}"></script> --}}
        <script src="/assets/js/pages/category.js"></script>
    </x-slot>
</x-layouts.admin-main>
