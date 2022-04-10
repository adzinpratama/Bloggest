<ul>
    @foreach ($categories as $category)
        <li>
            <a href="#">$category->title</a>
            @if ($category->node)
                @include('pages._admin.post._category_list',[
                'categories'=>$category->node
                ])
            @endif
        </li>
    @endforeach
</ul>
