<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-3 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-1 mx-4 bg-white border-b border-gray-200">
                Hi, {{ auth()->user()->name }}. Welcome back to your store <strong> {{ $store->name }} </strong>, want to add a product ? click <a href="{{ route('dashboard.products.create') }}" class="text-indigo-600 hover:text-indigo-900 underline">here</a>
            </div>
        </div>
    </div>
    
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
                                <label for="username" class="block text-sm font-medium text-gray-700">Store Name</label>
                                <label for="username" class="block text-xl font-medium text-gray-700">{{ $store->name }}</label>
                            </div>
                            
                            <div class="col-span-6 sm:col-span-3">
                                <label for="email" class="block text-sm font-medium text-gray-700">Category</label>
                                <div class="flex items-center text-sm">
                                    <div class="relative w-8 h-8 mr-3 rounded-md md:block">
                                        <img class="object-cover w-full h-full rounded-md" src="{{ asset('storage/'.$store->category->icon) }}" alt="category icons" loading="lazy" />
                                        <div class="absolute inset-0 rounded-md shadow-inner" aria-hidden="true"></div>
                                    </div>
                                    <label for="email" class="block text-xl font-medium text-gray-700">{{ $store->category->name }}</label>
                                </div>
                            </div>
                            
                            <div class="col-span-6 sm:col-span-3">
                                <label for="username" class="block text-sm font-medium text-gray-700">Status: <strong class="{{ $store->status === 'on' ? 'text-indigo-600' : 'text-red-600' }}"> {{ $store->status === 'on' ? 'Open' : 'Temporarily closed' }} </strong> </label>
                                <label for="username" class="block text-sm font-medium text-gray-700">Joined: {{ \Carbon\Carbon::now()->parse($store->created_at)->diffForHumans(). ' | ' .\Carbon\Carbon::create($store->created_at)->toFormattedDateString() }}</label>
                            </div>
                            
                            <div class="col-span-6 sm:col-span-3 pt-5">
                                <label for="username" class="block text-sm font-medium text-gray-700">Want to change your store information ? click <a href="{{ route('dashboard.stores.edit', ['store' => $store]) }}" class="text-indigo-600 hover:text-indigo-900 underline">here</a> </label>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto pt-3 pb-5 sm:px-6 lg:px-8">
        <div class="flex justify-between px-4">
            
            <h3 class="inline-block pb-3 text-lg font-medium leading-6 text-gray-900">{{ $store->name }}'s Products</h3>

            <div class="inline-block">
                <div class="relative pb-3">
                    <form action="{{ route('dashboard.stores.index') }}">
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

        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">

                        <table class="min-w-full divide-y divide-gray-200 w-full">
                            <thead>
                                <tr>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        #
                                    </th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Quantity
                                    </th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Price
                                    </th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($products as $product)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $products->firstItem() + $loop->index }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div class="flex items-center text-sm">
                                                <div class="flex -space-x-1 justify-center mr-1">
                                                    @forelse ($product->galleries as $gallery)
                                                        <div class="flex relative w-11 h-11 justify-center items-center ring-2 ring-white">
                                                            <img alt="product gallery" src="{{ asset('storage/'.$gallery->image) }}" loading="lazy">
                                                        </div>
                                                    @empty
                                                        <div class="flex relative w-10 h-10 justify-center items-center rounded-full ring-2 ring-white">
                                                            <svg class="rounded-full overflow-hidden bg-gray-100 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                            </svg>
                                                        </div>
                                                    @endforelse
                                                </div>
                                                {{ $product->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $product->description }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ ($product->quantity - $product->purchase_quantity) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            Rp. {{ number_format($product->price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                            @if ($product->galleries->count() < 4)
                                                <a href="{{ route('dashboard.products.galleries.create', $product) }}"><span class="px-2 mr-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-600 hover:text-green-900">Add Gallery</span></a>
                                            @endif
                                            <a href="{{ route('dashboard.products.edit', $product) }}"><span class="px-2 mr-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-600 hover:text-indigo-900">Edit</span></a>
                                            <form class="inline-block" action="{{ route('dashboard.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                {!! method_field('delete') . csrf_field() !!}
                                                <input type="submit" class="px-2 mr-2 inline-flex text-xs leading-5 font-semibold rounded-full text-red-600 hover:text-red-900 cursor-pointer" value="Delete">
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="border text-center p-5">
                                            No Data Found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
    
                </div>
            </div>

            <div class="pt-5 px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
