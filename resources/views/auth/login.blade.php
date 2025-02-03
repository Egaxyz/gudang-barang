<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen flex items-center justify-center bg-gradient-to-r from-purple-500 to-pink-500 relative">
    <!-- Background Blur -->
    <div class="absolute inset-0 bg-white bg-opacity-30 backdrop-blur-lg"></div>

    <div class="relative z-10 bg-white bg-opacity-80 p-8 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-semibold text-center mb-4">Login</h2>

        @if (session('error'))
            <p class="text-red-500 text-sm text-center">{{ session('error') }}</p>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700" for="user_nama">Nama:</label>
                <input type="text" name="user_nama" id="user_nama" required autocomplete="off"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700" for="user_pass">Password:</label>
                <input type="password" id="user_pass" name="user_pass" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
            </div>

            <button type="submit"
                class="w-full bg-pink-500 text-white py-2 rounded-md hover:bg-pink-600 transition-all">
                Login
            </button>
        </form>
    </div>
</body>

</html>
