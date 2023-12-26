<?php

namespace App\Livewire\Auth;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Login extends Component implements HasForms
{
    use InteractsWithForms;


    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email')
                    ->label('E-Posta adresiniz')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->label('Şifreniz')
                    ->required()
                    ->password(),
                Checkbox::make('remember_me')
                    ->label('Beni Hatırla')
            ])
            ->statePath('data');
    }

    public function login()
    {

        $data = $this->form->getState();

        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $data['remember_me'])) {
            return $this->redirect(route('Home'));
        }else{
            return Notification::make()
                ->danger()
                ->title('Hata')
                ->body('Kullanıcı bilgileri eşleşmedi. Lütfen kontrol ederek tekrar deneyiniz')
                ->send();
        }
    }
    #[Layout('components.layouts.app-login')]
    public function render()
    {
        return view('livewire.auth.login');
    }
}
