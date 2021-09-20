<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
            {{ __('Administrator') }}
            <svg class="h-5 w-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            {{ "@$user->username Personal Page" }}
        </h2>
    </x-slot>
    
    <div class="max-w-7xl mx-auto pt-3 pb-5 sm:px-6 lg:px-8">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900"> {{ "@$user->username Information" }} </h3>
                    <p class="mt-1 text-sm text-gray-600">
                        This information will be displayed publicly so be careful what you share.
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <label class="block text-xl font-medium text-gray-700">{{ $user->name }}</label>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Username</label>
                                <label class="block text-xl font-medium text-gray-700">{{ $user->username }}</label>
                            </div>
                
                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <label class="block text-xl font-medium text-gray-700">{{ $user->email }}</label>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <label class="block text-xl font-medium text-gray-700">{{ $user->phone_number }}</label>
                            </div>
                            
                            @if ($user->has_store)
                                <div class="col-span-6">
                                    <label class="block text-sm font-medium text-gray-700">Store</label>
                                    <p class="block text-md font-medium text-gray-700"><a href="{{ route('admin.stores.show', $user->store) }}">{{ $user->store->name }}</a></p>
                                </div>
                            @endif

                            @if ($user->role === 'USER')
                                @php
                                    $notComplated = (
                                        !$user->address_one || 
                                        !$user->address_two || 
                                        !$user->provincy ||
                                        !$user->regency ||
                                        !$user->zip_code ||
                                        !$user->country ||
                                        !$user->phone_number
                                    )
                                @endphp
                                <div class="col-span-6">
                                    <label class="block text-sm font-medium text-gray-700">Address</label>
                                    <p class="block text-md font-medium text-gray-700">{{ $notComplated ? '-' : "$user->address_one ( secondary address: $user->address_two ), $user->regency, $user->provincy, $user->zip_code, $user->country" }}</p>
                                </div>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
