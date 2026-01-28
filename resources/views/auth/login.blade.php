<x-guest-layout>
    <div class="mb-8 text-center animate-fade-in-down">
        <h1 class="text-3xl font-extrabold text-obsidian tracking-tight">Bon retour !</h1>
        <p class="mt-3 text-sm text-mono-500 font-medium">Connectez-vous à votre espace Talantia</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5 animate-fade-in-up" style="animation-delay: 0.1s;">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="vous@exemple.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-2">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="w-5 h-5 rounded-lg border-2 border-mono-300 text-obsidian shadow-pressed focus:ring-obsidian focus:ring-offset-2 transition-all duration-200" name="remember">
                <span class="ms-3 text-sm text-mono-500 group-hover:text-obsidian transition-colors font-medium">{{ __('Se souvenir de moi') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-bold text-mono-400 hover:text-obsidian transition-colors duration-200 link-underline" href="{{ route('password.request') }}">
                    {{ __('Mot de passe oublié ?') }}
                </a>
            @endif
        </div>

        <div class="pt-4">
            <x-primary-button class="w-full !py-4 !text-base">
                <i class="fas fa-arrow-right-to-bracket mr-2"></i>
                {{ __('Se connecter') }}
            </x-primary-button>
        </div>

        <div class="text-center pt-4">
            <p class="text-sm text-mono-500">
                {{ __("Pas encore de compte ?") }}
                <a class="font-bold text-obsidian hover:underline decoration-2 underline-offset-4 transition-all duration-200 ml-1" href="{{ route('register') }}">
                    {{ __("S'inscrire") }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
