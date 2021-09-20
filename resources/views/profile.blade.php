<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ "@$user->username Personal Page" }}
        </h2>
    </x-slot>
    
    <div class="max-w-7xl mx-auto py-3 sm:px-6 lg:px-8">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900"> {{ "@$user->username Profile" }} </h3>
                    <p class="mt-1 text-sm text-gray-600">
                        This information will be displayed publicly so be careful what you share.
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('profile', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" id="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('name')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" id="phone_number" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('phone_number')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                                    <label for="username" class="block text-xl font-medium text-gray-700">{{ $user->username }}</label>
                                </div>
                    
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <label for="email" class="block text-xl font-medium text-gray-700">{{ $user->email }}</label>
                                </div>

                                <div class="col-span-6">
                                    <label class="block text-sm font-medium text-gray-700">
                                        Avatar
                                    </label>
                                    <div class="mt-1 flex items-center">
                                        @if (isset($user) && $user->profile_photo_path)
                                            <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                                <img src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="users avatar" loading="lazy">
                                            </span>
                                        @endif
                                        @if (!isset($user) || $user->profile_photo_path === null)
                                            <svg class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        @endif
                                        <input type="file" name="profile_photo_path" disabled value="{{ old('profile_photo_path', '') }}" id="avatar" class="appearance-none ml-5 py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded">
                                        @error('profile_photo_path')
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <x-button class="ml-3">
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="hidden sm:block" aria-hidden="true">
        <div class="py-3">
            <div class="border-t border-gray-200"></div>
        </div>
    </div>

    @if ($user->role === 'USER')
        <div class="max-w-7xl mx-auto pt-2 pb-5 sm:px-6 lg:px-8">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900"> {{ "@$user->username Personal Information" }} </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            This information will be displayed publicly so be careful what you share.
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="{{ route('personal.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6">
                                        <label for="address_one" class="block text-sm font-medium text-gray-700">Primary Address</label>
                                        <textarea name="address_one" id="address_one" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" cols="30" rows="3">{{ old('address_one', $user->address_one) }}</textarea>
                                        @error('address_one')
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-span-6">
                                        <label for="address_two" class="block text-sm font-medium text-gray-700">Secondary Address</label>
                                        <textarea name="address_two" id="address_two" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" cols="30" rows="3">{{ old('address_two', $user->address_two) }}</textarea>
                                        @error('address_two')
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="provincy" class="block text-sm font-medium text-gray-700">Provincy</label>
                                        <input type="text" name="provincy" value="{{ old('provincy', $user->provincy) }}" id="provincy" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('provincy')
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="regency" class="block text-sm font-medium text-gray-700">Regency</label>
                                        <input type="text" name="regency" value="{{ old('regency', $user->regency) }}" id="regency" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('regency')
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="zip_code" class="block text-sm font-medium text-gray-700">ZIP Code</label>
                                        <input type="text" name="zip_code" value="{{ old('zip_code', $user->zip_code) }}" id="zip_code" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('zip_code')
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                        <input type="text" name="country" value="{{ old('country', $user->country) }}" id="country" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('country')
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <x-button class="ml-3">
                                    {{ __('Update') }}
                                </x-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
