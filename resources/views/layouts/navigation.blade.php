<nav x-data="{ open: false }" class="createit-navbar">
    <div class="createit-navbar__container">
        <div class="flex items-center gap-3">
            <a href="{{ route('welcome') }}" class="createit-navbar__brand">
                <img src="{{ asset('images/createit-logo.svg') }}" alt="CreateIt logo" class="h-7 w-7">
                <span>CreateIt</span>
            </a>
        </div>

        <div class="createit-navbar__nav">
            @guest
                <a href="{{ route('welcome') }}" class="createit-navbar__link">Home</a>
                <a href="{{ route('cv.templates') }}" class="createit-navbar__link">Templates</a>
            @endguest
            @auth
                <a href="{{ route('dashboard') }}" class="createit-navbar__link">Dashboard</a>
                <a href="{{ route('cv.create') }}" class="createit-navbar__link">Create CV</a>
                <a href="{{ route('cv.history') }}" class="createit-navbar__link">History</a>
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

        <button
            type="button"
            class="createit-navbar__toggle"
            aria-label="Toggle navigation"
            x-bind:aria-expanded="open"
            x-on:click="open = !open"
            x-on:keydown.escape.window="open = false"
        >
            <svg
                x-show="!open"
                x-cloak
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="h-6 w-6"
            >
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <svg
                x-show="open"
                x-cloak
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="h-6 w-6"
            >
                <path stroke-linecap="round" stroke-linejoin="round" d="m6 18 12-12M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div
        class="createit-navbar__mobile"
        x-show="open"
        x-transition:enter="createit-navbar__mobile-enter"
        x-transition:enter-start="createit-navbar__mobile-enter-start"
        x-transition:enter-end="createit-navbar__mobile-enter-end"
        x-transition:leave="createit-navbar__mobile-leave"
        x-transition:leave-start="createit-navbar__mobile-leave-start"
        x-transition:leave-end="createit-navbar__mobile-leave-end"
        x-on:click.outside="open = false"
        x-cloak
    >
        <div class="createit-navbar__mobile-nav">
            @guest
                <a href="{{ route('welcome') }}" class="createit-navbar__mobile-link">Home</a>
                <a href="{{ route('cv.templates') }}" class="createit-navbar__mobile-link">Templates</a>
            @endguest
            @auth
                <a href="{{ route('dashboard') }}" class="createit-navbar__mobile-link">Dashboard</a>
                <a href="{{ route('cv.create') }}" class="createit-navbar__mobile-link">Create CV</a>
                <a href="{{ route('cv.history') }}" class="createit-navbar__mobile-link">History</a>
                <a href="{{ route('cv.guide') }}" class="createit-navbar__mobile-link">Guide</a>
                <a href="{{ route('cv.templates') }}" class="createit-navbar__mobile-link">Templates</a>
                <a href="{{ route('profile.edit') }}" class="createit-navbar__mobile-link">Profile</a>
            @endauth
        </div>

        <div class="createit-navbar__mobile-actions">
            @guest
                <a href="{{ route('login') }}" class="createit-navbar__mobile-link">Login</a>
                <a href="{{ route('register') }}" class="createit-navbar__mobile-primary">Register</a>
            @else
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="createit-navbar__mobile-link">Logout</button>
                </form>
            @endguest
        </div>
    </div>
</nav>

<div class="h-16 md:h-20"></div>
