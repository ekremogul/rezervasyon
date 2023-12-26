<?php

namespace App\Livewire;

use App\Models\Restaurant;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class RestaurantResource extends Component implements HasTable, HasForms, HasActions
{
    use InteractsWithForms,
        InteractsWithTable,
        InteractsWithActions;

    public function render()
    {
        return view('livewire.restaurant-resource');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Restaurant::query())
            ->reorderable('order')
            ->columns([
                TextColumn::make('name')
                    ->label('Restoran Adı')
                    ->searchable()
                    ->sortable()
            ])
            ->actions([
                EditAction::make()
                    ->modalHeading('Restoran Düzenle')
                    ->form([
                        TextInput::make('name')
                            ->label('Restoran Adı')
                            ->required()
                    ])
                    ->modalWidth('xl'),
                DeleteAction::make()
            ])
            ->emptyStateHeading('Restoran kaydı bulunmamaktadır');
    }

    public function createAction(): Action
    {
        return Action::make('create')
            ->label('Restoran Ekle')
            ->form([
                TextInput::make('name')
                    ->required()
                    ->label('Restoran Adı')

            ])
            ->action(function (array $data) {
                Restaurant::create($data);
            })
            ->modalWidth('xl');
    }
}
