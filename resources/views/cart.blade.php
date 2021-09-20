<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-3 sm:px-6 lg:px-8">
        
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">

                        <table class="min-w-full divide-y divide-gray-200 w-full">
                            <thead>
                                <tr>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Product's Name
                                    </th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Seller
                                    </th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Quantity
                                    </th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Price
                                    </th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total
                                    </th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($carts as $cart)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div class="flex items-center text-sm">
                                                <div class="flex -space-x-1 justify-center mr-1">
                                                    @forelse ($cart->product->galleries as $gallery)
                                                        <div class="flex relative w-11 h-11 justify-center items-center ring-2 ring-white">
                                                            <img alt="cart gallery" src="{{ asset('storage/'.$gallery->image) }}" loading="lazy">
                                                        </div>
                                                    @empty
                                                        <div class="flex relative w-10 h-10 justify-center items-center rounded-full ring-2 ring-white">
                                                            <svg class="rounded-full overflow-hidden bg-gray-100 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                            </svg>
                                                        </div>
                                                    @endforelse
                                                </div>
                                                {{ $cart->product->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $cart->product->store->user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $cart->purchase_quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            Rp. {{ number_format($cart->product->price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            Rp. {{ number_format(($cart->total_each_product), 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                            <form class="inline-block" action="{{ route('dashboard.carts.destroy', $cart) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                {!! method_field('delete') . csrf_field() !!}
                                                <input type="submit" class="px-2 mr-2 inline-flex text-xs leading-5 font-semibold rounded-full text-red-600 hover:text-red-900 cursor-pointer" value="Remove">
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
        </div>

    </div>
    
    @if ($carts->count() > 0)
        <div class="max-w-7xl mx-auto pt-2 pb-5 sm:px-6 lg:px-8">
            <div class="md:grid md:grid-cols-3 md:gap-6">

                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900"> {{ auth()->user()->name }} Cart Details</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            All payment and shipping information
                        </p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="username" class="block text-sm font-medium text-gray-700">Shipping to</label>
                                    <label for="username" class="block text-md font-medium text-gray-700">{{ $user_address }}</label>
                                </div>
                                
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="username" class="block text-sm font-medium text-gray-700">Phone</label>
                                    <label for="username" class="block text-md font-medium text-gray-700">{{ auth()->user()->phone_number }}</label>
                                </div>
                                
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="username" class="block text-sm font-medium text-gray-700">Product Insurance Costs</label>
                                    <label for="username" class="block text-md font-medium text-gray-700">Rp. 300,000.00</label>
                                </div>
                                
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="username" class="block text-sm font-medium text-gray-700">Shipping Costs</label>
                                    <label for="username" class="block text-md font-medium text-gray-700">Rp. 15,000.00</label>
                                </div>
                                
                                <div class="col-span-6">
                                    <label for="username" class="block text-sm font-medium text-gray-700">Total Payment</label>
                                    <label for="username" class="block text-xl font-medium text-gray-700"><strong>Rp. {{ number_format(($carts->sum('total_each_product') + 300000 + 15000),2) }}</strong></label>
                                </div>
                                
                                <form action="{{ route('dashboard.users.transactions.store', auth()->user()) }}" method="POST" class="col-span-6">
                                    @csrf
                                    <input type="hidden" name="inscurance_price" value="300000">
                                    <input type="hidden" name="shipping_price" value="15000">
                                    <input type="hidden" name="total_price" value="{{ $carts->sum('total_each_product') + 300000 + 15000 }}">
                                    <div class="text-right">
                                        @error('total_price')
                                            <span class="text-sm text-red-600">Please be nice, and try again {{ $message }}</span>
                                        @enderror
                                        <x-button>
                                            {{ __('Check Out') }}
                                        </x-button>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endif

</x-app-layout>
