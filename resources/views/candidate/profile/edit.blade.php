<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4 animate-fade-in-up">
            <a href="{{ route('candidate.profile.index') }}" class="w-12 h-12 bg-white rounded-2xl shadow-tactile flex items-center justify-center hover:shadow-tactile-hover hover:-translate-y-0.5 transition-all duration-300 group">
                <i class="fas fa-arrow-left text-mono-500 group-hover:text-obsidian transition-colors"></i>
            </a>
            <div class="w-14 h-14 bg-white rounded-2xl shadow-tactile flex items-center justify-center animate-float">
                <i class="fas fa-edit text-obsidian text-xl"></i>
            </div>
            <div>
                <h2 class="font-extrabold text-3xl text-obsidian leading-tight tracking-tight">
                    {{ __('Modifier mon CV') }}
                </h2>
                <p class="text-sm text-mono-500 font-medium tracking-wide">Mettez à jour votre profil</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            @if(session('status'))
                <div class="p-4 bg-lime-100 text-lime-800 rounded-2xl font-medium flex items-center gap-3 animate-fade-in-up">
                    <i class="fas fa-check-circle"></i>
                    {{ session('status') }}
                </div>
            @endif

            <!-- Profile Title -->
            <form action="{{ route('candidate.profile.update') }}" method="POST" class="bg-white shadow-tactile rounded-2xl p-8 animate-fade-in-up">
                @csrf
                @method('PUT')
                <h3 class="font-bold text-xl text-obsidian tracking-tight flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-lime-100 rounded-xl flex items-center justify-center shadow-pressed">
                        <i class="fas fa-user-tie text-lime-600"></i>
                    </div>
                    Titre professionnel
                </h3>
                <div class="space-y-2">
                    <x-input-label for="title" :value="__('Votre titre (ex: Développeur Fullstack, Designer UX...)')" />
                    <x-text-input id="title" name="title" type="text" class="w-full" :value="old('title', $profile?->title)" required placeholder="Développeur Fullstack PHP/Laravel" />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-obsidian text-white rounded-2xl font-bold shadow-gloss hover:shadow-gloss-hover transition-all duration-300">
                        <i class="fas fa-save mr-2"></i>Enregistrer
                    </button>
                </div>
            </form>

            <!-- Formations -->
            <div class="bg-white shadow-tactile rounded-2xl p-8 animate-fade-in-up" style="animation-delay: 0.1s;">
                <h3 class="font-bold text-xl text-obsidian tracking-tight flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center shadow-pressed">
                        <i class="fas fa-graduation-cap text-blue-600"></i>
                    </div>
                    Formations
                </h3>

                @if($profile?->formations->count() > 0)
                    <div class="space-y-3 mb-6">
                        @foreach($profile->formations as $formation)
                            <div class="flex items-center justify-between p-4 bg-mono-50 rounded-2xl">
                                <div>
                                    <p class="font-bold text-obsidian">{{ $formation->diploma }}</p>
                                    <p class="text-sm text-mono-500">{{ $formation->school }} · {{ $formation->graduation_year }}</p>
                                </div>
                                <form action="{{ route('candidate.formations.destroy', $formation) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-mono-400 hover:text-red-600 transition-colors">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('candidate.formations.store') }}" method="POST" class="space-y-4 pt-4 border-t border-mono-100">
                    @csrf
                    <p class="text-sm font-medium text-mono-500">Ajouter une formation</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <x-input-label for="diploma" :value="__('Diplôme')" />
                            <x-text-input id="diploma" name="diploma" type="text" class="w-full" required placeholder="Master en Informatique" />
                        </div>
                        <div class="space-y-2">
                            <x-input-label for="school" :value="__('École')" />
                            <x-text-input id="school" name="school" type="text" class="w-full" required placeholder="Université Paris-Saclay" />
                        </div>
                    </div>
                    <div class="space-y-2">
                        <x-input-label for="graduation_year" :value="__('Année d\'obtention')" />
                        <x-text-input id="graduation_year" name="graduation_year" type="number" class="w-full" required min="1950" max="{{ date('Y') + 5 }}" placeholder="{{ date('Y') }}" />
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Ajouter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Experiences -->
            <div class="bg-white shadow-tactile rounded-2xl p-8 animate-fade-in-up" style="animation-delay: 0.2s;">
                <h3 class="font-bold text-xl text-obsidian tracking-tight flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center shadow-pressed">
                        <i class="fas fa-briefcase text-purple-600"></i>
                    </div>
                    Expériences
                </h3>

                @if($profile?->experiences->count() > 0)
                    <div class="space-y-3 mb-6">
                        @foreach($profile->experiences as $experience)
                            <div class="flex items-start justify-between p-4 bg-mono-50 rounded-2xl">
                                <div>
                                    <p class="font-bold text-obsidian">{{ $experience->position }}</p>
                                    <p class="text-sm text-mono-500">{{ $experience->company }}</p>
                                    <p class="text-xs text-mono-400 mt-1">
                                        {{ $experience->start_date->format('M Y') }} - {{ $experience->end_date ? $experience->end_date->format('M Y') : 'Présent' }}
                                    </p>
                                </div>
                                <form action="{{ route('candidate.experiences.destroy', $experience) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-mono-400 hover:text-red-600 transition-colors">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('candidate.experiences.store') }}" method="POST" class="space-y-4 pt-4 border-t border-mono-100">
                    @csrf
                    <p class="text-sm font-medium text-mono-500">Ajouter une expérience</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <x-input-label for="position" :value="__('Poste')" />
                            <x-text-input id="position" name="position" type="text" class="w-full" required placeholder="Développeur Fullstack" />
                        </div>
                        <div class="space-y-2">
                            <x-input-label for="company" :value="__('Entreprise')" />
                            <x-text-input id="company" name="company" type="text" class="w-full" required placeholder="TechCorp" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <x-input-label for="start_date" :value="__('Date de début')" />
                            <x-text-input id="start_date" name="start_date" type="date" class="w-full" required />
                        </div>
                        <div class="space-y-2">
                            <x-input-label for="end_date" :value="__('Date de fin (laisser vide si en cours)')" />
                            <x-text-input id="end_date" name="end_date" type="date" class="w-full" />
                        </div>
                    </div>
                    <div class="space-y-2">
                        <x-input-label for="exp_description" :value="__('Description (optionnel)')" />
                        <textarea id="exp_description" name="description" rows="3" class="w-full bg-mono-50 border-2 border-transparent focus:bg-white focus:border-obsidian focus:ring-0 rounded-2xl shadow-pressed text-obsidian transition-all duration-300 font-medium py-3.5 px-5" placeholder="Décrivez vos missions..."></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-5 py-2.5 bg-purple-600 text-white rounded-xl font-bold hover:bg-purple-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Ajouter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Skills -->
            <div class="bg-white shadow-tactile rounded-2xl p-8 animate-fade-in-up" style="animation-delay: 0.3s;">
                <h3 class="font-bold text-xl text-obsidian tracking-tight flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-lime-100 rounded-xl flex items-center justify-center shadow-pressed">
                        <i class="fas fa-code text-lime-600"></i>
                    </div>
                    Compétences
                </h3>

                <form action="{{ route('candidate.skills.sync') }}" method="POST" class="space-y-6">
                    @csrf
                    @if($allSkills->count() > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach($allSkills as $skill)
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="skills[]" value="{{ $skill->id }}" class="hidden peer" {{ $profile?->skills->contains($skill) ? 'checked' : '' }}>
                                    <span class="inline-flex items-center px-4 py-2 bg-mono-100 text-mono-600 rounded-full text-sm font-bold peer-checked:bg-lime-500 peer-checked:text-white transition-colors">
                                        {{ $skill->name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    @endif

                    <div class="pt-4 border-t border-mono-100">
                        <p class="text-sm font-medium text-mono-500 mb-4">Ajouter une nouvelle compétence</p>
                        <div class="flex gap-3">
                            <x-text-input name="new_skill" type="text" class="flex-1" placeholder="Ex: Vue.js, Docker..." />
                            <button type="submit" class="px-5 py-2.5 bg-lime-600 text-white rounded-xl font-bold hover:bg-lime-700 transition-colors whitespace-nowrap">
                                <i class="fas fa-plus mr-2"></i>Ajouter
                            </button>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-obsidian text-white rounded-2xl font-bold shadow-gloss hover:shadow-gloss-hover transition-all duration-300">
                            <i class="fas fa-save mr-2"></i>Enregistrer les compétences
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
