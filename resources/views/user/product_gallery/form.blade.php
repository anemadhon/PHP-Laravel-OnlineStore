<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
            {{ __('Product Galley') }}
            <svg class="h-5 w-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            {{ __('Create') }}
        </h2>
    </x-slot>
    
    <div class="max-w-7xl mx-auto py-3 sm:px-6 lg:px-8">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900"> {{ __('Product Gallery Create') }} </h3>
                    <p class="mt-1 text-sm text-gray-600">
                        All of <strong> {{ $product->name }} </strong> Single Gallery.
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('dashboard.products.galleries.store', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6">
                                    <label class="block text-sm font-medium text-gray-700">Product Name</label>
                                    <label class="block text-lg font-medium text-gray-700"> {{ $product->name }} </label>
                                </div>

                                <div class="col-span-6">
                                    <label class="block text-sm font-medium text-gray-700">
                                        Image
                                    </label>
                                    <div class="mt-1 flex items-center">
                                        <svg class="inline-block h-11 w-12 rounded-full overflow-hidden bg-gray-100 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        <input type="file" name="image" id="image" class="appearance-none ml-5 py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded" required>
                                        @error('image')
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>

                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        @error('product_id')
                            <p class="text-sm text-red-600">Please be nice and try agains</p>
                        @enderror

                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <x-button class="ml-3">
                                {{ __('Create') }}
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
