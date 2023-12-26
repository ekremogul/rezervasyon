<?php

namespace App\Livewire\ReservationResource;

use App\Forms\Components\GenelToplamItem;
use App\Forms\Components\RezervasyonForm\GenelToplamlar;
use App\Models\Currency;
use App\Models\Komisyoncu;
use App\Models\Location;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\Yacht;
use Carbon\Carbon;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\View;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Infolist;
use Filament\Support\RawJs;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class Create extends Component implements HasForms, HasActions
{
    use InteractsWithForms,
        InteractsWithActions;

    public array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'currency' => 'TRY',
            'menu_currency' => 'TRY',
            'alkol_currency' => 'TRY',
            'ekstra_currency' => 'TRY',
            'base_currency' => 'TRY',
            'toplam_tutar' => 0,
            'genel_toplam_kdv' => 0,
            'genel_toplam' => 0,

            'name' => '',
            'phone' => '',
            'kisi' => null,
            'yacht_id' => null,
            'hourly_price' => null,
            'reservation_start' => null,
            'reservation_end' => null,
        ]);
    }

    public function render()
    {
        return view('livewire.reservation-resource.create');
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Wizard::make()
                    ->steps([
                        Wizard\Step::make('Kişisel Bilgiler')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Ad Soyad')
                                    ->required()
                                    ->columnSpan(2),
                                TextInput::make('phone')
                                    ->label('Telefon Numarası')
                                    ->columnSpan([
                                        'default' => 2,
                                        'sm' => 2,
                                        'lg' => 1
                                    ])
                                    ->required(),
                                TextInput::make('unvan')
                                    ->columnSpan([
                                        'default' => 2,
                                        'lg' => 1,
                                        'sm' => 2
                                    ])
                                    ->label('Ünvan'),
                                Textarea::make('adres')
                                    ->label('Adres')
                                    ->columnSpan(4)
                                    ->rows(4),
                                TextInput::make('vergi_dairesi')
                                    ->label('Vergi Dairesi'),
                                TextInput::make('vergi_no')
                                    ->label('Vergi No'),
                                TextInput::make('email')
                                    ->label('E-Posta Adresi')
                                    ->email(),
                                TextInput::make('kisi')
                                    ->label('Kişi Sayısı')
                                    ->reactive()
                                    ->required()
                                    ->numeric()
                            ])->columns(4),
                        Wizard\Step::make('Tekne & Rezervasyon Bilgileri')
                            ->schema([
                                Select::make('yacht_id')
                                    ->required()
                                    ->label('Tekne')
                                    ->options(Yacht::pluck('name', 'id'))
                                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                        $yacht = Yacht::find($state);
                                        $hourlyPrice = 0;
                                        if ($yacht) {
                                            $hourlyPrice = $yacht->hourly_price;
                                        }
                                        $set('hourly_price', $hourlyPrice);
                                    })
                                    ->reactive(),
                                TextInput::make('hourly_price')
                                    ->label('Tekne Saatlik Ücret')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $this->updateStepTwoPrices($get, $set);
                                    })
                                    ->reactive(),
                                TextInput::make('kdv')
                                    ->label('KDV')
                                    ->debounce(1000)
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $this->updateStepTwoPrices($get, $set);
                                    })
                                    ->reactive()
                                    ->required(),
                                Select::make('currency')
                                    ->required()
                                    ->native(false)
                                    ->label('Para Birimi')
                                    ->selectablePlaceholder(false)
                                    ->options([
                                        'TRY' => 'Türk Lirası',
                                        'USD' => 'Dolar',
                                        'EUR' => 'Euro'
                                    ])
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $this->updateStepTwoPrices($get, $set);
                                    })
                                    ->reactive()
                                    ->default('TRY'),
                                DateTimePicker::make('reservation_start')
                                    ->seconds(false)
                                    ->label('Rezervasyon Başlangıç')
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $this->updateStepTwoPrices($get, $set);
                                    })
                                    ->reactive(),
                                DateTimePicker::make('reservation_end')
                                    ->seconds(false)
                                    ->label('Rezervasyon Bitiş')
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $this->updateStepTwoPrices($get, $set);
                                    })
                                    ->reactive(),
                                TextInput::make('tekne_toplam_ucret')
                                    ->label('Tekne Toplam Ücreti')
                                    ->reactive()
                                    ->readOnly()
                                    ->numeric()
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                ,
                                TextInput::make('toplam_kdv')
                                    ->label('Toplam KDV')
                                    ->reactive()
                                    ->readOnly()
                                    ->numeric()
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(','),
                                Select::make('alis_konum')
                                    ->label('Alış Noktası')
                                    ->options(Location::pluck('name', 'id'))
                                    ->required()
                                    ->searchable(),
                                Select::make('birakis_konum')
                                    ->label('Bırakış Noktası')
                                    ->options(Location::pluck('name', 'id'))
                                    ->required()
                                    ->searchable(),
                            ])->columns(4),
                        Wizard\Step::make('Restoran & Menü')
                            ->schema([
                                Select::make('restaurant_id')
                                    ->required()
                                    ->label('Restoran')
                                    ->native(false)
                                    ->searchable()
                                    ->reactive()
                                    ->options(Restaurant::pluck('name', 'id'))
                                    ->afterStateUpdated(function (Set $set) {
                                        $set('menu_id', null);
                                    }),
                                Select::make('menu_id')
                                    ->required()
                                    ->label('Menü')
                                    ->reactive()
                                    ->options(function (Get $get) {
                                        if ($get('restaurant_id')) {
                                            return Restaurant::findOrFail($get('restaurant_id'))
                                                ?->menus()->pluck('name', 'id');
                                        }
                                        return [];
                                    })
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        if ($state) {
                                            $set('menu_price', Menu::find($state)?->person_price);
                                        }
                                    })
                                    ->native(false),
                                TextInput::make('menu_price')
                                    ->label('Menü Ücreti')
                                    ->columnStart(1)
                                    ->reactive()
                                    ->debounce(1000)
                                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                        $this->updateMenuPrices($get, $set);
                                    })
                                ,
                                TextInput::make('menu_kdv')
                                    ->label('KDV')
                                    ->numeric()
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->reactive()
                                    ->debounce(1000)
                                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                        $this->updateMenuPrices($get, $set);
                                    }),
                                Select::make('menu_currency')
                                    ->label('Para Birimi')
                                    ->options(Currency::pluck('name', 'code'))
                                    ->native(false)
                                    ->selectablePlaceholder(false)
                                    ->searchable(),
                                Textarea::make('menu_details')
                                    ->label('Menü Detayı')
                                    ->rows(4)
                                    ->columnSpan(4)
                                    ->reactive(),
                                TextInput::make('menu_toplam')
                                    ->label('Menü Toplam Tutar')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->readOnly()
                                    ->readOnly(),
                                TextInput::make('menu_toplam_kdv')
                                    ->label('Menü Toplam KDV')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->readOnly()
                                    ->readOnly(),
                                TextInput::make('menu_genel_toplam')
                                    ->label('Menü Genel Toplam')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->readOnly()
                                    ->readOnly(),
                                Toggle::make('alkol')
                                    ->label('Alkol var mı?')
                                    ->columnStart(1)
                                    ->reactive(),
                                Fieldset::make('Alkol Bilgileri')
                                    ->hidden(function (Get $get) {
                                        return !$get('alkol');
                                    })
                                    ->schema([
                                        TextInput::make('alkol_person_price')
                                            ->label('Kişi Başı Fiyat')
                                            ->reactive()
                                            ->mask(RawJs::make('$money($input)'))
                                            ->stripCharacters(',')
                                            ->required(fn(Get $get): bool => $get('alkol'))
                                            ->debounce(1000)
                                            ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                                $this->updateAlkolPrice($get, $set);
                                            }),
                                        TextInput::make('alkol_kdv')
                                            ->label('KDV')
                                            ->reactive()
                                            ->debounce(1000)
                                            ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                                $this->updateAlkolPrice($get, $set);
                                            })
                                            ->required(fn(Get $get): bool => $get('alkol')),
                                        Select::make('alkol_currency')
                                            ->label('Para Birimi')
                                            ->selectablePlaceholder(false)
                                            ->options(Currency::pluck('name', 'code'))
                                            ->native(false)
                                        ,
                                        TextInput::make('alkol_toplam')
                                            ->label('Toplam Fiyat')
                                            ->reactive()
                                            ->readOnly(),
                                        TextInput::make('alkol_toplam_kdv')
                                            ->label('KDV')
                                            ->reactive()
                                            ->readOnly(),
                                        TextInput::make('alkol_genel_toplam')
                                            ->label('Genel Toplam')
                                            ->reactive()
                                            ->readOnly(),

                                    ])
                                    ->columns(3),
                                Repeater::make('ekstralar')
                                    ->addActionLabel('Ekstra Ekle')
                                    ->schema([
                                        TextInput::make('ekstra')
                                            ->required(),
                                        TextInput::make('price')
                                            ->label('Tutar')
                                            ->mask(RawJs::make('$money($input)'))
                                            ->stripCharacters(','),
                                        TextInput::make('kdv')
                                            ->label('KDV'),
                                    ])->columns(4)
                                    ->collapsible()
                                    ->reactive()
                                    ->debounce(1000)
                                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                        $tutarlar = 0;
                                        $kdvler = 0;
                                        foreach ($state as $row) {
                                            if ((float)$row['price'] ?? null) {
                                                $tutar = (float)str($row['price'])->replace(',', '')->toFloat();
                                                $tutarlar += $tutar;

                                                if ($row['kdv'] ?? null) {
                                                    $kdvler += ((float)$row['kdv'] * $tutar / 100);
                                                }
                                            }
                                        }
//                                        $kisi = $get('kisi');
                                        $toplamTutar = 0;
                                        $toplamKdv = 0;
                                        if ($tutarlar > 0) {
                                            $toplamTutar = $tutarlar;
                                            $toplamKdv = $kdvler;
                                        }
                                        $set('ekstra_toplam', $toplamTutar);
                                        $set('ekstra_toplam_kdv', $toplamKdv);
                                        $set('ekstra_genel_toplam', $toplamTutar + $toplamKdv);
                                    })
                                    ->columnSpan(4),
                                Section::make()
                                    ->hidden(function (Get $get) {
                                        return !$get('ekstralar');
                                    })
                                    ->schema([
                                        TextInput::make('ekstra_toplam')
                                            ->label('Ekstralar Toplam')
                                        ,
                                        TextInput::make('ekstra_toplam_kdv')
                                            ->label('KDV'),
                                        TextInput::make('ekstra_genel_toplam')
                                            ->label('Genel Toplam'),
                                        Select::make('ekstra_currency')
                                            ->label('Para Birimi')
                                            ->options(Currency::pluck('name', 'code'))
                                            ->native(false)
                                            ->default('TRY')
                                            ->selectablePlaceholder(false)
                                    ])->columns(4)
                            ])->columns(4),
                        Wizard\Step::make('Diğer')
                            ->schema([
                                Fieldset::make('Komisyoncu Detayları')
                                    ->schema([
                                        Select::make('komisyoncu_id')
                                            ->label('Komisyoncu')
                                            ->options(Komisyoncu::pluck('name', 'id'))
                                            ->native(false)
                                            ->searchable(),
                                        TextInput::make('komisyoncu_tutar')
                                            ->label('Komisyoncu Hakediş')
                                            ->mask(RawJs::make('$money($input)'))
                                            ->stripCharacters(','),

                                    ])->columns(2),
                                Fieldset::make('Tur Detayları')
                                    ->schema([
                                        Textarea::make('detaylar')
                                            ->label('Tur Detayları')
                                            ->rows(10)
                                    ])->columns(1)
                            ])->columns(1)
                            ->afterValidation(function (Get $get, Set $set) {
                                $toplamTutar = (float)$get('tekne_toplam_ucret') +
                                    (float)$get('menu_toplam') +
                                    (float)$get('alkol_toplam') +
                                    (float)$get('ekstra_toplam');

                                $this->data['toplam_tutar'] = $toplamTutar;

                                $toplamKdv = (float)$get('toplam_kdv') +
                                    (float)$get('menu_toplam_kdv') +
                                    (float)$get('alkol_toplam_kdv') +
                                    (float)$get('ekstra_toplam_kdv');

                                $this->data['genel_toplam_kdv'] = $toplamKdv;

                                $this->data['genel_toplam'] = $toplamTutar + $toplamKdv;
                            }),
                        Wizard\Step::make('Genel Bakış')
                            ->schema([
                                GenelToplamlar::make()
                                    ->schema([
                                        GenelToplamItem::make('genel_toplamlar')
                                            ->hiddenLabel(),
                                        Fieldset::make('Ücretlendirme')
                                            ->schema([
                                                TextInput::make('ucret')
                                                    ->label('Ücret'),
                                                Select::make('base_currency')
                                                    ->native(false)
                                                    ->options(Currency::pluck('name', 'code'))
                                                    ->reactive()
                                                    ->label('Para Birimi')
                                                    ->selectablePlaceholder(false),
                                                Select::make('odeme')
                                                    ->label('Ödeme Durumu')
                                                    ->native(false)
                                                    ->options([
                                                        1 => 'Ödendi',
                                                        0 => 'Ödenmedi'
                                                    ])->selectablePlaceholder(false),
                                                TextInput::make('kur')
                                                    ->label('Döviz Kuru')
                                                    ->hidden(fn(Get $get): bool => $get('base_currency') === 'TRY'),
                                                Select::make('tip')
                                                    ->label('Tip')
                                                    ->options([
                                                        1 => 'Opsiyonlu',
                                                        0 => 'Konfirme'
                                                    ])
                                                    ->native(false)
                                                    ->columnStart(1),
                                                Select::make('cathering')
                                                    ->label('Cathering')
                                                    ->options([
                                                        1 => 'Sipariş Verildi',
                                                        0 => 'Verilmedi'
                                                    ])
                                                    ->native(false),
                                                Select::make('marina_izni')
                                                    ->label('Marina İzni')
                                                    ->options([
                                                        1 => 'Verildi',
                                                        0 => 'Verilmedi'
                                                    ])
                                                    ->native(false),
                                                Select::make('promosyon')
                                                    ->label('Promosyon mu?')
                                                    ->options([
                                                        1 => 'Evet',
                                                        0 => 'Hayır'
                                                    ])
                                                    ->native(false)

                                            ])->columns(4)
                                    ])
                            ])
                    ])
                    ->startOnStep(1)
                    ->submitAction(new HtmlString(Blade::render(<<<BLADE
    <x-filament::button
        type="submit"
        size="sm"
    >
        Rezervasyon Oluştur
    </x-filament::button>
BLADE)))
            ]);
    }

    public function updateStepTwoPrices(Get $get, Set $set): void
    {
        $yacht = $get('yacht_id');
        $hourlyPrice = $get('hourly_price');
        $currency = $get('currency');
        $reservation_start = $get('reservation_start') ? Carbon::parse($get('reservation_start')) : $get('reservation_start');
        $reservation_end = $get('reservation_end') ? Carbon::parse($get('reservation_end')) : $get('reservation_end');
        $kdv = $get('kdv');
        if (!$yacht || $hourlyPrice < 1 || !$currency || !$reservation_start || !$reservation_end)
            return;

        $totalMinutes = $reservation_end->diffInMinutes($reservation_start);
        $totalHour = ceil($totalMinutes / 60);
        $personHourlyPrice = $totalHour * $hourlyPrice;
        $yachtPrice = $personHourlyPrice;
//        $kdv = $kdv
        $set('tekne_toplam_ucret', $yachtPrice);
        if ($kdv) {
            $totalKdv = $yachtPrice * $kdv / 100;
            $set('toplam_kdv', $totalKdv);
        }

    }

    public function updateMenuPrices(Get $get, Set $set)
    {
        $menuTutar = $get('menu_price');
        $menuKdv = $get('menu_kdv');
        $kisi = $get('kisi');
        $tutar = 0;
        $kdv = 0;
        if ($menuTutar) {
            $tutar = $kisi * $menuTutar;
            $set('menu_toplam', $tutar);
            if ($menuKdv) {
                $kdv = $tutar * $menuKdv / 100;
                $set('menu_toplam_kdv', $kdv);
            }

            $set('menu_genel_toplam', $tutar + $kdv);
        }

    }

    public function updateAlkolPrice(Get $get, Set $set)
    {
        $alkolTutar = $get('alkol_person_price');
        $alkolKdv = $get('alkol_kdv');
        $kisi = $get('kisi');
        $tutar = 0;
        $kdv = 0;
        if ($alkolTutar) {
            $tutar = $kisi * $alkolTutar;
            $set('alkol_toplam', $tutar);
            if ($alkolKdv) {
                $kdv = $tutar * $alkolKdv / 100;
                $set('alkol_toplam_kdv', $kdv);
            }

            $set('alkol_genel_toplam', $tutar + $kdv);
        }

    }

    public function create()
    {
        $data = $this->form->getState();

        dd($data);
    }
}
