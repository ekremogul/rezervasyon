@php
    $menuList = [
        ['name' => 'Genel Bakış', 'url' => route('Home')],
        ['name' => 'Rezervasyonlar', 'url' => route('Reservation.Index')],
        ['name' => 'Tekneler', 'url' => route('Yachts.Index')],
        ['name' => 'Restoranlar', 'url' => route('Restaurant.Index')],
        ['name' => 'Menüler', 'url' => route('Menu.Index')],
        ['name' => 'Konumlar', 'url' => route('Location.Index')],
];
@endphp
<div class="">
    <div x-show="sidebarOpen" class="relative z-50 lg:hidden"
         x-description="Off-canvas menu for mobile, show/hide based on off-canvas menu state." x-ref="dialog"
         aria-modal="true">

        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/80"
             x-description="Off-canvas menu backdrop, show/hide based on off-canvas menu state."></div>


        <div class="fixed inset-0 flex">

            <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                 x-description="Off-canvas menu, show/hide based on off-canvas menu state."
                 class="relative mr-16 flex w-full max-w-xs flex-1" @click.away="sidebarOpen = false">

                <div x-show="sidebarOpen" x-transition:enter="ease-in-out duration-300"
                     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in-out duration-300" x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     x-description="Close button, show/hide based on off-canvas menu state."
                     class="absolute left-full top-0 flex w-16 justify-center pt-5">
                    <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Sidebar component, swap this element with another sidebar if you like -->
                <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4">
                    <div class="flex h-16 shrink-0 items-center">
                        <img class="h-8 w-auto"
                             src="{{ asset('images/logo-full.png') }}"
                             alt="{{ config('app.name') }}">
                    </div>
                    <nav class="flex flex-1 flex-col">
                        <ul role="list" class="flex flex-1 flex-col gap-y-7">
                            <li>
                                <ul role="list" class="-mx-2 space-y-1">
                                    @foreach($menuList as $menu)
                                        <li>
                                            <a href="{{ $menu['url'] }}"
                                               class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold

                                       "

                                            >
                                                {{ $menu['name'] }}
                                            </a>
                                        </li>
                                    @endforeach

                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

        </div>
    </div>

    <div class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-72 lg:flex-col">
        <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6 pb-4">
            <div class="flex h-16 shrink-0 items-center">
                <img class="h-8 w-auto" src="{{ asset('images/logo-full.png') }}"
                     alt="{{ config('app.name') }}">
            </div>
            <nav class="flex flex-1 flex-col">
                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li>
                        <ul role="list" class="-mx-2 space-y-1">
                            @foreach($menuList as $menu)
                                <li>
                                    <a href="{{ $menu['url'] }}"
                                       class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold

                                       "

                                       >
                                        {{ $menu['name'] }}
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
