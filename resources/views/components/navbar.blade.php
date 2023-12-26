<div class="h-14 flex justify-between items-center px-4 shadow">
    <div class="flex items-center">
        <button class="cursor-pointer lg:hidden" @click="sidebarOpen = true">
            <x-heroicon-o-bars-4  class="w-8 h-8"/>
        </button>
    </div>
    <div class="flex items-center justify-end gap-x-2">
        <x-usermenu />
    </div>
</div>
