@if (count($tags))
    @if ($tags->hasPages())
        <div class="app-action">
            <div class="action-left" id="link">
                {{ $tags->links('vendor.pagination.vuexy') }}
            </div>
        </div>
    @endif
    <ul class="tag-media-list">
        @foreach ($tags as $tag)
            <li class="media mail-read">
                <div class="media-left pr-50">
                    <div class="user-action">
                        <div class="custom-control custom-checkbox selectSingle">
                            <input type="checkbox" class="custom-control-input" id="customCheck{{ $tag->slug }}"
                                data-id="{{ encrypt($tag->id) }}" />
                            <label class="custom-control-label" for="customCheck{{ $tag->slug }}"></label>
                        </div>
                        <span class="tag-favorite"><i data-feather="tag"></i></span>
                    </div>
                </div>
                <div class="media-body" data-title="{{ $tag->title }}" data-slug="{{ $tag->slug }}"
                    data-id="{{ encrypt($tag->id) }}">
                    <div class="mail-details">
                        <div class="mail-items">
                            <h5 class="mb-25">{{ $tag->title }}</h5>
                            <span class="text-truncate mb-0">{{ $tag->slug }}</span>
                        </div>
                        <div class="mail-meta-item">
                            <span class="mx-50 bullet bullet-warning bullet-sm"></span>
                            <span class="mail-date">{{ $tag->created_at->diffForHumans() }}</span>

                        </div>
                    </div>

                </div>
            </li>
        @endforeach
    </ul>
@else
    <div class="no-results show">
        <h5>No Items Found</h5>
    </div>
@endif
