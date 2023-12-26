<?php

namespace App\Livewire;

use App\Models\Location;
use App\Models\Yacht;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class LocationResource extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithForms,
        InteractsWithTable,
        InteractsWithActions;

    public function table(Table $table): Table
    {
        return $table
            ->query(Location::query())
            ->emptyStateHeading('Konum kaybı bulunmamaktadır')
            ->columns([
                TextColumn::make('name')
                    ->label('Konum Adı')
                    ->searchable()
                    ->sortable()
            ])
            ->actions([
                EditAction::make()
                    ->form([
                        TextInput::make('name')
                            ->label('Konum Adı')
                            ->required(),
                    ])
                    ->modalWidth('xl')
                    ->modalHeading('Konum Düzenle')
            ]);
    }

    public function render()
    {
        return view('livewire.location-resource');
    }

    public function createAction(): Action
    {
        return Action::make('create')
            ->label('Konum Ekle')
            ->form([
                TextInput::make('name')
                    ->label('Konum Adı')
                    ->required(),
            ])
            ->action(function (array $data) {
                Location::create($data);
            })
            ->modalWidth('xl');
    }
}
