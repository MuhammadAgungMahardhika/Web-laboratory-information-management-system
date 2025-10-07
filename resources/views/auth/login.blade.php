<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | {{ config('app.name', 'App') }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        html,
        body {
            height: 100%;
            overflow: hidden;
        }
    </style>
</head>

<body class="relative h-full">

    <!-- Background -->
    <div class="absolute inset-0 bg-cover bg-center brightness-50"
        style="background-image: url('{{ asset('images/jli-2.jpeg') }}');">
    </div>

    <!-- Logo -->
    <div class="absolute top-6 left-6 z-10">
        <img src="{{ asset('images/jli-logo.png') }}" alt="Logo" class="w-48 md:w-64">
    </div>

    <!-- Login Container -->
    <div class="fixed inset-0 flex items-center justify-center">
        <div class="w-full max-w-md bg-white/10 backdrop-blur-md rounded-2xl p-8 shadow-lg z-10 border border-white/20">

            <!-- Title -->
            <h2 class="text-2xl font-semibold text-center text-white mb-6">
                Login to Your Account
            </h2>

            <!-- Validation & Status -->
            @if ($errors->any())
                <div class="mb-4 text-sm text-red-400 bg-red-100/10 border border-red-300/30 p-3 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="mb-4 text-sm text-green-400 bg-green-100/10 border border-green-300/30 p-3 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 text-sm text-red-400 bg-red-100/10 border border-red-300/30 p-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-5">
                @csrf

                <!-- NIP / Email -->
                <div>
                    <label for="identity" class="block text-sm font-medium text-white mb-1">NIP / Email</label>
                    <input id="identity" name="identity" type="text" required autofocus value="{{ old('email') }}"
                        class="w-full px-3 py-2 bg-white/80 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500 focus:outline-none text-gray-800 placeholder-gray-500"
                        placeholder="Enter your NIP or email">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-white mb-1">Password</label>
                    <input id="password" name="password" type="password" required
                        class="w-full px-3 py-2 bg-white/80 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500 focus:outline-none text-gray-800 placeholder-gray-500"
                        placeholder="Enter your password">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" checked
                        class="h-4 w-4 text-green-500 focus:ring-green-500 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-white">Remember me</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="loginButton"
                    class="w-full flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md py-2.5 transition-all focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 focus:outline-none">
                    <span id="buttonText">Log in</span>
                    <span id="loadingIndicator" class="hidden items-center ml-2">
                        <svg class="animate-spin h-5 w-5 text-white me-2" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2
                5.291A7.962 7.962 0 014 12H0c0 3.042
                1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    </span>
                </button>
            </form>

        </div>
    </div>

    <script>
        // Show loading spinner on submit
        const form = document.getElementById('loginForm');
        const buttonText = document.getElementById('buttonText');
        const loadingIndicator = document.getElementById('loadingIndicator');

        form.addEventListener('submit', () => {
            buttonText.classList.add('hidden');
            loadingIndicator.classList.remove('hidden');
        });
    </script>

</body>

</html>
