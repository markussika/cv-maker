<nav class="bg-white/80 backdrop-blur-md border-b border-gray-200 shadow-sm fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- Left: Logo --}}
            <div class="flex items-center">
                <a href="{{ route('welcome') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/apple-logo.svg') }}" alt="Logo" class="h-6 w-6">
                    <span class="font-semibold text-lg tracking-tight">CV Maker</span>
                </a>
            </div>

            {{-- Center nav --}}
            <div class="hidden md:flex space-x-8 items-center">
                <a href="{{ route('welcome') }}" class="hover:text-black text-gray-700 transition">Home</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="hover:text-black text-gray-700 transition">Dashboard</a>
                    <a href="{{ route('cv.create') }}" class="hover:text-black text-gray-700 transition">Create CV</a>
                    <a href="{{ route('cv.guide') }}" class="hover:text-black text-gray-700 transition">Guide</a>
                    <a href="{{ route('cv.templates') }}" class="hover:text-black text-gray-700 transition">Templates</a>
                    <a href="{{ route('profile.edit') }}" class="hover:text-black text-gray-700 transition">Profile</a>
                @endauth
            </div>

            {{-- Right: Auth --}}
            <div class="flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="hover:text-black text-gray-700 transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-black text-white px-4 py-2 rounded-full hover:bg-gray-800 transition">Register</a>
                @else
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="hover:text-black text-gray-700 transition">Logout</button>
                    </form>
                @endguest
            </div>

        </div>
    </div>
</nav>

<div class="h-16"></div>
