<?php

namespace App\Livewire;

use App\Models\Menu;
use App\Models\Restaurant;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\RawJs;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class MenuResource extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithActions,
        InteractsWithTable,
        InteractsWithForms;

    public function render()
    {
        return view('livewire.menu-resource');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Menu::query())
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('restaurant.name')
                    ->label('Restoran')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Menü Adı')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('person_price')
                    ->label('Kişi Başı Fiyat')
                    ->money('TRY')
                    ->sortable(),
                TextColumn::make('details')
                    ->label('Detaylar')
                    ->limit(50)

            ])
            ->emptyStateHeading('Menü kaydı bulunamadı')
            ->actions([
                \Filament\Tables\Actions\EditAction::make()
                    ->modalHeading('Menü Düzenle')
                    ->form([
                        Select::make('restaurant_id')
                            ->label('Restoran')
                            ->required()
                            ->options(Restaurant::orderBy('order')->pluck('name','id'))
                            ->searchable(),
                        TextInput::make('name')
                            ->label('Menü Adı')
                            ->required(),
                        Textarea::make('details')
                            ->label('Detaylar'),
                        TextInput::make('person_price')
                            ->label('Kişi Başı Fiyat')
                            ->mask(RawJs::make('$money($input)'))
                            ->numeric()
                            ->inputMode('decimal')
                            ->stripCharacters(',')
                    ]),
                DeleteAction::make()
            ])
            ->filters([
                SelectFilter::make('restaurant_id')
                    ->label('Restoran')
                    ->options(Restaurant::pluck('name','id'))
            ]);
    }

    public function createAction(): Action
    {
        return Action::make('create')
            ->label('Menü Ekle')
            ->form([
                Select::make('restaurant_id')
                    ->label('Restoran')
                    ->options(Restaurant::orderBy('order')->pluck('name','id'))
                    ->required()
                    ->searchable(),
                TextInput::make('name')
                    ->label('Menü Adı')
                    ->required(),
                Textarea::make('details')
                    ->label('Detaylar'),
                TextInput::make('person_price')
                    ->label('Kişi Başı Fiyat')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
            ])
            ->action(function (array $data) {
                Menu::create($data);
            })
            ->modalWidth('xl');
    }
}
