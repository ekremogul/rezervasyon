<div x-data="{usermenu: false}"
     @keydown.escape.stop="usermenu = false;" @click.away="usermenu = false"
     class="relative">
    <button type="button" class="-m-1.5 flex items-center p-1.5" id="user-menu-button"
            x-ref="button" @click="usermenu = ! usermenu" aria-expanded="false" aria-haspopup="true"
            x-bind:aria-expanded="usermenu.toString()">
        <span class="sr-only">Open user menu</span>
        <img class="h-8 w-8 rounded-full bg-gray-50"
             src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=2&amp;w=256&amp;h=256&amp;q=80"
             alt="">
        <span class="hidden lg:flex lg:items-center">
                  <span class="ml-4 text-sm font-semibold leading-6 text-gray-900" aria-hidden="true">{{ auth()->user()->name }}</span>
                  <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
  <path fill-rule="evenodd"
        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
        clip-rule="evenodd"></path>
</svg>
                </span>
    </button>

    <div x-show="usermenu" x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
         x-ref="menu-items" x-description="Dropdown menu, show/hide based on menu state."
          role="menu" aria-orientation="vertical"
         aria-labelledby="user-menu-button" tabindex="-1"
         @keydown.tab="usermenu = false" @keydown.enter.prevent="usermenu = false;"
         @keyup.space.prevent="usermenu = false;">
        <a href="#" class="block px-3 py-1 text-sm leading-6 text-gray-900" x-state:on="Active"
           x-state:off="Not Active"  role="menuitem"
           tabindex="-1" id="user-menu-item-0"
           @click="usermenu = false;">Your profile</a>
        <a href="#" class="block px-3 py-1 text-sm leading-6 text-gray-900"
           role="menuitem" tabindex="-1"
           id="user-menu-item-1"
           @click="usermenu = false;">Sign out</a>

    </div>

</div>
