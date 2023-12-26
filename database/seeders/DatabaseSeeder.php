<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Currency;
use App\Models\Location;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Yacht;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'email_verified_at' => now()
        ]);
        Yacht::insert([
            ['name' => 'Mega Denden', 'hourly_price' => 250],
            ['name' => 'Deniz Taksi', 'hourly_price' => 100],
            ['name' => 'DenDen 1', 'hourly_price' => 100],
        ]);
        Restaurant::insert([
            ['name' => 'Diğer', 'order' => 1],
            ['name' => 'Balık Noktası', 'order' => 2],
            ['name' => 'Delmare Restaurant', 'order' => 3],
            ['name' => 'Denden', 'order' => 4],
            ['name' => 'Elma Catring', 'order' => 5],
            ['name' => 'Kafes Resturant', 'order' => 6],
            ['name' => 'Mira Restaurant', 'order' => 7],
            ['name' => 'Ali Ocakbasi', 'order' => 8],
            ['name' => 'Restoran Yok', 'order' => 8],
        ]);

        Menu::insert([
            ['name' => 'Fish Menü', 'restaurant_id' => 3],
            ['name' => 'Steak House Lunch Menu 1', 'restaurant_id' => 3],
            ['name' => 'Steak House Lunch Menu 2', 'restaurant_id' => 3],
            ['name' => 'Steakhouse Dinner Menu 1', 'restaurant_id' => 3],
            ['name' => 'Steakhouse Dinner Menu 2', 'restaurant_id' => 3],
            ['name' => 'Vejeteryan Menu', 'restaurant_id' => 3],
            ['name' => 'Fish Menu', 'restaurant_id' => 2],
            ['name' => 'Steak Menu', 'restaurant_id' => 2],
            ['name' => 'Açık Büfe Denden', 'restaurant_id' => 5],
            ['name' => 'Açık Büfe Kahvaltı', 'restaurant_id' => 5],
            ['name' => 'Açık Büfe Asya Lezzetleri', 'restaurant_id' => 5],
            ['name' => 'Açık Büfe Deniz Mahsülleri', 'restaurant_id' => 5],
            ['name' => 'Açık Büfe Ekonomik', 'restaurant_id' => 5],
            ['name' => 'Açık Büfe İftar', 'restaurant_id' => 5],
            ['name' => 'Açık Büfe Osmanlı', 'restaurant_id' => 5],
        ]);

        Location::insert([
            ['name' => 'Çırağan'],
            ['name' => 'Four Seasons'],
            ['name' => 'Sardunya'],
            ['name' => 'Kuleli'],
            ['name' => 'Diğer'],
            ['name' => 'Kabataş'],
            ['name' => 'Kabataş Vapur İskelesi'],
        ]);

        Currency::insert([
            ['code' => 'TRY', 'name' => 'Türk Lirası'],
            ['code' => 'USD', 'name' => 'Dolar'],
            ['code' => 'EUR', 'name' => 'Euro'],
        ]);
    }
}
