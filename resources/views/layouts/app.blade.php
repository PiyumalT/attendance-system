<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            <div x-data="{ show: true }" x-show="show"
                x-init="setTimeout(() => show = false, 4000)"
                x-transition
                class="fixed top-4 right-4 z-50">

                @if (session('success'))
                    <div class="flex items-center justify-between bg-green-100 border border-green-400 text-green-800 px-5 py-5 rounded shadow-lg mb-4"
                        role="alert">
                        <span class="mr-4 my-3">{{ session('success') }}</span>
                        <button @click="show = false" class="text-green-800 hover:text-green-600 font-bold text-lg">&times;</button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="flex items-center justify-between bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded shadow-lg mb-4"
                        role="alert">
                        <span class="mr-4">{{ session('error') }}</span>
                        <button @click="show = false" class="text-red-800 hover:text-red-600 font-bold text-lg">&times;</button>
                    </div>
                @endif
            </div>


            {{ $slot }}
            <script src="//unpkg.com/alpinejs" defer></script>

        </main>
    </div>
</body>
</html>
