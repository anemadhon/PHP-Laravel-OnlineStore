<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-3 sm:px-6 lg:px-8">
        <div class="md:grid md:grid-cols-3 md:gap-6">

            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900"> {{ auth()->user()->name }} Transaction Details</h3>
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
                                <label for="username" class="block text-md font-medium text-gray-700">Rp. {{ number_format($transaction->inscurance_price,2) }}</label>
                            </div>
                            
                            <div class="col-span-6 sm:col-span-3">
                                <label for="username" class="block text-sm font-medium text-gray-700">Shipping Costs</label>
                                <label for="username" class="block text-md font-medium text-gray-700">Rp. {{ number_format($transaction->shipping_price,2) }}</label>
                            </div>
                            
                            <div class="col-span-6 sm:col-span-3">
                                <label for="username" class="block text-sm font-medium text-gray-700">Payment Status</label>
                                <label for="username" class="block text-md font-medium text-gray-700">{{ $transaction->status }}</label>
                            </div>
                            
                            <div class="col-span-6 sm:col-span-3">
                                <label for="username" class="block text-sm font-medium text-gray-700">Total Payment</label>
                                <label for="username" class="block text-md font-medium text-gray-700">Rp. {{ number_format($transaction->total_price,2) }}</label>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="max-w-7xl mx-auto pt-3 pb-5 sm:px-6 lg:px-8">
        
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">

                        <table class="min-w-full divide-y divide-gray-200 w-full">
                            <thead>
                                <tr>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Detail Number
                                    </th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Product Name
                                    </th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Seller
                                    </th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Shipping Status
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
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($transaction->details->load(['products', 'stores', 'products.galleries']) as $details)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $details->unique_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div class="flex items-center text-sm">
                                                <div class="flex -space-x-1 justify-center mr-1">
                                                    @forelse ($details->products->galleries as $gallery)
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
                                                {{ $details->products->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $details->stores->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $details->shipping_status }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $details->purchase_quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            Rp. {{ number_format($details->purchase_price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            Rp. {{ number_format(($details->total_each_product), 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="border text-center p-5">
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

</x-app-layout>
