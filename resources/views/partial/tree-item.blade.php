<ul>
    @foreach($branch->children as $branch)
        <li>
            <span>{{ $branch->name }}</span>
            @if($branch->hasChildren())
                @include('partial.tree-item', $branch)
            @endif
        </li>
    @endforeach
</ul>
