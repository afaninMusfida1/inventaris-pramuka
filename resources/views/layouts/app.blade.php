<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex">
            <!-- Sidebar -->
            <aside class="w-64 min-h-screen bg-white shadow-md hidden md:block">
                <div class="p-5">
                    <h2 class="text-xl font-bold mb-5">Menu</h2>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('peminjaman.index') }}" class="flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21V3m3 0l6 6m0 0v12M9 10v11" />
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        {{-- <li>
                            <a href="{{ route('peminjaman.index') }}" class="flex items-center px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400">
                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6m3 6v-6m3 6v-6m-9 0h12" />
                                </svg>
                                Peminjaman
                            </a>
                        </li> --}}
                    </ul>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="p-6">
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>
