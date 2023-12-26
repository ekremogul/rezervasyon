<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/', \App\Livewire\Home::class)->name('Home');

    Route::get('yachts', \App\Livewire\Yachts\Index::class)->name('Yachts.Index');
    Route::get('locations', \App\Livewire\LocationResource::class)->name('Location.Index');
    Route::get('menus', \App\Livewire\MenuResource::class)->name('Menu.Index');
    Route::get('restaurants', \App\Livewire\RestaurantResource::class)->name('Restaurant.Index');

    Route::get('reservation', App\Livewire\ReservationResource\Index::class)->name('Reservation.Index');
    Route::get('reservation/create', App\Livewire\ReservationResource\Create::class)->name('Reservation.Create');
    Route::get('reservation/{id}/edit', App\Livewire\ReservationResource\Edit::class)->name('Reservation.Edit');

    Route::get('komisyoncu', \App\Livewire\KomisyoncuResource::class)->name('Komisyonu.Index');
});
