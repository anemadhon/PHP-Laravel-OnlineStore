<x-guest-layout>

    <div class="container py-3 mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:w-4/5 mx-auto flex flex-wrap">
            
            <img alt="ecommerce" class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded" src="{{ $product->galleries->count() > 0 ? asset('storage/'.$product->galleries->last()->image) : 'https://ui-avatars.com/api/?name='.urlencode($product->name).'&color=AEAEAE&background=808080' }}">
            
            <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                <h2 class="text-sm title-font text-gray-500 tracking-widest">{{ $product->category->name }}</h2>
                <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">{{ $product->name }}</h1>
                <a href="{{ route('stores.details', $product->store) }}">
                    <p class="text-gray-900 text-xs font-medium pt-1 pb-2">product by: {{ $product->store->name }}</p>
                </a>

                <div class="hidden sm:block">
                    <div class="py-2">
                        <div class="border-t border-gray-200"></div>
                    </div>
                </div>
            
                <p class="leading-relaxed">
                    {{ $product->description }}
                </p>

                <form action="{{ route('dashboard.products.carts.store', $product) }}" method="POST">
                    @csrf
                    <div class="flex items-center border-b-2 border-gray-100 py-3">
                        <div class="flex">
                            <span class="mr-3">in stock:</span>
                            <span class="mr-3">{{ ($product->quantity - $product->purchase_quantity) }}</span>
                        </div>
                        <div class="flex ml-6 items-center">
                            <span class="mr-3">Quantity</span>
                                <input type="number" name="purchase_quantity" value="{{ old('purchase_quantity', '') }}" id="purchase_quantity" class="relative focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md" min="1" max="{{ ($product->quantity - $product->purchase_quantity) }}">
                                @error('purchase_quantity')
                                    <span class="ml-2 text-sm text-red-600">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>

                    <div class="hidden sm:block">
                        <div>
                            <div class="border-t border-gray-200"></div>
                        </div>
                    </div>
                
                    <div class="flex pt-2">
                        <span class="title-font font-medium text-2xl text-gray-900">Rp. {{ number_format($product->price, 2) }}</span>
                        <x-button class="flex ml-auto">
                            {{ __('Add to Cart') }}
                        </x-button>
                    </div>
                </form>

            </div>

        </div>
    </div>

</x-guest-layout>
