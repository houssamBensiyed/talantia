<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="w-16 h-16 bg-mono-50 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-pressed">
            <i class="fas fa-shield-halved text-obsidian text-2xl"></i>
        </div>
        <h1 class="text-2xl font-extrabold text-obsidian tracking-tight mb-3">Zone sécurisée</h1>
        <p class="text-sm text-mono-500 font-medium">
            {{ __('Veuillez confirmer votre mot de passe pour continuer.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full !py-4">
                <i class="fas fa-check mr-2"></i>
                {{ __('Confirmer') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
