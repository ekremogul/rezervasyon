<?php

namespace App\Livewire\ReservationResource;

use App\Models\Restaurant;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class Index extends Component implements HasTable, HasForms, HasActions
{
    use InteractsWithActions,
        InteractsWithTable,
        InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Restaurant::query())
            ->columns([

            ]);
    }

    public function render()
    {
        return view('livewire.reservation-resource.index');
    }
}
