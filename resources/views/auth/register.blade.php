<x-guest-layout>
    <div class="mb-8 text-center animate-fade-in-down">
        <h1 class="text-3xl font-extrabold text-obsidian tracking-tight">Créer un compte</h1>
        <p class="mt-3 text-sm text-mono-500 font-medium">Rejoignez Talantia pour trouver votre prochain talent ou opportunité</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5 animate-fade-in-up" style="animation-delay: 0.1s;">
        @csrf

        <!-- User Type Selection -->
        <div class="mb-2">
            <x-input-label :value="__('Je suis')" class="mb-3" />
            <div class="grid grid-cols-2 gap-4">
                <label class="relative flex cursor-pointer rounded-2xl border-2 border-mono-200 bg-mono-50/50 p-4 hover:border-mono-400 focus:outline-none transition-all duration-300 group" id="user-type-recruiter-label">
                    <input type="radio" name="user_type" value="recruiter" class="sr-only" id="user-type-recruiter" {{ old('user_type') == 'recruiter' ? 'checked' : '' }}>
                    <span class="flex flex-1 flex-col items-center text-center">
                        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-white text-mono-400 shadow-pressed transition-all duration-300 mb-2" id="recruiter-icon">
                            <i class="fas fa-building-columns text-lg"></i>
                        </span>
                        <span class="block text-sm font-bold text-obsidian group-hover:text-obsidian transition-colors">Recruteur</span>
                        <span class="mt-1 text-xs text-mono-500">Je cherche des talents</span>
                    </span>
                    <span class="pointer-events-none absolute -inset-px rounded-2xl border-2 border-transparent transition-all duration-300" id="recruiter-border" aria-hidden="true"></span>
                </label>

                <label class="relative flex cursor-pointer rounded-2xl border-2 border-mono-200 bg-mono-50/50 p-4 hover:border-mono-400 focus:outline-none transition-all duration-300 group" id="user-type-job-seeker-label">
                    <input type="radio" name="user_type" value="job_seeker" class="sr-only" id="user-type-job-seeker" {{ old('user_type') == 'job_seeker' ? 'checked' : '' }}>
                    <span class="flex flex-1 flex-col items-center text-center">
                        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-white text-mono-400 shadow-pressed transition-all duration-300 mb-2" id="job-seeker-icon">
                            <i class="fas fa-rocket text-lg"></i>
                        </span>
                        <span class="block text-sm font-bold text-obsidian group-hover:text-obsidian transition-colors">Talent</span>
                        <span class="mt-1 text-xs text-mono-500">Je cherche un emploi</span>
                    </span>
                    <span class="pointer-events-none absolute -inset-px rounded-2xl border-2 border-transparent transition-all duration-300" id="job-seeker-border" aria-hidden="true"></span>
                </label>
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
        <div class="hidden space-y-2" id="company-field">
            <x-input-label for="company" :value="__('Entreprise')" />
            <x-text-input id="company" class="block w-full" type="text" name="company" :value="old('company')" placeholder="Nom de votre entreprise" />
            <x-input-error :messages="$errors->get('company')" class="mt-2" />
        </div>

        <!-- Specialty (for Job Seekers) -->
        <div class="hidden space-y-2" id="specialty-field">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const recruiterRadio = document.getElementById('user-type-recruiter');
            const jobSeekerRadio = document.getElementById('user-type-job-seeker');
            const companyField = document.getElementById('company-field');
            const specialtyField = document.getElementById('specialty-field');
            const recruiterLabel = document.getElementById('user-type-recruiter-label');
            const jobSeekerLabel = document.getElementById('user-type-job-seeker-label');
            const recruiterIcon = document.getElementById('recruiter-icon');
            const jobSeekerIcon = document.getElementById('job-seeker-icon');
            const recruiterBorder = document.getElementById('recruiter-border');
            const jobSeekerBorder = document.getElementById('job-seeker-border');

            function updateFields() {
                // Reset styles
                recruiterLabel.classList.remove('bg-white', 'shadow-tactile', 'border-obsidian', 'scale-[1.02]');
                recruiterLabel.classList.add('bg-mono-50/50', 'border-mono-200');
                
                jobSeekerLabel.classList.remove('bg-white', 'shadow-tactile', 'border-obsidian', 'scale-[1.02]');
                jobSeekerLabel.classList.add('bg-mono-50/50', 'border-mono-200');
                
                recruiterIcon.classList.remove('bg-obsidian', 'text-white', 'shadow-gloss', 'scale-110');
                recruiterIcon.classList.add('bg-white', 'text-mono-400', 'shadow-pressed');
                
                jobSeekerIcon.classList.remove('bg-obsidian', 'text-white', 'shadow-gloss', 'scale-110');
                jobSeekerIcon.classList.add('bg-white', 'text-mono-400', 'shadow-pressed');
                
                recruiterBorder.classList.remove('border-obsidian');
                jobSeekerBorder.classList.remove('border-obsidian');

                if (recruiterRadio.checked) {
                    companyField.classList.remove('hidden');
                    specialtyField.classList.add('hidden');
                    
                    recruiterLabel.classList.remove('bg-mono-50/50', 'border-mono-200');
                    recruiterLabel.classList.add('bg-white', 'shadow-tactile', 'border-obsidian', 'scale-[1.02]');
                    
                    recruiterIcon.classList.remove('bg-white', 'text-mono-400', 'shadow-pressed');
                    recruiterIcon.classList.add('bg-obsidian', 'text-white', 'shadow-gloss', 'scale-110');
                    
                    recruiterBorder.classList.add('border-obsidian');
                } else if (jobSeekerRadio.checked) {
                    companyField.classList.add('hidden');
                    specialtyField.classList.remove('hidden');
                    
                    jobSeekerLabel.classList.remove('bg-mono-50/50', 'border-mono-200');
                    jobSeekerLabel.classList.add('bg-white', 'shadow-tactile', 'border-obsidian', 'scale-[1.02]');
                    
                    jobSeekerIcon.classList.remove('bg-white', 'text-mono-400', 'shadow-pressed');
                    jobSeekerIcon.classList.add('bg-obsidian', 'text-white', 'shadow-gloss', 'scale-110');
                    
                    jobSeekerBorder.classList.add('border-obsidian');
                } else {
                    companyField.classList.add('hidden');
                    specialtyField.classList.add('hidden');
                }
            }

            recruiterRadio.addEventListener('change', updateFields);
            jobSeekerRadio.addEventListener('change', updateFields);

            // Initialize on page load
            updateFields();
        });
    </script>
</x-guest-layout>
