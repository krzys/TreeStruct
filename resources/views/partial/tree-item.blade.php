<ul>
    @foreach($branch->children as $branch)
        <li>
            <span>{{ $branch->name }} <span class="right">@include('partial.tree-item-edit', $branch)</span></span>
            @if($branch->hasChildren())
                @include('partial.tree-item', $branch)
            @endif
        </li>
    @endforeach
</ul>
