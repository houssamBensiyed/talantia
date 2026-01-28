<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="w-16 h-16 bg-mono-50 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-pressed">
            <i class="fas fa-key text-obsidian text-2xl"></i>
        </div>
        <h1 class="text-2xl font-extrabold text-obsidian tracking-tight mb-3">Mot de passe oublié ?</h1>
        <p class="text-sm text-mono-500 font-medium leading-relaxed">
            {{ __('Pas de problème. Indiquez votre adresse email et nous vous enverrons un lien de réinitialisation.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="vous@exemple.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full !py-4">
                <i class="fas fa-paper-plane mr-2"></i>
                {{ __('Envoyer le lien') }}
            </x-primary-button>
        </div>

        <div class="text-center">
            <a href="{{ route('login') }}" class="text-sm font-bold text-mono-400 hover:text-obsidian transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>{{ __('Retour à la connexion') }}
            </a>
        </div>
    </form>
</x-guest-layout>
