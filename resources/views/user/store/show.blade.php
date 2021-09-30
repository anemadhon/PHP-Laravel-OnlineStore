<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
    <div class="max-w-7xl mx-auto py-3 sm:px-6 lg:px-8">
        <div class="md:grid md:grid-cols-3 md:gap-6">

            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900"> Official {{ $store->name }} Information </h3>
                    <p class="mt-1 text-sm text-gray-600">
                        All about {{ $store->name }} information written here.
                    </p>
                </div>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Owner</label>
                                <label class="block text-xl font-medium text-gray-700">{{ $store->user->name }}</label>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Store Name</label>
                                <label class="block text-xl font-medium text-gray-700">{{ $store->name }}</label>
                            </div>
                            
                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Category</label>
                                <div class="flex items-center text-sm">
                                    <div class="relative w-8 h-8 mr-3 rounded-md md:block">
                                        <img class="object-cover w-full h-full rounded-md" src="{{ asset('storage/'.$store->category->icon) }}" alt="category icons" loading="lazy" />
                                        <div class="absolute inset-0 rounded-md shadow-inner" aria-hidden="true"></div>
                                    </div>
                                    <label class="block text-xl font-medium text-gray-700">{{ $store->category->name }}</label>
                                </div>
                            </div>
                            
                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Status: <strong class="{{ $store->status === 'on' ? 'text-indigo-600' : 'text-red-600' }}"> {{ $store->status === 'on' ? 'Open' : 'Temporarily closed' }} </strong> </label>
                                <label class="block text-sm font-medium text-gray-700">Joined: {{ \Carbon\Carbon::now()->parse($store->created_at)->diffForHumans(). ' | ' .\Carbon\Carbon::create($store->created_at)->toFormattedDateString() }}</label>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-lg">
            <div class="flex justify-between">
                    
                <h3 class="inline-block text-lg font-medium leading-6 text-gray-900">{{ $store->name }}'s Products</h3>
    
                <div class="inline-block">
                    <div class="relative">
                        <form action="{{ route('dashboard.stores.show', $store) }}">
                            <input type="text" name="search" placeholder="Search" class="bg-white rounded-lg text-sm" value="{{ request('search') }}">
                            <button type="submit" class="absolute right-0 top-0 mr-3 mt-3">
                                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
                                    <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
    
            </div>
        </div>
    </div>

    <div class="pb-3 text-gray-600 body-font">
        <div class="container mx-auto">
            <div class="flex flex-wrap justify-center">
                @forelse ($products as $product)
                    <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                        <div class="block relative h-48 rounded overflow-hidden">
                            <a href="{{ route('dashboard.products.show', $product) }}">
                                <img alt="ecommerce" class="object-cover object-center w-full h-full block" src="{{ $product->galleries->count() > 0 ? asset('storage/'.$product->galleries->last()->image) : 'https://ui-avatars.com/api/?name='.urlencode($product->name).'&color=AEAEAE&background=808080' }}">
                            </a>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">{{ $product->category->name }}</h3>
                            <h2 class="text-gray-900 title-font text-lg font-medium">{{ $product->name }}</h2>
                            <p class="text-gray-900 text-md font-medium">Stock: {{ ($product->quantity - $product->purchase_quantity) }}</p>
                            <p class="mt-1">Rp. {{ number_format($product->price, 2) }}</p>
                        </div>
                    </div>
                @empty
                    <h3 class="inline-block pb-3 text-lg font-medium leading-6 text-gray-900">No Products Found</h3>
                @endforelse
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto pb-5 px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            {{ $products->links() }}
        </div>
    </div>

</x-app-layout>
