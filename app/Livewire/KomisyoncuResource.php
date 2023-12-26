<?php

namespace App\Livewire;

use App\Models\Komisyoncu;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class KomisyoncuResource extends Component implements HasTable, HasForms, HasActions
{
    use InteractsWithForms,
        InteractsWithTable,
        InteractsWithActions;

    public function render()
    {
        return view('livewire.komisyoncu-resource');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Komisyoncu::query())
            ->emptyStateHeading('Komisyoncu kaydı bulunamadı')
            ->columns([
                TextColumn::make('name')
                    ->label('Komisyoncu Adı')
            ]);
    }

    public function createAction(): Action
    {
        return Action::make('create')
            ->label('Komisyonu Ekle')
            ->modalHeading('Komisyoncu Ekle')
            ->modalWidth('lg')
            ->form([
                TextInput::make('name')
                    ->label('Komisyoncu Adı')
                    ->required()
            ])
            ->action(function ($data) {
                Komisyoncu::create($data);
            });
    }
}
