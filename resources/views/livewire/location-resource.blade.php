<x-custom-page title="Konum Listesi">
    <x-slot:actions>
        {{ $this->createAction }}
    </x-slot:actions>
    {{ $this->table }}
</x-custom-page>
