<section>
    <header class="flex items-center gap-5 mb-8">
        <div class="w-14 h-14 bg-mono-50 rounded-2xl flex items-center justify-center shadow-pressed">
            <i class="fas fa-lock text-obsidian text-xl"></i>
        </div>
        <div>
            <h2 class="text-xl font-bold text-obsidian tracking-tight">
                {{ __('Modifier le mot de passe') }}
            </h2>
            <p class="text-sm text-mono-500 font-medium">
                {{ __('Utilisez un mot de passe long et sécurisé pour protéger votre compte.') }}
            </p>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Mot de passe actuel')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-2 block w-full" autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Nouveau mot de passe')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-2 block w-full" autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmer le nouveau mot de passe')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-2 block w-full" autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-5 pt-6 border-t border-mono-100">
            <x-primary-button>
                <i class="fas fa-key mr-2"></i>
                {{ __('Mettre à jour') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-electric-blue font-bold flex items-center gap-2"
                >
                    <i class="fas fa-check-circle"></i>
                    {{ __('Mot de passe mis à jour !') }}
                </p>
            @endif
        </div>
    </form>
</section>
