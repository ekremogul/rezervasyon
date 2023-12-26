<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @filamentStyles
    @vite('resources/css/app.scss')
</head>

<body class="antialiased">
<main class="flex-1 flex " x-data="{ sidebarOpen: false }" @keydown.window.escape="sidebarOpen = false">
    <x-sidebar />
    <div class="flex-1 flex flex-col lg:pl-72">
        <x-navbar />
        <div class="flex-1 p-8">
            {{ $slot }}
        </div>
        <x-footer />
    </div>
</main>

@livewire('notifications')
@filamentScripts
@vite('resources/js/app.js')
</body>
</html>

