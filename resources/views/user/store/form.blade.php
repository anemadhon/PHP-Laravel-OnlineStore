<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
            {{ __('Store') }}
            <svg class="h-5 w-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            {{ isset($store) ? __('Update') : __('Create') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto pt-3 pb-5 sm:px-6 lg:px-8">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900"> {{ isset($store) ? __('Store Update') : __('Store Create') }} </h3>
                    <p class="mt-1 text-sm text-gray-600">
                        This information will be your Store Information.
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ isset($store) ? route('dashboard.stores.update', $store) : route('dashboard.stores.store') }}" method="POST">
                    @csrf
                    @if (isset($store))
                        @method('PUT')
                    @endif
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" name="name" value="{{ old('name', (isset($store) ? $store->name : '')) }}" id="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('name')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                                    <select name="category_id" id="category_id" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ isset($store) && $store->category_id === $category->id ? 'selected' : '' }} >{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="col-span-6">
                                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Status</label>
                                    <div class="main flex rounded-md overflow-hidden mt-1 select-none">
                                        <label class="flex radio p-2 cursor-pointer">
                                            <input class="my-auto transform scale-125" type="radio" name="status" value="on" {{ isset($store) && $store->status === 'on' ? 'checked' : '' }} />
                                            <div class="title px-2">Open</div>
                                        </label>
                                      
                                        <label class="flex radio p-2 cursor-pointer">
                                            <input class="my-auto transform scale-125" type="radio" name="status" value="off" {{ isset($store) && $store->status === 'off' ? 'checked' : '' }}/>
                                            <div class="title px-2">Temporarily closed</div>
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <x-button class="ml-3">
                                {{ isset($store) ? __('Update') : __('Create') }}
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
