<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4 animate-fade-in-up">
            <a href="{{ route('jobs.my') }}" class="w-12 h-12 bg-white rounded-2xl shadow-tactile flex items-center justify-center hover:shadow-tactile-hover hover:-translate-y-0.5 transition-all duration-300 group">
                <i class="fas fa-arrow-left text-mono-500 group-hover:text-obsidian transition-colors"></i>
            </a>
            <div class="w-14 h-14 bg-white rounded-2xl shadow-tactile flex items-center justify-center animate-float">
                <i class="fas fa-edit text-obsidian text-xl"></i>
            </div>
            <div>
                <h2 class="font-extrabold text-3xl text-obsidian leading-tight tracking-tight">
                    {{ __('Modifier l\'offre') }}
                </h2>
                <p class="text-sm text-mono-500 font-medium tracking-wide">{{ $job->title }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('jobs.update', $job) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="bg-white shadow-tactile rounded-2xl p-8 space-y-6 animate-fade-in-up">
                    <h3 class="font-bold text-xl text-obsidian tracking-tight flex items-center gap-3">
                        <div class="w-10 h-10 bg-mono-50 rounded-xl flex items-center justify-center shadow-pressed">
                            <i class="fas fa-info-circle text-mono-600"></i>
                        </div>
                        Informations générales
                    </h3>

                    <div class="space-y-2">
                        <x-input-label for="title" :value="__('Titre du poste')" />
                        <x-text-input id="title" name="title" type="text" class="w-full" :value="old('title', $job->title)" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <x-input-label for="contract_type" :value="__('Type de contrat')" />
                            <select id="contract_type" name="contract_type" class="w-full bg-mono-50 border-2 border-transparent focus:bg-white focus:border-obsidian focus:ring-0 rounded-2xl shadow-pressed text-obsidian transition-all duration-300 font-medium py-3.5 px-5">
                                <option value="CDI" {{ old('contract_type', $job->contract_type) == 'CDI' ? 'selected' : '' }}>CDI</option>
                                <option value="CDD" {{ old('contract_type', $job->contract_type) == 'CDD' ? 'selected' : '' }}>CDD</option>
                                <option value="Stage" {{ old('contract_type', $job->contract_type) == 'Stage' ? 'selected' : '' }}>Stage</option>
                                <option value="Alternance" {{ old('contract_type', $job->contract_type) == 'Alternance' ? 'selected' : '' }}>Alternance</option>
                                <option value="Freelance" {{ old('contract_type', $job->contract_type) == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <x-input-label for="specialty" :value="__('Domaine')" />
                            <x-text-input id="specialty" name="specialty" type="text" class="w-full" :value="old('specialty', $job->specialty)" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <x-input-label for="company" :value="__('Entreprise')" />
                            <x-text-input id="company" name="company" type="text" class="w-full" :value="old('company', $job->company)" required />
                        </div>

                        <div class="space-y-2">
                            <x-input-label for="location" :value="__('Localisation')" />
                            <x-text-input id="location" name="location" type="text" class="w-full" :value="old('location', $job->location)" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="description" :value="__('Description du poste')" />
                        <textarea id="description" name="description" rows="8" class="w-full bg-mono-50 border-2 border-transparent focus:bg-white focus:border-obsidian focus:ring-0 rounded-2xl shadow-pressed text-obsidian transition-all duration-300 font-medium py-3.5 px-5" required>{{ old('description', $job->description) }}</textarea>
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="image" :value="__('Nouvelle image (optionnel)')" />
                        @if($job->image)
                            <div class="mb-3">
                                <img src="{{ $job->image_url }}" alt="Current" class="w-40 h-24 object-cover rounded-xl">
                            </div>
                        @endif
                        <input type="file" id="image" name="image" accept="image/*" class="w-full bg-mono-50 border-2 border-transparent focus:bg-white focus:border-obsidian focus:ring-0 rounded-2xl shadow-pressed text-obsidian transition-all duration-300 font-medium py-3 px-5 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-obsidian file:text-white" />
                    </div>
                </div>

                <div class="flex justify-between">
                    <form action="{{ route('jobs.destroy', $job) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-3 bg-red-100 text-red-700 rounded-2xl font-bold hover:bg-red-200 transition-all duration-300">
                            <i class="fas fa-trash mr-2"></i>
                            Supprimer
                        </button>
                    </form>
                    <div class="flex gap-4">
                        <a href="{{ route('jobs.my') }}" class="px-6 py-3 bg-white border-2 border-mono-200 rounded-2xl font-bold text-mono-600 hover:bg-mono-50 transition-all duration-300">
                            Annuler
                        </a>
                        <button type="submit" class="px-8 py-3 bg-obsidian text-white rounded-2xl font-bold shadow-gloss hover:shadow-gloss-hover hover:-translate-y-0.5 transition-all duration-300">
                            <i class="fas fa-save mr-2"></i>
                            Enregistrer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
