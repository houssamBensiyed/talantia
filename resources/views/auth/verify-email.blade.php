<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="w-16 h-16 bg-mono-50 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-pressed">
            <i class="fas fa-envelope text-obsidian text-2xl"></i>
        </div>
        <h1 class="text-2xl font-extrabold text-obsidian tracking-tight mb-3">Vérifiez votre email</h1>
        <p class="text-sm text-mono-500 font-medium leading-relaxed">
            {{ __('Merci de vous être inscrit ! Cliquez sur le lien que nous vous avons envoyé par email pour vérifier votre adresse.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 bg-mono-50 rounded-2xl border border-mono-200">
            <p class="font-bold text-sm text-electric-blue flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                {{ __('Un nouveau lien de vérification a été envoyé à votre adresse email.') }}
            </p>
        </div>
    @endif

    <div class="flex flex-col gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="w-full !py-4">
                <i class="fas fa-rotate-right mr-2"></i>
                {{ __('Renvoyer l\'email') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full py-3 text-center text-sm font-bold text-mono-500 hover:text-obsidian transition-colors duration-200">
                <i class="fas fa-arrow-right-from-bracket mr-2"></i>
                {{ __('Se déconnecter') }}
            </button>
        </form>
    </div>
</x-guest-layout>
