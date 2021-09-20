<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
            {{ __('Product') }}
            <svg class="h-5 w-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            {{ isset($product) ? __('Update') : __('Create') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-3 sm:px-6 lg:px-8">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900"> {{ isset($product) ? __('Product Update') : __('Product Create') }} </h3>
                    <p class="mt-1 text-sm text-gray-600">
                        All of <strong> {{ $store->name }} </strong> single products information.
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ isset($product) ? route('dashboard.products.update', $product) : route('dashboard.products.store') }}" method="POST">
                    @csrf
                    @if (isset($product))
                        @method('PUT')
                    @endif
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" name="name" value="{{ old('name', (isset($product) ? $product->name : '')) }}" id="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('name')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="col-span-6">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="description" id="description" cols="30" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description', (isset($product) ? $product->description : '')) }}</textarea>
                                    @error('description')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                                    <input type="text" name="quantity" value="{{ old('quantity', (isset($product) ? ($product->quantity - $product->purchase_quantity) : '')) }}" id="quantity" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('quantity')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                    <input type="text" name="price" value="{{ old('price', (isset($product) ? $product->price : '')) }}" id="price" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('price')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                                    <label for="category_id" class="block text-lg font-medium text-gray-700">{{ $store->category->name }}</label>
                                    <label class="block text-sm font-small text-gray-700">depens on {{ $store->name }}'s category type</label>
                                    @error('category_id')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <input type="hidden" name="store_id" value="{{ $store->id }}">
                        <input type="hidden" name="category_id" value="{{ $store->category_id }}">

                        @if ($errors->get('store_id') || $errors->get('category_id'))
                            <p class="text-sm text-red-600">Please be nice and try agains</p>
                        @endif

                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <x-button class="ml-3">
                                {{ isset($product) ? __('Update') : __('Create') }}
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="pt-3 pb-5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-center -m-4">
                @if (isset($galleries))
                    @forelse ($galleries as $gallery)
                        <div class="xl:w-1/4 md:w-1/2 p-4">
                            <div class="bg-gray-100 rounded-lg">
                                <img class="h-40 w-full rounded object-cover object-center mb-6" src="{{ asset('storage/'.$gallery->image) }}" alt="product gallery">
                                <form class="text-right" action="{{ route('dashboard.products.galleries.destroy', [$product, $gallery]) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    {!! method_field('delete') . csrf_field() !!}
                                    <input type="submit" class="px-2 text-xs leading-5 font-semibold rounded-full text-red-600 hover:text-red-900 cursor-pointer" value="Delete">
                                </form>
                            </div>
                        </div>
                    @empty
                        <h3 class="inline-block pb-3 text-lg font-medium leading-6 text-gray-900">No Gallery Found for {{ $product->name }}</h3>
                    @endforelse
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
