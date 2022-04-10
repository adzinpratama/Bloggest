@foreach ($categories as $category)
    <li class="todo-item li-parent">
        <div class="todo-title-wrapper">
            <div class="todo-title-area">
                <i data-feather="more-vertical" class="drag-icon"></i>
                <div class="title-wrapper">
                    <span class="todo-title">{{ $category->title }}
                        💻</span>
                </div>
            </div>
            <div class="float-right">
                <a href="#" id="hapus_" class="btn btn-outline-danger">
                    <i data-feather="delete"></i>
                </a>
            </div>
        </div>
        @if ($category->node && !trim(request()->get('keyword')))
            <ul class="todo-task-list media-list hirarki list-group">
                @include('pages._test-list',[
                'categories'=>$category->node
                ])
            </ul>
        @endif
    </li>
@endforeach
