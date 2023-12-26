<x-custom-page title="Rezervasyon Listesi">
    <x-slot:actions>
        {{ \Filament\Actions\CreateAction::make()->label('Rezervasyon Ekle')->url(route('Reservation.Create')) }}
    </x-slot:actions>
    {{ $this->table }}
</x-custom-page>
