<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Home</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto text-center py-16">
        <h1 class="text-5xl font-bold text-gray-900 mb-6">Welcome to CV Maker</h1>
        <p class="text-lg text-gray-600 mb-8">
            Create professional CVs online and download them as PDF.
        </p>

        <div class="flex flex-wrap justify-center gap-6 mb-10">
            <a href="{{ route('cv.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg shadow-md transition">Create CV</a>
            <a href="{{ route('cv.guide') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-8 py-4 rounded-lg shadow-md transition">CV Guide</a>
            <a href="{{ route('cv.templates') }}" class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-lg shadow-md transition">Templates</a>
        </div>

        @auth
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline font-semibold">Go to Dashboard →</a>
        @else
            <div class="mt-6 flex justify-center gap-6">
                <a href="{{ route('login') }}" class="text-gray-700 hover:underline">Login</a>
                <a href="{{ route('register') }}" class="text-gray-700 hover:underline">Register</a>
            </div>
        @endauth
    </div>
</x-app-layout>
