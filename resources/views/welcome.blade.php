<x-app-layout>
    

    <div class="createit-hero">
        <h1 class="createit-hero__title">{{ __('Welcome to CreateIt') }}</h1>
        <p class="createit-hero__subtitle">{{ __('Shape vibrant CVs with playful templates, easy editing, and instant downloads that impress every reviewer.') }}</p>

        <div class="createit-hero__actions">
            <a href="{{ route('login') }}" class="createit-button--primary">{{ __('Login') }}</a>
            <a href="{{ route('register') }}" class="createit-button--outline">{{ __('Register') }}</a>
        </div>
    </div>
</x-app-layout>
