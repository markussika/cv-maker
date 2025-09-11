<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>
    <div class="p-6 bg-white rounded shadow space-y-2">
        <a href="{{ route('cv.create') }}" class="block bg-blue-500 text-white p-2 rounded">Create CV</a>
        <a href="{{ route('cv.guide') }}" class="block bg-gray-500 text-white p-2 rounded">CV Guide</a>
        <a href="{{ route('cv.templates') }}" class="block bg-green-500 text-white p-2 rounded">CV Templates</a>
    </div>
</x-app-layout>
