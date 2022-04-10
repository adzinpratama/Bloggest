<div class="col-12">
    <div class="card">
        <img src="{{ $post->thumbnail }}" class="img-fluid card-img-top" alt="Blog Detail Pic" />
        <div class="card-body">
            <h4 class="card-title">{{ $post->title }}</h4>
            <div class="media">
                <div class="avatar mr-50">
                    <img src="../../../app-assets/images/portrait/small/avatar-s-7.jpg" alt="Avatar" width="24"
                        height="24" />
                </div>
                <div class="media-body">
                    <small class="text-muted mr-25">by</small>
                    <small><a href="javascript:void(0);" class="text-body">{{ $post->user->name }}</a></small>
                    <span class="text-muted ml-50 mr-25">|</span>
                    <small class="text-muted">Jan 10, 2020</small>
                </div>
            </div>
            <div class="my-1 py-25">
                @foreach ($post->categories as $category)
                    <a href="javascript:void(0);">
                        <div class="badge badge-pill badge-light-warning mr-50">{{ $category->title }}
                        </div>
                    </a>
                @endforeach
            </div>
            <p class="card-text mb-2">
                {!! $post->content !!}
            </p>
            <hr class="my-2" />
            <div class="my-1 py-25">
                @foreach ($post->tags as $tag)
                    <a href="javascript:void(0);">
                        <div class="badge badge-pill badge-light-danger mr-50">#{{ $tag->title }}
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="media">
                <div class="avatar mr-2">
                    <img src="../../../app-assets/images/portrait/small/avatar-s-6.jpg" width="60" height="60"
                        alt="Avatar" />
                </div>
                <div class="media-body">
                    <h6 class="font-weight-bolder">{{ $post->user->name }}</h6>
                    <p class="card-text mb-0">
                        Based in London, Uncode is a blog by Willie Clark. His posts
                        explore modern design trends through photos
                        and quotes by influential creatives and web designer around
                        the world.
                    </p>
                </div>
            </div>
            <hr class="my-2" />
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center mr-1">
                        <a href="javascript:void(0);" class="mr-50">
                            <i data-feather="message-square" class="font-medium-5 text-body align-middle"></i>
                        </a>
                        <a href="javascript:void(0);">
                            <div class="text-body align-middle">19.1K</div>
                        </a>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="javascript:void(0);" class="mr-50">
                            <i data-feather="bookmark" class="font-medium-5 text-body align-middle"></i>
                        </a>
                        <a href="javascript:void(0);">
                            <div class="text-body align-middle">139</div>
                        </a>
                    </div>
                </div>
                <div class="dropdown blog-detail-share">
                    <i data-feather="share-2" class="font-medium-5 text-body cursor-pointer" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="javascript:void(0);" class="dropdown-item py-50 px-1">
                            <i data-feather="github" class="font-medium-3"></i>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item py-50 px-1">
                            <i data-feather="gitlab" class="font-medium-3"></i>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item py-50 px-1">
                            <i data-feather="facebook" class="font-medium-3"></i>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item py-50 px-1">
                            <i data-feather="twitter" class="font-medium-3"></i>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item py-50 px-1">
                            <i data-feather="linkedin" class="font-medium-3"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
