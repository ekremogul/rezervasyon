<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
    class="-mx-6"
>
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
        <div class="flex flex-col space-y-2">
            <h3 class="font-medium text-primary-600 px-6">Genel Toplamlar</h3>
            <table class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
                <thead class="bg-gray-50 dark:bg-white/5">
                <tr>
                    <th class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                        <span class="group flex w-full items-center gap-x-1 whitespace-nowrap justify-start">Kalem</span>
                    </th>
                    <th>
                        <span class="group flex w-full items-center gap-x-1 whitespace-nowrap justify-start">Tutar</span>
                    </th>
                    <th>
                        <span class="group flex w-full items-center gap-x-1 whitespace-nowrap justify-start">KDV</span>
                    </th>
                    <th>
                        <span class="group flex w-full items-center gap-x-1 whitespace-nowrap justify-start">Toplam Tutar</span>
                    </th>
                    <th>
                        <span class="group flex w-full items-center gap-x-1 whitespace-nowrap justify-start">Kur Bilgisi</span>
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
                <x-filament-tables::row>
                    <x-filament-tables::cell class="py-4">Tekne Ücreti</x-filament-tables::cell>
                    <x-filament-tables::cell>{{  \Filament\Support\format_money((float)$this->data['tekne_toplam_ucret'], $this->data['currency']) }}</x-filament-tables::cell>
                    <x-filament-tables::cell>
                        {{ \Filament\Support\format_money((float) $this->data['toplam_kdv'], $this->data['currency']) }}
                    </x-filament-tables::cell>
                    <x-filament-tables::cell>{{ \Filament\Support\format_money( ((float)$this->data['tekne_toplam_ucret'] + (float)$this->data['toplam_kdv']), $this->data['currency'] ) }}</x-filament-tables::cell>
                        <x-filament-tables::cell>
                            @if($this->data['currency'] == 'TRY' )
                                -
                            @endif
                        </x-filament-tables::cell>
                    </x-filament-tables::row>
                    <x-filament-tables::row>
                        <x-filament-tables::cell class="py-4">Restoran</x-filament-tables::cell>
                        <x-filament-tables::cell>{{ \Filament\Support\format_money((float)$this->data['menu_toplam'], $this->data['menu_currency']) }}</x-filament-tables::cell>
                        <x-filament-tables::cell>{{ \Filament\Support\format_money((float)$this->data['menu_toplam_kdv'], $this->data['menu_currency']) }}</x-filament-tables::cell>
                        <x-filament-tables::cell>{{ \Filament\Support\format_money((float)$this->data['menu_genel_toplam'], $this->data['menu_currency']) }}</x-filament-tables::cell>
                        <x-filament-tables::cell></x-filament-tables::cell>
                    </x-filament-tables::row>
                    <x-filament-tables::row>
                        <x-filament-tables::cell class="py-4">Alkol</x-filament-tables::cell>
                        <x-filament-tables::cell>{{ \Filament\Support\format_money((float)$this->data['alkol_toplam'], $this->data['alkol_currency']) }}</x-filament-tables::cell>
                        <x-filament-tables::cell>{{ \Filament\Support\format_money((float)$this->data['alkol_toplam_kdv'], $this->data['alkol_currency']) }}</x-filament-tables::cell>
                        <x-filament-tables::cell>{{ \Filament\Support\format_money((float)$this->data['alkol_genel_toplam'], $this->data['alkol_currency']) }}</x-filament-tables::cell>
                        <x-filament-tables::cell></x-filament-tables::cell>
                    </x-filament-tables::row>
                    <x-filament-tables::row>
                        <x-filament-tables::cell class="py-4">Ekstralar</x-filament-tables::cell>
                        <x-filament-tables::cell>{{ \Filament\Support\format_money((float)$this->data['ekstra_toplam'], $this->data['ekstra_currency']) }}</x-filament-tables::cell>
                        <x-filament-tables::cell>{{ \Filament\Support\format_money((float)$this->data['ekstra_toplam_kdv'], $this->data['ekstra_currency']) }}</x-filament-tables::cell>
                        <x-filament-tables::cell>{{ \Filament\Support\format_money((float)$this->data['ekstra_genel_toplam'], $this->data['ekstra_currency']) }}</x-filament-tables::cell>
                        <x-filament-tables::cell></x-filament-tables::cell>
                    </x-filament-tables::row>
                    <x-filament-tables::row>
                        <x-filament-tables::cell class="py-4"></x-filament-tables::cell>
                        <x-filament-tables::cell></x-filament-tables::cell>
                        <x-filament-tables::cell  class="text-lg font-medium">Toplam Tutar (14.225)</x-filament-tables::cell>
                        <x-filament-tables::cell>{{ \Filament\Support\format_money((float)$this->data['toplam_tutar'], $this->data['ekstra_currency']) }}</x-filament-tables::cell>
                        <x-filament-tables::cell></x-filament-tables::cell>
                    </x-filament-tables::row>
                    <x-filament-tables::row>
                        <x-filament-tables::cell class="py-4"></x-filament-tables::cell>
                        <x-filament-tables::cell></x-filament-tables::cell>
                        <x-filament-tables::cell  class="text-lg font-medium">Toplam KDV (2345)</x-filament-tables::cell>
                        <x-filament-tables::cell>{{ \Filament\Support\format_money((float)$this->data['genel_toplam_kdv'], $this->data['ekstra_currency']) }}</x-filament-tables::cell>
                        <x-filament-tables::cell></x-filament-tables::cell>
                    </x-filament-tables::row>
                    <x-filament-tables::row>
                        <x-filament-tables::cell class="py-4"></x-filament-tables::cell>
                        <x-filament-tables::cell></x-filament-tables::cell>
                        <x-filament-tables::cell class="text-lg font-medium">Genel Toplam (16.570)</x-filament-tables::cell>
                        <x-filament-tables::cell>{{ \Filament\Support\format_money((float)$this->data['genel_toplam'], $this->data['ekstra_currency']) }}</x-filament-tables::cell>
                        <x-filament-tables::cell></x-filament-tables::cell>
                    </x-filament-tables::row>
                </tbody>
            </table>
        </div>
    </div>
</x-dynamic-component>
