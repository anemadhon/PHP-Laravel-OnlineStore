<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    
    @php
        $notComplated = (
            !auth()->user()->address_one || 
            !auth()->user()->address_two || 
            !auth()->user()->provincy ||
            !auth()->user()->regency ||
            !auth()->user()->zip_code ||
            !auth()->user()->country ||
            !auth()->user()->phone_number
        )
    @endphp

    @if (auth()->user()->role !== 'ADMIN' && $notComplated)
        <div class="max-w-7xl mx-auto py-3 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-1 mx-4 bg-white border-b border-gray-200">
                    hi, {{ auth()->user()->name }}. You have not completed your profile. Complate <span class="text-indigo-600 hover:text-indigo-900 underline"><a href="{{ route('profile', ['user' => auth()->user()]) }}" class="underline">here</a></span>
                </div>
            </div>
        </div>
    @endif
    
    @if (auth()->user()->role !== 'ADMIN' && auth()->user()->has_store === 0)
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 {{ (auth()->user()->role !== 'ADMIN' && $notComplated) ? '' : 'pt-3' }}">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-1 mx-4 bg-white border-b border-gray-200">
                    hi, {{ auth()->user()->name }}. Do you want to open a store ? Open <span class="text-indigo-600 hover:text-indigo-900 underline"><a href="{{ route('dashboard.stores.create') }}" class="underline">here</a></span>
                </div>
            </div>
        </div>
    @endif
    
    <div class="max-w-7xl mx-auto py-3 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-1 mx-4 bg-white border-b border-gray-200">
                <div class="flex items-center">
                    <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="-mt-px w-8 h-8 sm:w-5 sm:h-5 text-gray-400">
                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
    
                    <p class="ml-1">Your Last Transactions: 
                        @if ($last_transaction)
                            <span>
                                <strong>{{ $last_transaction->unique_number }} </strong>on {{ \Carbon\Carbon::parse($last_transaction->created_at)->toDayDateTimeString() }}. See details <a href="{{ route('dashboard.users.transactions.show', [auth()->user(), $last_transaction]) }}" class="underline">here</a>
                            </span>
                        @endif
                    </p>
                </div> 
            </div>
        </div>
    </div>
    
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-5">
        <div class="mt-3 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="p-4">
                    <div class="flex items-center">
                        <svg stroke="currentColor" class="w-8 h-8 text-gray-500" viewBox="0 0 20 20">
							<path d="M14.467,1.771H5.533c-0.258,0-0.47,0.211-0.47,0.47v15.516c0,0.414,0.504,0.634,0.802,0.331L10,13.955l4.136,4.133c0.241,0.241,0.802,0.169,0.802-0.331V2.241C14.938,1.982,14.726,1.771,14.467,1.771 M13.997,16.621l-3.665-3.662c-0.186-0.186-0.479-0.186-0.664,0l-3.666,3.662V2.711h7.994V16.621z"></path>
						</svg>
                        <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">Your Favorite Categories: <span><strong>{{ $favorite_category ? $favorite_category->category->name : '' }}</strong></span></div>
                    </div>
                </div>

                <div class="p-4 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                    <div class="flex items-center">
                        <svg stroke="currentColor" class="w-8 h-8 text-gray-500" viewBox="0 0 20 20">
							<path d="M17.638,6.181h-3.844C13.581,4.273,11.963,2.786,10,2.786c-1.962,0-3.581,1.487-3.793,3.395H2.362c-0.233,0-0.424,0.191-0.424,0.424v10.184c0,0.232,0.191,0.424,0.424,0.424h15.276c0.234,0,0.425-0.191,0.425-0.424V6.605C18.062,6.372,17.872,6.181,17.638,6.181 M13.395,9.151c0.234,0,0.425,0.191,0.425,0.424S13.629,10,13.395,10c-0.232,0-0.424-0.191-0.424-0.424S13.162,9.151,13.395,9.151 M10,3.635c1.493,0,2.729,1.109,2.936,2.546H7.064C7.271,4.744,8.506,3.635,10,3.635 M6.605,9.151c0.233,0,0.424,0.191,0.424,0.424S6.838,10,6.605,10c-0.233,0-0.424-0.191-0.424-0.424S6.372,9.151,6.605,9.151 M17.214,16.365H2.786V7.029h3.395v1.347C5.687,8.552,5.332,9.021,5.332,9.575c0,0.703,0.571,1.273,1.273,1.273c0.702,0,1.273-0.57,1.273-1.273c0-0.554-0.354-1.023-0.849-1.199V7.029h5.941v1.347c-0.495,0.176-0.849,0.645-0.849,1.199c0,0.703,0.57,1.273,1.272,1.273s1.273-0.57,1.273-1.273c0-0.554-0.354-1.023-0.849-1.199V7.029h3.395V16.365z"></path>
						</svg>
                        <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">Your Favorite Store: <span><strong>{{ $favorite_store ? $favorite_store->name : '' }}</strong></span></div>
                    </div>
                </div>

                @if (auth()->user()->has_store && $store_revenue)
                    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <svg stroke="currentColor" viewBox="0 0 20 20" class="w-8 h-8 text-gray-500">
                                <path d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z"></path>
                            </svg>
                            <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">Your Active Customer: <span><strong>{{ $store_active_customer ? $store_active_customer->name : '' }}</strong></span></div>
                        </div>
                    </div>

                    <div class="p-4 border-t border-gray-200 dark:border-gray-700 md:border-l">
                        <div class="flex items-center">
                            <svg stroke="currentColor" class="w-8 h-8 text-gray-500" viewBox="0 0 20 20">
                                <path d="M15.94,10.179l-2.437-0.325l1.62-7.379c0.047-0.235-0.132-0.458-0.372-0.458H5.25c-0.241,0-0.42,0.223-0.373,0.458l1.634,7.376L4.06,10.179c-0.312,0.041-0.446,0.425-0.214,0.649l2.864,2.759l-0.724,3.947c-0.058,0.315,0.277,0.554,0.559,0.401l3.457-1.916l3.456,1.916c-0.419-0.238,0.56,0.439,0.56-0.401l-0.725-3.947l2.863-2.759C16.388,10.604,16.254,10.22,15.94,10.179M10.381,2.778h3.902l-1.536,6.977L12.036,9.66l-1.655-3.546V2.778z M5.717,2.778h3.903v3.335L7.965,9.66L7.268,9.753L5.717,2.778zM12.618,13.182c-0.092,0.088-0.134,0.217-0.11,0.343l0.615,3.356l-2.938-1.629c-0.057-0.03-0.122-0.048-0.184-0.048c-0.063,0-0.128,0.018-0.185,0.048l-2.938,1.629l0.616-3.356c0.022-0.126-0.019-0.255-0.11-0.343l-2.441-2.354l3.329-0.441c0.128-0.017,0.24-0.099,0.295-0.215l1.435-3.073l1.435,3.073c0.055,0.116,0.167,0.198,0.294,0.215l3.329,0.441L12.618,13.182z"></path>
                            </svg>
                            <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">Your Revenue: <span><strong>Rp. {{ number_format($store_revenue, 2) }}</strong></span></div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
