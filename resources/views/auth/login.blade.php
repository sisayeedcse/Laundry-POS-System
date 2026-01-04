<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - Laundry POS</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .login-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center login-gradient p-6">
        <div class="w-full max-w-md">
            <!-- Login Card -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <!-- Header -->
                <div class="px-8 pt-8 pb-6 text-center bg-gradient-to-br from-indigo-50 to-purple-50">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-slate-900">Amazing Laundry POS</h1>
                    <p class="text-sm text-slate-600 mt-1">Qatar Laundry Management System</p>
                </div>

                <!-- Login Form -->
                <div class="px-8 py-8">
                    <h2 class="text-xl font-semibold text-slate-900 mb-6">Sign In to Your Account</h2>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-4 p-3 bg-green-100 border border-green-200 text-green-700 rounded-lg text-sm">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-100 border border-red-200 text-red-700 rounded-lg text-sm">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">
                                Email Address
                            </label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                autocomplete="username"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        </div>

                        <!-- Password -->
                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-2">
                                Password
                            </label>
                            <input id="password" type="password" name="password" required
                                autocomplete="current-password"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center mb-6">
                            <input id="remember_me" type="checkbox" name="remember"
                                class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                            <label for="remember_me" class="ml-2 text-sm text-slate-600">
                                Remember me
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                            Sign In
                        </button>
                    </form>
                </div>

                <!-- Footer -->
                <div class="px-8 py-4 bg-slate-50 border-t border-slate-200 text-center">
                    <p class="text-xs text-slate-500">
                        &copy; {{ date('Y') }} Amazing Laundry Qatar. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>