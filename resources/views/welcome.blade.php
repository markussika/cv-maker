<x-guest-layout>
    <div class="text-center mt-20">
        <h1 class="text-4xl">Welcome to CV Maker</h1>
        <p class="mt-4">Create your professional CV in minutes.</p>
        <a href="{{ route('login') }}" class="mt-4 inline-block bg-blue-500 text-white p-2 rounded">Login</a>
        <a href="{{ route('register') }}" class="mt-4 inline-block bg-green-500 text-white p-2 rounded">Register</a>
    </div>
</x-guest-layout>
