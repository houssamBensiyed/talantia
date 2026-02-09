<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-3xl text-obsidian tracking-tight">
                    {{ __('Tableau de bord') }}
                </h2>
                <p class="text-sm text-mono-500 font-medium mt-1">Vue d'ensemble de votre activité</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs font-bold px-3 py-1 bg-mono-100 text-mono-600 rounded-full border border-mono-200 uppercase tracking-wider">
                    {{ Auth::user()->isRecruiter() ? 'Recruteur' : 'Candidat' }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Welcome Section -->
            <div class="mb-10">
                <h1 class="text-3xl font-bold text-obsidian mb-2">Bonjour, {{ Auth::user()->name }}</h1>
                <p class="text-mono-500">Heureux de vous revoir. Voici ce qui se passe aujourd'hui.</p>
            </div>

            <!-- Dashboard Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                
                <!-- Stat Card 1 -->
                @if(Auth::user()->isRecruiter())
                    <div class="bg-white p-6 rounded-xl shadow-card hover:shadow-card-hover transition-all duration-300 border border-mono-200 group">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-mono-500 text-sm font-medium">Offres actives</span>
                            <div class="w-8 h-8 rounded-lg bg-mono-50 flex items-center justify-center text-obsidian group-hover:bg-brand-accent transition-colors">
                                <i class="fas fa-briefcase text-sm"></i>
                            </div>
                        </div>
                        <div class="text-3xl font-extrabold text-obsidian">{{ Auth::user()->jobOffers()->count() }}</div>
                        <a href="{{ route('jobs.my') }}" class="text-xs font-bold text-mono-400 mt-2 block group-hover:text-obsidian transition-colors">Gérer mes offres &rarr;</a>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-card hover:shadow-card-hover transition-all duration-300 border border-mono-200 group">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-mono-500 text-sm font-medium">Candidatures reçues</span>
                            <div class="w-8 h-8 rounded-lg bg-mono-50 flex items-center justify-center text-obsidian group-hover:bg-brand-accent transition-colors">
                                <i class="fas fa-users text-sm"></i>
                            </div>
                        </div>
                        <div class="text-3xl font-extrabold text-obsidian">
                            {{ Auth::user()->jobOffers()->withCount('applications')->get()->sum('applications_count') }}
                        </div>
                        <a href="{{ route('jobs.my') }}" class="text-xs font-bold text-mono-400 mt-2 block group-hover:text-obsidian transition-colors">Voir les candidats &rarr;</a>
                    </div>
                @else
                    <div class="bg-white p-6 rounded-xl shadow-card hover:shadow-card-hover transition-all duration-300 border border-mono-200 group">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-mono-500 text-sm font-medium">Candidatures</span>
                            <div class="w-8 h-8 rounded-lg bg-mono-50 flex items-center justify-center text-obsidian group-hover:bg-brand-accent transition-colors">
                                <i class="fas fa-paper-plane text-sm"></i>
                            </div>
                        </div>
                        <div class="text-3xl font-extrabold text-obsidian">{{ Auth::user()->applications()->count() }}</div>
                        <a href="{{ route('applications.my') }}" class="text-xs font-bold text-mono-400 mt-2 block group-hover:text-obsidian transition-colors">Voir le suivi &rarr;</a>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-card hover:shadow-card-hover transition-all duration-300 border border-mono-200 group">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-mono-500 text-sm font-medium">Connexions</span>
                            <div class="w-8 h-8 rounded-lg bg-mono-50 flex items-center justify-center text-obsidian group-hover:bg-brand-accent transition-colors">
                                <i class="fas fa-user-friends text-sm"></i>
                            </div>
                        </div>
                        <div class="text-3xl font-extrabold text-obsidian">{{ Auth::user()->friends()->count() }}</div>
                        <a href="{{ route('friends.index') }}" class="text-xs font-bold text-mono-400 mt-2 block group-hover:text-obsidian transition-colors">Voir mon réseau &rarr;</a>
                    </div>
                @endif
                
                <!-- Common Cards -->
                <div class="bg-white p-6 rounded-xl shadow-card hover:shadow-card-hover transition-all duration-300 border border-mono-200 group">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-mono-500 text-sm font-medium">Profil</span>
                        <div class="w-8 h-8 rounded-lg bg-mono-50 flex items-center justify-center text-obsidian group-hover:bg-brand-accent transition-colors">
                            <i class="fas fa-user-circle text-sm"></i>
                        </div>
                    </div>
                    
                    @php
                        $completionItems = ['name', 'email', 'photo', 'bio'];
                        if(Auth::user()->isRecruiter()) $completionItems[] = 'company';
                        else $completionItems[] = 'specialty';
                        
                        $filled = 0;
                        foreach($completionItems as $item) {
                            if(!empty(Auth::user()->$item)) $filled++;
                        }
                        $completion = round(($filled / count($completionItems)) * 100);
                    @endphp

                    <div class="flex items-end gap-2">
                         <div class="text-3xl font-extrabold text-obsidian">{{ $completion }}%</div>
                         <span class="text-sm text-mono-400 mb-1">complété</span>
                    </div>
                    
                    <a href="{{ route('profile.edit') }}" class="text-xs font-bold text-mono-400 mt-2 block group-hover:text-obsidian transition-colors">Mettre à jour &rarr;</a>
                </div>

                <a href="{{ route('search.index') }}" class="bg-obsidian p-6 rounded-xl shadow-gloss hover:shadow-gloss-hover transition-all duration-300 group flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-brand-accent opacity-10 rounded-full -mr-10 -mt-10 group-hover:scale-150 transition-transform duration-500"></div>
                    
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <span class="text-mono-300 text-sm font-medium">Explorer</span>
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white">
                            <i class="fas fa-compass text-sm"></i>
                        </div>
                    </div>
                    <div class="relative z-10">
                        <div class="text-lg font-bold text-white leading-tight mb-1">
                            {{ Auth::user()->isRecruiter() ? 'Trouver des talents' : 'Trouver un job' }}
                        </div>
                        <div class="text-xs text-mono-400">Lancer la recherche &rarr;</div>
                    </div>
                </a>
            </div>

            <!-- Quick Actions Section with clean styling -->
            <div class="bg-white rounded-xl shadow-card border border-mono-200 overflow-hidden">
                <div class="p-6 border-b border-mono-100 flex items-center justify-between">
                    <h3 class="font-bold text-lg text-obsidian">Actions Rapides</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @if(Auth::user()->isRecruiter())
                        <a href="{{ route('jobs.create') }}" class="flex items-center gap-4 p-4 rounded-lg bg-mono-50 hover:bg-brand-accent/20 border border-transparent hover:border-brand-accent transition-all duration-300 group">
                            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                                <i class="fas fa-plus text-obsidian"></i>
                            </div>
                            <div>
                                <div class="font-bold text-obsidian">Publier une offre</div>
                                <div class="text-xs text-mono-500 group-hover:text-obsidian/70">Créer une nouvelle opportunité</div>
                            </div>
                        </a>
                    @else
                        <a href="{{ route('candidate.profile.edit') }}" class="flex items-center gap-4 p-4 rounded-lg bg-mono-50 hover:bg-brand-accent/20 border border-transparent hover:border-brand-accent transition-all duration-300 group">
                            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                                <i class="fas fa-file-alt text-obsidian"></i>
                            </div>
                            <div>
                                <div class="font-bold text-obsidian">Mon CV</div>
                                <div class="text-xs text-mono-500 group-hover:text-obsidian/70">Mettre à jour mes compétences</div>
                            </div>
                        </a>
                    @endif
                    
                    <a href="{{ route('profile.show') }}" class="flex items-center gap-4 p-4 rounded-lg bg-mono-50 hover:bg-mono-100 border border-transparent transition-all duration-300 group">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                            <i class="fas fa-eye text-obsidian"></i>
                        </div>
                        <div>
                            <div class="font-bold text-obsidian">Voir mon profil public</div>
                            <div class="text-xs text-mono-500">Aperçu visible par les autres</div>
                        </div>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-4 p-4 rounded-lg bg-mono-50 hover:bg-red-50 border border-transparent hover:border-red-100 transition-all duration-300 group text-left">
                            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                                <i class="fas fa-sign-out-alt text-mono-600 group-hover:text-red-500"></i>
                            </div>
                            <div>
                                <div class="font-bold text-obsidian group-hover:text-red-700">Déconnexion</div>
                                <div class="text-xs text-mono-500 group-hover:text-red-400">Fermer la session</div>
                            </div>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
