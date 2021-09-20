<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
            {{ __('Administrator') }}
            <svg class="h-5 w-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            {{ __('Stores') }}
        </h2>
    </x-slot>

    @if (auth()->user()->role === 'ADMIN' && !auth()->user()->phone_number)
        <div class="max-w-7xl mx-auto py-3 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-1 mx-4 bg-white border-b border-gray-200">
                    hi, {{ auth()->user()->name }}. Cause you are an ADMINISTRATOR, please complete the following data <span class="text-indigo-600 hover:text-indigo-900 underline"><a href="{{ route('profile', ['user' => auth()->user()]) }}" class="underline">here</a></span>
                </div>
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto pt-3 pb-5 sm:px-6 lg:px-8">
        <div class="flex justify-end px-3">

            <div class="inline-block">
                <div class="relative pb-3">
                    <form action="{{ route('admin.stores.index') }}">
                        <input type="text" name="search" placeholder="Search" class="bg-white rounded text-sm" value="{{ request('search') }}">
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
                                        Owner
                                    </th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Joined At
                                    </th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($stores as $store)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $stores->firstItem() + $loop->index }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $store->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                            {{ $store->user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                            {{ $store->status === 'on' ? 'Open' : 'Temporary Closed' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                            {{ \Carbon\Carbon::parse($store->created_at)->toDayDateTimeString() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                            <a href="{{ route('admin.stores.show', $store) }}"><span class="px-2 mr-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-600 hover:text-indigo-900">Show</span></a>
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

                    <div class="text-center mt-5">
                        {{ $stores->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
