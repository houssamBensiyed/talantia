<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4 animate-fade-in-up">
            <div class="w-14 h-14 bg-white rounded-2xl shadow-tactile flex items-center justify-center animate-float">
                <i class="fas fa-file-alt text-obsidian text-xl"></i>
            </div>
            <div>
                <h2 class="font-extrabold text-3xl text-obsidian leading-tight tracking-tight">
                    {{ __('Mon CV') }}
                </h2>
                <p class="text-sm text-mono-500 font-medium tracking-wide">Votre profil professionnel</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-6 p-4 bg-lime-100 text-lime-800 rounded-2xl font-medium flex items-center gap-3 animate-fade-in-up">
                    <i class="fas fa-check-circle"></i>
                    {{ session('status') }}
                </div>
            @endif

            @if(!$profile)
                <div class="bg-white shadow-tactile rounded-2xl p-12 md:p-16 text-center relative overflow-hidden animate-fade-in-up">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-mono-50 rounded-full -mr-24 -mt-24 opacity-50 pointer-events-none"></div>
                    <div class="relative z-10">
                        <div class="w-20 h-20 bg-lime-100 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-pressed">
                            <i class="fas fa-user-plus text-lime-600 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-obsidian mb-3 tracking-tight">Créez votre CV</h3>
                        <p class="text-mono-500 font-medium mb-8">Présentez-vous aux recruteurs avec un CV professionnel.</p>
                        <a href="{{ route('candidate.profile.edit') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-obsidian text-white rounded-2xl font-bold shadow-gloss hover:shadow-gloss-hover transition-all duration-300">
                            <i class="fas fa-plus"></i>
                            Créer mon CV
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-white shadow-tactile rounded-2xl overflow-hidden animate-fade-in-up">
                    <!-- Header with Title -->
                    <div class="bg-obsidian p-8 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-48 h-48 bg-white/5 rounded-full -mr-24 -mt-24"></div>
                        <div class="relative z-10 flex items-center justify-between">
                            <div class="flex items-center gap-6">
                                <img src="{{ auth()->user()->photo_url }}" alt="{{ auth()->user()->name }}" class="w-20 h-20 rounded-2xl object-cover border-4 border-white/20">
                                <div>
                                    <h1 class="text-2xl font-extrabold text-white">{{ auth()->user()->name }}</h1>
                                    <p class="text-lg text-white/80 mt-1">{{ $profile->title }}</p>
                                </div>
                            </div>
                            <a href="{{ route('candidate.profile.edit') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 text-white rounded-xl font-bold hover:bg-white/20 transition-colors">
                                <i class="fas fa-edit"></i>
                                Modifier
                            </a>
                        </div>
                    </div>

                    <div class="p-8 space-y-8">
                        <!-- Skills -->
                        @if($profile->skills->count() > 0)
                            <div>
                                <h3 class="font-bold text-lg text-obsidian mb-4 flex items-center gap-3">
                                    <div class="w-10 h-10 bg-mono-50 rounded-xl flex items-center justify-center shadow-pressed">
                                        <i class="fas fa-code text-mono-600"></i>
                                    </div>
                                    Compétences
                                </h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($profile->skills as $skill)
                                        <span class="inline-flex items-center px-4 py-2 bg-lime-100 text-lime-800 rounded-full text-sm font-bold">
                                            {{ $skill->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Formations -->
                        @if($profile->formations->count() > 0)
                            <div class="border-t border-mono-100 pt-8">
                                <h3 class="font-bold text-lg text-obsidian mb-4 flex items-center gap-3">
                                    <div class="w-10 h-10 bg-mono-50 rounded-xl flex items-center justify-center shadow-pressed">
                                        <i class="fas fa-graduation-cap text-mono-600"></i>
                                    </div>
                                    Formations
                                </h3>
                                <div class="space-y-4">
                                    @foreach($profile->formations as $formation)
                                        <div class="p-5 bg-mono-50 rounded-2xl">
                                            <p class="font-bold text-obsidian">{{ $formation->diploma }}</p>
                                            <p class="text-mono-600">{{ $formation->school }}</p>
                                            <p class="text-sm text-mono-400 mt-1">{{ $formation->graduation_year }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Experiences -->
                        @if($profile->experiences->count() > 0)
                            <div class="border-t border-mono-100 pt-8">
                                <h3 class="font-bold text-lg text-obsidian mb-4 flex items-center gap-3">
                                    <div class="w-10 h-10 bg-mono-50 rounded-xl flex items-center justify-center shadow-pressed">
                                        <i class="fas fa-briefcase text-mono-600"></i>
                                    </div>
                                    Expériences professionnelles
                                </h3>
                                <div class="space-y-4">
                                    @foreach($profile->experiences as $experience)
                                        <div class="p-5 bg-mono-50 rounded-2xl">
                                            <p class="font-bold text-obsidian">{{ $experience->position }}</p>
                                            <p class="text-mono-600">{{ $experience->company }}</p>
                                            <p class="text-sm text-mono-400 mt-1">
                                                {{ $experience->start_date->format('M Y') }} - {{ $experience->end_date ? $experience->end_date->format('M Y') : 'Présent' }}
                                            </p>
                                            @if($experience->description)
                                                <p class="text-mono-600 mt-3 text-sm">{{ $experience->description }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
