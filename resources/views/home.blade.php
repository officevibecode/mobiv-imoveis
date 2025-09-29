<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased bg-gray-50">
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <div class="mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-primary rounded-full mb-4">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
            
            <h1 class="text-5xl font-bold text-primary mb-4">
                MOBIV Setup OK
            </h1>
            
            <p class="text-xl text-gray-600 mb-8">
                Laravel {{ app()->version() }} + Livewire + Tailwind CSS + Alpine.js
            </p>
            
            <div class="flex gap-4 justify-center">
                <span class="px-4 py-2 bg-primary text-white rounded-lg font-semibold">
                    Primary: #01589F
                </span>
                <span class="px-4 py-2 bg-accent text-gray-800 rounded-lg font-semibold">
                    Accent: #C1D460
                </span>
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>
