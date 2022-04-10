<x-posts.admin-main>
    <div class="app-content content email-application">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-area-wrapper container-xxl p-0">
            <div class="sidebar-left">
                <div class="sidebar">
                    <div class="sidebar-content email-app-sidebar">
                        <div class="email-app-menu">
                            <div class="form-group-compose text-center compose-btn">
                                {{-- <button type="button" class="compose-email btn btn-primary btn-block"
                                    data-backdrop="false" data-toggle="modal" data-target="#compose-mail">
                                    Add Article
                                </button> --}}
                                <a href="{{ route('post.create') }}" class="btn btn-primary btn-block">Add Article</a>
                            </div>
                            <div class="sidebar-menu-list">
                                <div class="list-group list-group-messages">
                                    <a href="javascript:void(0)" class="list-group-item list-group-item-action active">
                                        <i data-feather="server" class="font-medium-3 mr-50"></i>
                                        <span class="align-middle">All</span>
                                        <span class="badge badge-light-primary badge-pill float-right">3</span>
                                    </a>
                                    <a href="javascript:void(0)" class="list-group-item list-group-item-action">
                                        <i data-feather="send" class="font-medium-3 mr-50"></i>
                                        <span class="align-middle">Publish</span>
                                    </a>
                                    <a href="javascript:void(0)" class="list-group-item list-group-item-action">
                                        <i data-feather="edit-2" class="font-medium-3 mr-50"></i>
                                        <span class="align-middle">Draft</span>
                                        <span class="badge badge-light-warning badge-pill float-right">2</span>
                                    </a>
                                    <a href="javascript:void(0)" class="list-group-item list-group-item-action">
                                        <i data-feather="shuffle" class="font-medium-3 mr-50"></i>
                                        <span class="align-middle">Pending</span>
                                    </a>
                                    <a href="javascript:void(0)" class="list-group-item list-group-item-action">
                                        <i data-feather="star" class="font-medium-3 mr-50"></i>
                                        <span class="align-middle">Star</span>
                                    </a>
                                    <a href="javascript:void(0)" class="list-group-item list-group-item-action">
                                        <i data-feather="trash" class="font-medium-3 mr-50"></i>
                                        <span class="align-middle">Trash</span>
                                    </a>
                                </div>
                                <!-- <hr /> -->
                                <h6 class="section-label mt-3 mb-1 px-2">Labels</h6>
                                <div class="list-group list-group-labels">
                                    <a href="javascript:void(0)" class="list-group-item list-group-item-action"><span
                                            class="bullet bullet-sm bullet-success mr-1"></span>Personal</a>
                                    <a href="javascript:void(0)" class="list-group-item list-group-item-action"><span
                                            class="bullet bullet-sm bullet-primary mr-1"></span>Company</a>
                                    <a href="javascript:void(0)" class="list-group-item list-group-item-action"><span
                                            class="bullet bullet-sm bullet-warning mr-1"></span>Important</a>
                                    <a href="javascript:void(0)" class="list-group-item list-group-item-action"><span
                                            class="bullet bullet-sm bullet-danger mr-1"></span>Private</a>
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
                        <div class="email-app-list">
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
                                        <input type="text" class="form-control" id="email-search"
                                            placeholder="Search email" aria-label="Search..."
                                            aria-describedby="email-search" />
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
                                        <li class="list-inline-item">
                                            <div class="dropdown">
                                                <a href="javascript:void(0);" class="dropdown-toggle" id="folder"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i data-feather="folder" class="font-medium-2"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="folder">
                                                    <a class="dropdown-item d-flex align-items-center"
                                                        href="javascript:void(0);">
                                                        <i data-feather="edit-2" class="font-small-4 mr-50"></i>
                                                        <span>Draft</span>
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center"
                                                        href="javascript:void(0);">
                                                        <i data-feather="info" class="font-small-4 mr-50"></i>
                                                        <span>Spam</span>
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center"
                                                        href="javascript:void(0);">
                                                        <i data-feather="trash" class="font-small-4 mr-50"></i>
                                                        <span>Trash</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-inline-item">
                                            <div class="dropdown">
                                                <a href="javascript:void(0);" class="dropdown-toggle" id="tag"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i data-feather="tag" class="font-medium-2"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="tag">
                                                    <a href="javascript:void(0);" class="dropdown-item"><span
                                                            class="mr-50 bullet bullet-success bullet-sm"></span>Personal</a>
                                                    <a href="javascript:void(0);" class="dropdown-item"><span
                                                            class="mr-50 bullet bullet-primary bullet-sm"></span>Company</a>
                                                    <a href="javascript:void(0);" class="dropdown-item"><span
                                                            class="mr-50 bullet bullet-warning bullet-sm"></span>Important</a>
                                                    <a href="javascript:void(0);" class="dropdown-item"><span
                                                            class="mr-50 bullet bullet-danger bullet-sm"></span>Private</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-inline-item mail-unread">
                                            <span class="action-icon"><i data-feather="mail"
                                                    class="font-medium-2"></i></span>
                                        </li>
                                        <li class="list-inline-item mail-delete">
                                            <span class="action-icon"><i data-feather="trash-2"
                                                    class="font-medium-2"></i></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Email actions ends -->

                            <!-- Email list starts -->
                            <div class="email-user-list" id="post-list">

                            </div>
                            <!-- Email list ends -->
                        </div>
                        <!--/ Email list Area -->
                        <!-- Detailed Email View -->
                        <div class="email-app-details">
                            <!-- Detailed Email Header starts -->
                            <div class="email-detail-header">
                                <div class="email-header-left d-flex align-items-center">
                                    <span class="go-back mr-1"><i data-feather="chevron-left"
                                            class="font-medium-4"></i></span>
                                    <h4 class="email-subject mb-0" id="details-title">Focused open system 😃</h4>
                                    <input type="hidden" id="unique-show">
                                </div>
                                <div class="email-header-right ml-2 pl-1">
                                    <ul class="list-inline m-0">
                                        <li class="list-inline-item">
                                            <span class="action-icon favorite"><i data-feather="star"
                                                    class="font-medium-2"></i></span>
                                        </li>
                                        <li class="list-inline-item">
                                            <div class="dropdown no-arrow">
                                                <a href="javascript:void(0);" class="dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i data-feather="folder" class="font-medium-2"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="folder">
                                                    <a class="dropdown-item d-flex align-items-center"
                                                        href="javascript:void(0);">
                                                        <i data-feather="edit-2" class="font-medium-3 mr-50"></i>
                                                        <span>Draft</span>
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center"
                                                        href="javascript:void(0);">
                                                        <i data-feather="info" class="font-medium-3 mr-50"></i>
                                                        <span>Spam</span>
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center"
                                                        href="javascript:void(0);">
                                                        <i data-feather="trash" class="font-medium-3 mr-50"></i>
                                                        <span>Trash</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-inline-item" id="btn-edit">
                                            <span class="action-icon" data-toggle="tooltip" data-placement="top"
                                                title="Edit Artikel"><i data-feather="edit-3"
                                                    class="font-medium-2"></i> Edit</span>
                                        </li>
                                        <li class="list-inline-item" id="btn-destroy">
                                            <span class="action-icon" data-toggle="tooltip" data-placement="top"
                                                title="Hapus Artikel"><i data-feather="trash"
                                                    class="font-medium-2"></i> Hapus</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Detailed Email Header ends -->

                            <!-- Detailed Email Content starts -->
                            <div class="email-scroll-area">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="email-label">
                                            <span
                                                class="mail-label badge badge-pill badge-light-primary">Company</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="show-details">

                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <h5 class="mb-0">
                                                        Click here to
                                                        <a href="javascript:void(0);">Reply</a>
                                                        or
                                                        <a href="javascript:void(0);">Forward</a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Detailed Email Content ends -->
                        </div>
                        <!--/ Detailed Email View -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="js_page">
        <script src="/assets/js/pages/posts/index.js"></script>
    </x-slot>
</x-posts.admin-main>
