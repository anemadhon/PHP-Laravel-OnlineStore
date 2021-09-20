<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ "@$user->username Setting" }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto pt-3 pb-5 sm:px-6 lg:px-8">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900"> {{ "@$user->username Secret Password" }} </h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Be careful what you type.
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('reset.password.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6">
                                    <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                    <input type="password" name="current_password" value="" id="current_password" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('current_password')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="col-span-6">
                                    <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                                    <input type="password" name="password" value="" id="password" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('password')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="col-span-6">
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">New Password Confirmation</label>
                                    <input type="password" name="password_confirmation" value="" id="password_confirmation" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('password_confirmation')
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

                            </div>
                        </div>

                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <x-button class="ml-3">
                                {{ __('Reset Password') }}
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
