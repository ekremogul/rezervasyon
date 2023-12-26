<?php

namespace App\Livewire\Yachts;

use App\Models\Yacht;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Support\RawJs;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class Index extends Component implements HasTable, HasForms, HasActions
{
    use InteractsWithTable,
        InteractsWithActions,
        InteractsWithForms;

    public function render()
    {
        return view('livewire.yachts.index');
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Tekne Adı')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('hourly_price')
                    ->label('Saatlik Ücreti')
                    ->money('TRY')
                    ->sortable(),
                TextColumn::make('details')
                    ->label('Detaylar')
                    ->limit(50)
                    ->searchable()
            ])
            ->actions([
                EditAction::make()
                    ->form([
                        TextInput::make('name')
                            ->label('Tekne Adı')
                            ->required(),
                        TextInput::make('hourly_price')
                            ->mask(RawJs::make('$money($input)'))
                            ->numeric()
                            ->label('Saatlik Ücreti'),
                        Textarea::make('details')
                            ->label('Detaylar')

                    ])
                    ->modalWidth('xl')
            ])
            ->query(Yacht::query())
            ->emptyStateHeading('Tekne Kaydı bulunamadı');
    }

    public function createAction(): Action
    {
        return Action::make('create')
            ->label('Yeni Tekne Ekle')
            ->form([
                TextInput::make('name')
                    ->label('Tekne Adı')
                    ->required(),
                TextInput::make('hourly_price')
                    ->label('Saatlik Ücret'),
                Textarea::make('details')
                    ->label('Detaylar')
            ])
            ->action(function (array $data) {
                Yacht::create($data);
            })
            ->modalWidth('xl');
    }
}
