<x-custom-page title="Menü Yönetimi">
    <x-slot:actions>
        {{ $this->createAction }}
    </x-slot:actions>
    {{ $this->table }}
</x-custom-page>
