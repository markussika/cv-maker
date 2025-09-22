<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
            Welcome
        </h2>
    </x-slot>

    <div class="text-center py-20">
        <h1 class="text-5xl font-extrabold tracking-tight text-gray-900">Welcome to CV Maker</h1>
        <p class="mt-6 text-lg text-gray-600">Design, customize, and download your professional CV in minutes.</p>

        <div class="mt-10 flex justify-center gap-6">
            <a href="{{ route('login') }}" class="bg-black text-white px-6 py-3 rounded-full hover:bg-gray-800 transition shadow">Login</a>
            <a href="{{ route('register') }}" class="bg-gradient-to-r from-green-500 to-blue-500 text-white px-6 py-3 rounded-full hover:opacity-90 transition shadow">Register</a>
        </div>
    </div>
</x-app-layout>
