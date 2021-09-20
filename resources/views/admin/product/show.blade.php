<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
            {{ __('Administrator') }}
            <svg class="h-5 w-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            {{ $product->name }} Details
        </h2>
    </x-slot>

    <div class="container py-3 px-4 sm:px-6 mx-auto">
        <div class="lg:w-4/5 mx-auto flex flex-wrap">
            
            <img alt="ecommerce" class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded" src="{{ asset('storage/'.$product->galleries->last()->image) }}">
            
            <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                <h2 class="text-sm title-font text-gray-500 tracking-widest">{{ $product->category->name }}</h2>
                <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">{{ $product->name }}</h1>
                <a href="{{ route('admin.stores.show', $product->store) }}">
                    <p class="text-gray-900 text-xs font-medium">product by: {{ $product->store->name }}</p>
                </a>
            
                <div class="hidden sm:block">
                    <div class="py-2">
                        <div class="border-t border-gray-200"></div>
                    </div>
                </div>
            
                <p class="leading-relaxed">
                    {{ $product->description }}
                </p>
            
                <div class="flex items-center border-b-2 border-gray-100 py-3">
                    <div class="flex">
                        <span class="mr-3">in stock:</span>
                        <span class="mr-3">{{ ($product->quantity - $product->purchase_quantity) }}</span>
                    </div>
                </div>

                <div class="hidden sm:block">
                    <div>
                        <div class="border-t border-gray-200"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
