<nav class="createit-navbar">
    <div class="createit-navbar__container">
        <div class="flex items-center">
            <a href="{{ route('welcome') }}" class="createit-navbar__brand">
                <img src="{{ asset('images/createit-logo.svg') }}" alt="CreateIt logo" class="h-7 w-7">
                <span>CreateIt</span>
            </a>
        </div>

        <div class="createit-navbar__nav">
            @guest
                <a href="{{ route('welcome') }}" class="createit-navbar__link">Home</a>
            @endguest
            @auth
                <a href="{{ route('dashboard') }}" class="createit-navbar__link">Dashboard</a>
                <a href="{{ route('cv.create') }}" class="createit-navbar__link">Create CV</a>
                <a href="{{ route('cv.guide') }}" class="createit-navbar__link">Guide</a>
                <a href="{{ route('cv.templates') }}" class="createit-navbar__link">Templates</a>
                <a href="{{ route('profile.edit') }}" class="createit-navbar__link">Profile</a>
            @endauth
        </div>

        <div class="createit-navbar__actions">
            @guest
                <a href="{{ route('login') }}" class="createit-navbar__link">Login</a>
                <a href="{{ route('register') }}" class="createit-navbar__primary">Register</a>
            @else
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="createit-navbar__link">Logout</button>
                </form>
            @endguest
        </div>
    </div>
</nav>

<div class="h-16"></div>
