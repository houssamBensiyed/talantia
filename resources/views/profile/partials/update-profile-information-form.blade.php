<section>
    <header class="flex items-center gap-5 mb-8">
        <div class="w-14 h-14 bg-mono-50 rounded-2xl flex items-center justify-center shadow-pressed">
            <i class="fas fa-id-card text-obsidian text-xl"></i>
        </div>
        <div>
            <h2 class="text-xl font-bold text-obsidian tracking-tight">
                {{ __('Informations du profil') }}
            </h2>
            <p class="text-sm text-mono-500 font-medium">
                {{ __("Mettez à jour votre photo, nom et autres informations.") }}
            </p>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Photo Upload -->
        <div class="flex items-center gap-6 p-6 bg-mono-50 rounded-2xl shadow-pressed">
            <div class="relative">
                <img src="{{ $user->photo_url }}" alt="{{ $user->name }}" 
                     class="w-28 h-28 rounded-2xl object-cover border-4 border-white shadow-tactile" 
                     id="photo-preview">
                <label for="photo" class="absolute -bottom-2 -right-2 w-10 h-10 bg-obsidian rounded-xl flex items-center justify-center cursor-pointer shadow-gloss hover:shadow-gloss-hover hover:scale-105 transition-all duration-200 group">
                    <i class="fas fa-camera text-white text-sm group-hover:scale-110 transition-transform"></i>
                </label>
                <input type="file" name="photo" id="photo" class="hidden" accept="image/*" onchange="previewPhoto(this)">
            </div>
            <div>
                <p class="text-base font-bold text-obsidian">Photo de profil</p>
                <p class="text-sm text-mono-500 mt-1">JPG, PNG ou GIF. Max 2MB.</p>
                <x-input-error class="mt-2" :messages="$errors->get('photo')" />
            </div>
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nom complet')" />
            <x-text-input id="name" name="name" type="text" class="mt-2 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" placeholder="Jean Dupont" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Adresse email')" />
            <x-text-input id="email" name="email" type="email" class="mt-2 block w-full" :value="old('email', $user->email)" required autocomplete="username" placeholder="vous@exemple.com" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-4 bg-mono-50 rounded-xl border border-mono-200">
                    <p class="text-sm text-mono-700">
                        <i class="fas fa-exclamation-triangle mr-2 text-mono-500"></i>
                        {{ __('Votre adresse email n\'est pas vérifiée.') }}
                        <button form="send-verification" class="underline font-bold text-obsidian hover:text-mono-700 transition-colors duration-200 ml-1">
                            {{ __('Cliquez ici pour renvoyer l\'email de vérification.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-3 font-bold text-sm text-electric-blue flex items-center gap-2">
                            <i class="fas fa-check-circle"></i>
                            {{ __('Un nouveau lien de vérification a été envoyé.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Bio -->
        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <x-textarea id="bio" name="bio" rows="4" placeholder="Parlez-nous de vous...">{{ old('bio', $user->bio) }}</x-textarea>
            <p class="mt-2 text-xs text-mono-500 font-medium">Maximum 500 caractères</p>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <!-- Conditional Fields based on user type -->
        @if($user->isRecruiter())
            <div>
                <x-input-label for="company" :value="__('Entreprise')" />
                <x-text-input id="company" name="company" type="text" class="mt-2 block w-full" :value="old('company', $user->company)" placeholder="Nom de votre entreprise" />
                <x-input-error class="mt-2" :messages="$errors->get('company')" />
            </div>
        @else
            <div>
                <x-input-label for="specialty" :value="__('Spécialité')" />
                <x-text-input id="specialty" name="specialty" type="text" class="mt-2 block w-full" :value="old('specialty', $user->specialty)" placeholder="Ex: Développeur Web, Designer UX..." />
                <x-input-error class="mt-2" :messages="$errors->get('specialty')" />
            </div>
        @endif

        <div class="flex items-center gap-5 pt-6 border-t border-mono-100">
            <x-primary-button>
                <i class="fas fa-save mr-2"></i>
                {{ __('Enregistrer') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-electric-blue font-bold flex items-center gap-2"
                >
                    <i class="fas fa-check-circle"></i>
                    {{ __('Profil mis à jour !') }}
                </p>
            @endif
        </div>
    </form>

    <script>
        function previewPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photo-preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</section>
