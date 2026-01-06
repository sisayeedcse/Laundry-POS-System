<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Laundry POS' }} - {{ config('app.name', 'Laundry POS') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        /* Professional Design System - Optimized & Clean */

        /* Smooth Base Transitions */
        * {
            transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }

        /* Premium Sidebar Background */
        .sidebar-gradient {
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
        }

        /* Logo Glow Effect */
        .logo-glow {
            box-shadow: 0 0 25px rgba(99, 102, 241, 0.4);
        }

        /* Navigation Items */
        .nav-item {
            position: relative;
            transition: all 0.2s ease;
        }

        .nav-item.active {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(139, 92, 246, 0.1));
            border-left: 3px solid #6366f1;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.15);
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        /* Header Shadow */
        .header-shadow {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #6366f1, #8b5cf6);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #8b5cf6, #6366f1);
        }

        /* User Profile Card */
        .user-card {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.05));
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        /* Badge Styles */
        .badge-new {
            animation: badge-pulse 2s ease-in-out infinite;
        }

        @keyframes badge-pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }
    </style>
</head>

<body class="font-sans antialiased bg-slate-50">

    <!-- Professional Sidebar - Always Visible -->
    <aside class="fixed top-0 left-0 z-50 w-72 h-screen sidebar-gradient shadow-2xl">
        <div class="h-full flex flex-col">

            <!-- Logo Header -->
            <div class="px-6 py-8 border-b border-slate-700/30">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-xl flex items-center justify-center logo-glow">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">Amazing Laundry</h1>
                        <p class="text-xs text-indigo-300 font-medium">Qatar POS System</p>
                    </div>
                </div>
            </div>

            <!-- Professional Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto custom-scrollbar">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                    class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-300 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- POS -->
                <a href="{{ route('pos.index') }}"
                    class="nav-item {{ request()->routeIs('pos.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('pos.*') ? 'text-white' : 'text-slate-300 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>Point of Sale</span>
                    <span
                        class="ml-auto px-2.5 py-1 text-xs font-bold bg-gradient-to-r from-emerald-400 to-green-500 text-white rounded-lg shadow-sm badge-new">NEW</span>
                </a>

                <!-- Orders -->
                <a href="{{ route('orders.index') }}"
                    class="nav-item {{ request()->routeIs('orders.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('orders.*') ? 'text-white' : 'text-slate-300 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span>Orders</span>
                </a>

                <!-- Customers -->
                <a href="{{ route('customers.index') }}"
                    class="nav-item {{ request()->routeIs('customers.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('customers.*') ? 'text-white' : 'text-slate-300 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>Customers</span>
                </a>

                <!-- Divider -->
                <div class="py-2">
                    <div class="border-t border-slate-700/30 mx-2"></div>
                </div>

                <!-- Services -->
                <a href="{{ route('services.index') }}"
                    class="nav-item {{ request()->routeIs('services.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('services.*') ? 'text-white' : 'text-slate-300 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span>Services</span>
                </a>

                <!-- Reports -->
                <a href="{{ route('reports.index') }}"
                    class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('reports.*') ? 'text-white' : 'text-slate-300 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span>Reports</span>
                </a>

                <!-- Settings - Admin only -->
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('settings.index') }}"
                        class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('settings.*') ? 'text-white' : 'text-slate-300 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Settings</span>
                    </a>
                @endif
            </nav>

            <!-- User Profile Section -->
            @auth
                <div class="p-4 border-t border-slate-700/30 bg-slate-800/50">
                    <div class="flex items-center gap-3 px-3 py-3 user-card rounded-xl">
                        <div
                            class="w-11 h-11 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-base shadow-lg">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name ?? 'User' }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ Auth::user()->email ?? 'user@example.com' }}</p>
                            <span
                                class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full {{ Auth::user()->role === 'admin' ? 'bg-purple-100 text-purple-800' : (Auth::user()->role === 'manager' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }} mt-1">
                                {{ ucfirst(Auth::user()->role ?? 'staff') }}
                            </span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit"
                            class="flex items-center justify-center gap-2 w-full px-4 py-2.5 text-sm font-medium text-red-400 hover:text-white hover:bg-red-500/20 rounded-xl">\
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="ml-72">
        <!-- Professional Header -->
        <header class="bg-white border-b border-slate-200 sticky top-0 z-30 header-shadow">
            <div class="px-8 py-5">
                <div class="flex items-center justify-between">
                    <!-- Page Title -->
                    <div>
                        <h2
                            class="text-2xl font-bold bg-gradient-to-r from-slate-900 via-indigo-900 to-purple-900 bg-clip-text text-transparent">
                            {{ $title ?? 'Dashboard' }}
                        </h2>
                        <p class="text-sm text-slate-500 mt-1 font-medium tracking-wide">{{ date('l, F j, Y') }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <!-- User Dropdown -->
                        @auth
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" type="button"
                                    class="flex items-center gap-3 p-2 pr-4 text-slate-700 rounded-xl hover:bg-indigo-50">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <span
                                            class="text-sm font-bold text-white">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</span>
                                    </div>
                                    <div class="hidden md:block text-left">
                                        <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name ?? 'User' }}
                                        </p>
                                        <p class="text-xs text-slate-500">Administrator</p>
                                    </div>
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="open" @click.away="open = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="absolute right-0 z-50 mt-2 w-64 origin-top-right rounded-2xl bg-white shadow-2xl ring-1 ring-slate-200 border border-slate-100"
                                    style="display: none;">
                                    <div
                                        class="p-4 border-b border-slate-100 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-t-2xl">
                                        <p class="text-sm font-bold text-slate-900">{{ auth()->user()->name ?? 'User' }}</p>
                                        <p class="text-xs text-slate-600 mt-0.5">{{ auth()->user()->email ??
                                            'user@example.com' }}</p>
                                    </div>
                                    <div class="py-2">
                                        <a href="#"
                                            class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Profile Settings
                                        </a>
                                        <a href="#"
                                            class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Account Settings
                                        </a>
                                    </div>
                                    <div class="border-t border-slate-100 p-2">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="flex items-center gap-3 w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 rounded-xl transition-colors font-medium">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                                Sign out
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="p-8 min-h-screen bg-slate-50">
            {{ $slot }}
        </main>

        <!-- Professional Footer -->
        <footer class="bg-white border-t border-slate-200 mt-auto">
            <div class="px-8 py-5">
                <div class="flex items-center justify-between text-sm text-slate-600">
                    <div>
                        <p class="font-medium">© {{ date('Y') }} Amazing Laundry Qatar. All rights reserved.</p>
                        <p class="text-xs text-slate-500 mt-1">Street 18, Al-Attiya Market, Industrial Area, Doha, Qatar
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-slate-500">Tel: 33813886</p>
                        <p class="text-xs text-slate-500">amazinglaundry82@gmail.com</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @livewireScripts
</body>

</html>