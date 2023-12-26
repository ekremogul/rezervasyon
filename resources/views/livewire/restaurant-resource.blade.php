<x-custom-page title="Restoran Listesi">
    <x-slot:actions>
        {{ $this->createAction }}
    </x-slot:actions>
    {{ $this->table }}
</x-custom-page>
