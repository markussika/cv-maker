<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="bg-white shadow rounded-lg p-8 text-center">
        <h2 class="text-3xl font-bold mb-6">Dashboard</h2>
        <p class="text-gray-600 mb-8">Manage your CVs and profile settings.</p>

        <div class="grid sm:grid-cols-3 gap-6">
            <a href="{{ route('cv.create') }}" class="block bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-4 rounded-lg shadow hover:opacity-90">Create CV</a>
            <a href="{{ route('cv.guide') }}" class="block bg-gradient-to-r from-gray-500 to-gray-700 text-white py-4 rounded-lg shadow hover:opacity-90">CV Guide</a>
            <a href="{{ route('cv.templates') }}" class="block bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 rounded-lg shadow hover:opacity-90">CV Templates</a>
        </div>
    </div>
</x-app-layout>
