<ul>
    @foreach($branch->children as $branch)
        <li data-id="{{ $branch->id }}">
            <span>{{ $branch->name }} <span class="right">@include('partial.tree-item-edit', $branch)</span></span>
            @if($branch->hasChildren())
                @include('partial.tree-item', $branch)
            @endif
        </li>
    @endforeach
</ul>
