<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div>
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div id="treestruct">
                            <h1 class="title">Tree Structure</h1>
                            <ul class="wtree">
                                @foreach(\App\Models\TreeStruct::getRoots() as $branch)
                                <li>
                                    <span>{{ $branch->name }} <span class="right">@include('partial.tree-item-edit', $branch)</span></span>
                                    @if($branch->hasChildren())
                                        @include('partial.tree-item', $branch)
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
