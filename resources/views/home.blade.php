@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 text-center">
    <h1 class="text-4xl font-bold mb-6">Welcome to CV Maker</h1>
    <p class="text-lg mb-8">Create professional CVs online and download them as PDF.</p>

    <div class="flex flex-wrap justify-center gap-4 mb-8">
        <a href="{{ route('cv.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded shadow">Create CV</a>
        <a href="{{ route('cv.guide') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded shadow">CV Guide</a>
        <a href="{{ route('cv.templates') }}" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded shadow">Templates</a>
    </div>

    @auth
        <a href="{{ route('dashboard') }}" class="text-blue-700 hover:underline">Go to Dashboard</a>
    @else
        <div class="mt-4 flex justify-center gap-4">
            <a href="{{ route('login') }}" class="text-gray-700 hover:underline">Login</a>
            <a href="{{ route('register') }}" class="text-gray-700 hover:underline">Register</a>
        </div>
    @endauth
</div>
@endsection
