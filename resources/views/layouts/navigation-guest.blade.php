<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('products') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>
                @php
                    $activeProduct = request()->routeIs('products') || request()->routeIs('products.*') || request()->routeIs('stores.*');
                @endphp
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('products')" :active="$activeProduct">
                        {{ __('Products') }}
                    </x-nav-link>
                </div>
            </div>
            
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="origin-top-right right-0 w-48">
                    @if (Route::has('login'))
                        <div class="relative hidden fixed top-0 px-6 py-4 sm:block">
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('products')" :active="$activeProduct">
                {{ __('Products') }}
            </x-responsive-nav-link>
        </div>

        @if (Route::has('login'))
            <!-- Responsive Settings Options -->
            <div class="pb-1 border-t border-gray-200">
                <div class="flex items-center px-4">
                    <div class="font-medium text-base text-gray-800">
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>
                    </div>
                </div>
            </div>

            @if (Route::has('register'))
                <div class="pb-1 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div class="font-medium text-base text-gray-800">
                            <a href="{{ route('register') }}" class="text-sm text-gray-700 underline">Register</a>
                        </div>
                    </div>
                </div>
            @endif
        @endif

    </div>
</nav>
