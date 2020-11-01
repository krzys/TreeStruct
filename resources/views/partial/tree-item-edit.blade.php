@if(Auth::user()->isAdmin())
{{--    @if($branch->hasChildren())--}}
{{--        <i class="fas fa-sort"></i>--}}
{{--    @endif--}}
    <i class="fas fa-plus text-green-800" wire:click="add({{ $branch->id }})"></i>
    <i class="fas fa-edit" wire:click="edit({{ $branch->id }})"></i>
    <i class="fas fa-ban text-red-800" wire:click="delete({{ $branch->id }})"></i>
@endif
