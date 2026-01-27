<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4 animate-fade-in-up">
            <div class="w-14 h-14 bg-white rounded-2xl shadow-tactile flex items-center justify-center animate-float">
                <i class="fas fa-th-large text-obsidian text-xl"></i>
            </div>
            <div>
                <h2 class="font-extrabold text-3xl text-obsidian leading-tight tracking-tight">
                    {{ __('Tableau de bord') }}
                </h2>
                <p class="text-sm text-mono-500 font-medium tracking-wide">Centre de contrôle</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white rounded-4xl shadow-tactile p-8 md:p-12 mb-10 relative overflow-hidden group hover:shadow-tactile-hover transition-all duration-500 animate-fade-in-up">
                <div class="absolute top-0 right-0 w-80 h-80 bg-mono-50 rounded-full -mr-20 -mt-20 opacity-60 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-mono-50 rounded-full -ml-24 -mb-24 opacity-40 pointer-events-none"></div>
                
                <div class="flex flex-col md:flex-row items-center gap-8 relative z-10">
                    <div class="relative animate-fade-in-scale" style="animation-delay: 0.2s;">
                        <img src="{{ Auth::user()->photo_url }}" alt="{{ Auth::user()->name }}" class="w-28 h-28 md:w-32 md:h-32 rounded-3xl object-cover border-4 border-white shadow-tactile">
                        <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-electric-blue rounded-xl flex items-center justify-center shadow-lg animate-pulse-glow">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="text-center md:text-left flex-1">
                        <h1 class="text-3xl md:text-4xl font-extrabold text-obsidian tracking-tight mb-3">
                            Bonjour, {{ Auth::user()->name }}
                        </h1>
                        <p class="text-mono-500 text-lg font-medium flex items-center justify-center md:justify-start gap-3 flex-wrap">
                            @if(Auth::user()->isRecruiter())
                                <span class="pill-badge bg-obsidian text-white shadow-gloss">
                                    <i class="fas fa-building-columns mr-2"></i>Recruteur
                                </span>
                                @if(Auth::user()->company)
                                    <span class="text-mono-400">chez</span>
                                    <span class="font-bold text-obsidian">{{ Auth::user()->company }}</span>
                                @endif
                            @else
                                <span class="pill-badge bg-obsidian text-white shadow-gloss">
                                    <i class="fas fa-rocket mr-2"></i>Talent
                                </span>
                                @if(Auth::user()->specialty)
                                    <span class="text-mono-600">{{ Auth::user()->specialty }}</span>
                                @endif
                            @endif
                        </p>
                    </div>
                    <div class="hidden md:block">
                        <a href="{{ route('profile.edit') }}">
                            <x-secondary-button class="!rounded-2xl !px-8 !py-4">
                                <i class="fas fa-sliders mr-2"></i> Paramètres
                            </x-secondary-button>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Dashboard Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                <!-- Search Users -->
                <a href="{{ route('search.index') }}" class="group bg-white rounded-4xl shadow-tactile p-8 card-3d block relative overflow-hidden animate-fade-in-up stagger-1">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-mono-50 rounded-full -mr-16 -mt-16 opacity-50 pointer-events-none group-hover:opacity-70 transition-opacity"></div>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-mono-50 rounded-2xl flex items-center justify-center mb-6 shadow-pressed group-hover:bg-obsidian group-hover:shadow-gloss transition-all duration-300">
                            <i class="fas fa-compass text-2xl transition-colors duration-300 text-obsidian group-hover:text-white"></i>
                        </div>
                        <h3 class="font-bold text-xl text-obsidian mb-3 tracking-tight">Exploration</h3>
                        <p class="text-mono-500 font-medium leading-relaxed mb-6">
                            @if(Auth::user()->isRecruiter())
                                Accéder à la base de talents.
                            @else
                                Parcourir les opportunités.
                            @endif
                        </p>
                    </div>
                    <div class="absolute bottom-8 right-8 text-mono-300 group-hover:text-obsidian transition-all duration-300 group-hover:translate-x-2">
                        <i class="fas fa-arrow-right text-xl"></i>
                    </div>
                </a>

                <!-- Edit Profile -->
                <a href="{{ route('profile.edit') }}" class="group bg-white rounded-4xl shadow-tactile p-8 card-3d block relative overflow-hidden animate-fade-in-up stagger-2">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-mono-50 rounded-full -mr-16 -mt-16 opacity-50 pointer-events-none group-hover:opacity-70 transition-opacity"></div>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-mono-50 rounded-2xl flex items-center justify-center mb-6 shadow-pressed group-hover:bg-obsidian group-hover:shadow-gloss transition-all duration-300">
                            <i class="fas fa-id-card text-2xl transition-colors duration-300 text-obsidian group-hover:text-white"></i>
                        </div>
                        <h3 class="font-bold text-xl text-obsidian mb-3 tracking-tight">Identité</h3>
                        <p class="text-mono-500 font-medium leading-relaxed mb-6">Gérer votre présence et vos informations.</p>
                    </div>
                    <div class="absolute bottom-8 right-8 text-mono-300 group-hover:text-obsidian transition-all duration-300 group-hover:translate-x-2">
                        <i class="fas fa-arrow-right text-xl"></i>
                    </div>
                </a>

                <!-- Account Stats / Completion -->
                <div class="bg-obsidian rounded-4xl shadow-gloss p-8 text-white relative overflow-hidden animate-fade-in-up stagger-3">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-white/5 rounded-full -mr-24 -mt-24 pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full -ml-16 -mb-16 pointer-events-none"></div>
                    
                    <div class="relative z-10 h-full flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-6">
                                <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                                    <i class="fas fa-chart-pie text-white text-2xl"></i>
                                </div>
                                <span class="text-sm font-mono text-mono-400">{{ Auth::user()->created_at->format('d/m/Y') }}</span>
                            </div>
                            
                            <h3 class="font-bold text-xl text-white mb-2 tracking-tight">État du profil</h3>
                            
                            @php
                                $completionItems = [
                                    'name' => !empty(Auth::user()->name),
                                    'email' => !empty(Auth::user()->email),
                                    'photo' => !empty(Auth::user()->photo),
                                    'bio' => !empty(Auth::user()->bio),
                                ];
                                if(Auth::user()->isRecruiter()) {
                                    $completionItems['company'] = !empty(Auth::user()->company);
                                } else {
                                    $completionItems['specialty'] = !empty(Auth::user()->specialty);
                                }
                                $completion = round((array_sum($completionItems) / count($completionItems)) * 100);
                            @endphp

                            <div class="mt-6">
                                <div class="flex justify-between text-sm mb-3 font-medium">
                                    <span class="text-mono-300">Complétion</span>
                                    <span class="text-electric-blue font-bold">{{ $completion }}%</span>
                                </div>
                                <div class="w-full bg-white/10 rounded-full h-3 overflow-hidden">
                                    <div class="bg-gradient-to-r from-electric-blue to-cyber-cyan h-3 rounded-full shadow-[0_0_15px_rgba(0,207,255,0.5)] transition-all duration-1000" style="width: {{ $completion }}%"></div>
                                </div>
                            </div>
                        </div>

                        @if($completion < 100)
                        <div class="mt-8 pt-6 border-t border-white/10">
                             <a href="{{ route('profile.edit') }}" class="text-sm text-mono-300 hover:text-white transition-colors flex items-center gap-2 font-medium group">
                                Terminer la configuration 
                                <i class="fas fa-chevron-right text-xs group-hover:translate-x-1 transition-transform"></i>
                             </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Quick Stats Row -->
            <div class="mt-10 grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                 <div class="bg-white rounded-3xl p-6 shadow-tactile flex flex-col items-center justify-center text-center hover:shadow-tactile-hover hover:-translate-y-1 transition-all duration-300 animate-fade-in-up stagger-4">
                     <span class="text-4xl font-extrabold text-obsidian mb-2">24</span>
                     <span class="text-xs font-bold uppercase tracking-wider text-mono-400">Vues Profil</span>
                 </div>
                 <div class="bg-white rounded-3xl p-6 shadow-tactile flex flex-col items-center justify-center text-center hover:shadow-tactile-hover hover:-translate-y-1 transition-all duration-300 animate-fade-in-up stagger-5">
                     <span class="text-4xl font-extrabold text-obsidian mb-2">12</span>
                     <span class="text-xs font-bold uppercase tracking-wider text-mono-400">Messages</span>
                 </div>
                 <div class="bg-white rounded-3xl p-6 shadow-tactile flex flex-col items-center justify-center text-center hover:shadow-tactile-hover hover:-translate-y-1 transition-all duration-300 animate-fade-in-up stagger-6">
                     <span class="text-4xl font-extrabold text-obsidian mb-2">5</span>
                     <span class="text-xs font-bold uppercase tracking-wider text-mono-400">Favoris</span>
                 </div>
                 <div class="bg-white/50 border-2 border-dashed border-mono-300 rounded-3xl p-6 flex flex-col items-center justify-center text-center hover:border-obsidian hover:bg-white cursor-pointer transition-all duration-300 group animate-fade-in-up stagger-6">
                     <i class="fas fa-plus text-mono-400 mb-2 group-hover:text-obsidian transition-colors text-lg group-hover:scale-110 transform"></i>
                     <span class="text-xs font-bold uppercase tracking-wider text-mono-400 group-hover:text-obsidian transition-colors">Ajouter</span>
                 </div>
            </div>
        </div>
    </div>
</x-app-layout>
