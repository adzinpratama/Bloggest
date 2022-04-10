@foreach ($categories as $category)
    <li id="{{ $category->id }}" class="list-group-item li-parent"><a class="text-truncate list-title"
            href="#">{{ $category->title }}</a>
        <div class="float-right">
            <a href="#" class="btn btn-icon btn-info waves-effect waves-float waves-light"
                onclick="show({{ $category->id }})">
                <i data-feather="eye"></i>
            </a>
            <a href="#" class="btn btn-icon btn-primary waves-effect waves-float waves-light"
                onclick="edit({{ $category->id }})">
                <i data-feather="edit"></i>
            </a>
            <a href="#" onclick="destroy({{ $category->id }})"
                class="btn btn-icon btn-flat-danger waves-effect waves-light">
                <i data-feather="delete"></i>
            </a>
        </div>
        @if ($category->has('node') && !trim(request()->get('keyword')))
            <ul class="list-group hirarki kategori">
                @include('pages._admin.category._category-list',[
                'categories'=>$category->node
                ])
            </ul>
        @endif
    </li>
@endforeach
