<div class="flex-1 flex flex-col items-center justify-center">
    <div class="max-w-sm w-full shadow flex flex-col items-center justify-center p-4 space-y-2">
        <img src="{{ asset('images/logo-full.png') }}">
        <h3 class="font-semibold">Yetkili Girişi</h3>
        <form wire:submit="login" class="flex flex-col w-full">
            {{ $this->form }}

            <div class="flex items-center justify-end">
                <x-filament::button
                    wire:target="login"
                    type="submit">
                    Giriş Yap
                </x-filament::button>
            </div>
        </form>
    </div>

    <x-filament-actions::modals />
</div>
