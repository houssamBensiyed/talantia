<x-guest-layout>
    <div class="mb-8 text-center animate-fade-in-down">
        <h1 class="text-3xl font-extrabold text-obsidian tracking-tight">Créer un compte</h1>
        <p class="mt-3 text-sm text-mono-500 font-medium">Rejoignez Talantia pour trouver votre prochain talent ou opportunité</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5 animate-fade-in-up" style="animation-delay: 0.1s;" x-data="{ userType: '{{ old('user_type', 'recruiter') }}' }">
        @csrf

        <!-- User Type Selection -->
        <div class="mb-2">
            <x-input-label :value="__('Je suis')" class="mb-3" />
            <div class="grid grid-cols-2 gap-4" x-data="{ selected: '{{ old('user_type', 'recruiter') }}' }">
                <!-- Recruiter Option -->
                <x-radio-card 
                    value="recruiter" 
                    name="user_type" 
                    label="Recruteur" 
                    icon="fas fa-building-columns"
                    description="Je cherche des talents"
                    :checked="old('user_type') === 'recruiter'"
                    @click="userType = 'recruiter'"
                />

                <!-- Job Seeker Option -->
                <x-radio-card 
                    value="job_seeker" 
                    name="user_type" 
                    label="Talent" 
                    icon="fas fa-rocket"
                    description="Je cherche un emploi"
                    :checked="old('user_type') === 'job_seeker'"
                    @click="userType = 'job_seeker'"
                />
            </div>
            <x-input-error :messages="$errors->get('user_type')" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="space-y-2">
            <x-input-label for="name" :value="__('Nom complet')" />
            <x-text-input id="name" class="block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Jean Dupont" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="vous@exemple.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Company (for Recruiters) -->
        <div class="space-y-2" x-show="userType === 'recruiter'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <x-input-label for="company" :value="__('Entreprise')" />
            <x-text-input id="company" class="block w-full" type="text" name="company" :value="old('company')" placeholder="Nom de votre entreprise" />
            <x-input-error :messages="$errors->get('company')" class="mt-2" />
        </div>

        <!-- Specialty (for Job Seekers) -->
        <div class="space-y-2" x-show="userType === 'job_seeker'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
            <x-input-label for="specialty" :value="__('Spécialité')" />
            <x-text-input id="specialty" class="block w-full" type="text" name="specialty" :value="old('specialty')" placeholder="Ex: Développeur Web, Designer UX..." />
            <x-input-error :messages="$errors->get('specialty')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-2">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
            <x-text-input id="password_confirmation" class="block w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            <x-primary-button class="w-full !py-4 !text-base">
                <i class="fas fa-user-plus mr-2"></i>
                {{ __("S'inscrire") }}
            </x-primary-button>
        </div>

        <div class="text-center pt-2">
            <p class="text-sm text-mono-500">
                {{ __('Déjà inscrit ?') }}
                <a class="font-bold text-obsidian hover:underline decoration-2 underline-offset-4 transition-all duration-200 ml-1" href="{{ route('login') }}">
                    {{ __('Se connecter') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
