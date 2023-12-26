@props([
    'title',
    'actions' => null
])
<div>
    <div class="py-4 flex items-center justify-between">
        <h3 class="font-semibold text-gray-950">{{ $title }}</h3>
        <div class="flex items-center gap-4">
            {{ $actions }}
        </div>
    </div>

    {{ $slot }}

    <x-filament-actions::modals />
</div>
