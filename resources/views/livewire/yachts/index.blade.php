<div class="flex flex-col">
    <div class="py-4 flex items-center justify-between">
        <h3 class="font-semibold text-gray-950">Tekne Listesi</h3>
        <div class="flex items-center gap-4">
            {{ $this->createAction }}
        </div>
    </div>
    {{ $this->table }}

    <x-filament-actions::modals />
</div>
