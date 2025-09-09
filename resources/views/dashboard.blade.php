<x-app-layout>
    <div class="container mx-auto py-12 text-center">
        <h1 class="text-4xl font-bold mb-6">Welcome, {{ auth()->user()->name }}!</h1>
        <p class="text-lg mb-8">This is your CV Maker home page. You can create, preview, and download your CVs from here.</p>

        <div class="flex flex-wrap justify-center gap-4 mb-8">
            <a href="{{ route('cv.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded shadow">Create CV</a>
            <a href="{{ route('cv.guide') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded shadow">CV Guide</a>
            <a href="{{ route('cv.templates') }}" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded shadow">Templates</a>
        </div>

        <div class="flex justify-center gap-4">
            <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:underline">Edit Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-red-600 hover:underline">Logout</button>
            </form>
        </div>
    </div>
</x-app-layout>
