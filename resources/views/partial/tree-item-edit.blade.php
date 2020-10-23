@if(Auth::user()->isAdmin())
    @if($branch->hasChildren())
        <i class="fas fa-sort"></i>
    @endif
    <i class="fas fa-plus"></i>
    <i class="fas fa-edit"></i>
    <i class="fas fa-ban"></i>
@endif
