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
                                        Order Number
                                    </th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total Payment
                                    </th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($transactions as $transaction)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                            {{ $transaction->unique_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                            {{ $transaction->status }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            Rp. {{ number_format(($transaction->total_price), 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            {{ \Carbon\Carbon::parse($transaction->created_at)->toDayDateTimeString() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                            <a href="{{ route('dashboard.users.transactions.show', [auth()->user(), $transaction]) }}"><span class="px-2 mr-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-600 hover:text-indigo-900">Show Detail</span></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="border text-center p-5">
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
