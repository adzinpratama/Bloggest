@if (count($posts))
    <ul class="email-media-list">
        @foreach ($posts as $post)
            <li class="media mail-read">
                <div class="media-left pr-50">
                    <div class="avatar">
                        <img src="{{ asset('app-assets/images/portrait/small/avatar-s-20.jpg') }}"
                            alt="avatar img holder" />
                    </div>
                    <div class="user-action">
                        <div class="custom-control custom-checkbox selectSingle">
                            <input type="checkbox" class="custom-control-input" id="{{ $post->slug }}" />
                            <label class="custom-control-label" for="{{ $post->slug }}"></label>
                        </div>
                        <span class="email-favorite"><i data-feather="star"></i></span>
                    </div>
                </div>
                <div class="media-body" data-show="{{ encrypt($post->id) }}" data-title="{{ $post->title }}">
                    <div class="mail-details">
                        <div class="mail-items">
                            <h5 class="mb-25">{{ $post->title }}</h5>
                            <span class="text-truncate">🎯 {{ $post->user->name }}
                            </span>
                        </div>
                        <div class="mail-meta-item">
                            <span class="mr-50 bullet bullet-success bullet-sm"></span>
                            <span class="mail-date">{{ $post->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="mail-message">
                        <p class="text-truncate mb-0">
                            {{ $post->description }}
                        </p>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@else
    <div class="no-results">
        <h5>No Items Found</h5>
    </div>
@endif
