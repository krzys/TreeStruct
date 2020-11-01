<div>
    <div id="treestruct">
        <h1 class="title">Tree Structure</h1>
        <ul class="wtree">
            @foreach($roots as $branch)
                <li data-id="{{ $branch->id }}">
                    <span>{{ $branch->name }} <span class="right">@include('partial.tree-item-edit', $branch)</span></span>
                    @if($branch->hasChildren())
                        @include('partial.tree-item', $branch)
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
    <div class="@if($mode == null)hidden @endif fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        @switch($mode)
                            @case('delete')
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fa fa-exclamation-triangle text-red-600"></i>
                            </div>
                            @break
                            @case('add')
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fa fa-plus text-green-600"></i>
                            </div>
                            @break
                            @case('edit')
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-gray-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fa fa-edit text-gray-600 ml-1"></i>
                            </div>
                            @break
                        @endswitch
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                @switch($mode)
                                    @case('delete')
                                    Delete "{{ $fullName }}"
                                    @break
                                    @case('add')
                                    Add new element
                                    @break
                                    @case('edit')
                                    Edit "{{ $fullName }}"
                                    @break
                                @endswitch
                            </h3>
                            @switch($mode)
                                @case('delete')
                                <div class="mt-2">
                                    <p class="text-sm leading-5 text-gray-500">
                                        Are you sure you want to delete this item? All children will be also deleted. This action cannot be undone.
                                    </p>
                                </div>
                                @break
                                @case('add')
                                @case('edit')
                                <div class="w-full">
                                    <div class="bg-white rounded mr-4 pt-6 mb-4">
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                                Name
                                            </label>
                                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('name') border-red-600 @enderror" type="text" id="name" name="name" placeholder="Enter Name" wire:model="name">
                                            @error('name') <p class="text-red-500 text-xs italic">{{ $message }}</p>@enderror
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2" for="parent">
                                                Parent
                                            </label>
                                            <div class="relative">
                                                <select wire:model="parent" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="parent" name="parent">
                                                    <option value="">None (set as root node)</option>
                                                    @foreach($elements as $option)
                                                        <option value="{{ $option->id }}">{{ $option->getFullName() }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                                </div>
                                            </div>
                                            @error('parent') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                @break
                            @endswitch
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        @switch($mode)
                            @case('delete')
                            <button wire:click="delete({{ $element_id }})" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Delete
                            </button>
                            @break
                            @case('add')
                            <button wire:click="add()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Add
                            </button>
                            @break
                            @case('edit')
                            <button wire:click="edit({{ $element_id }})" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-gray-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Edit
                            </button>
                            @break
                        @endswitch
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                      <button wire:click="cancel()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        Cancel
                      </button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
