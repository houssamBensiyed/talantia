<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4 animate-fade-in-up">
            <div class="w-14 h-14 bg-white rounded-2xl shadow-tactile flex items-center justify-center animate-float">
                <i class="fas fa-compass text-obsidian text-xl"></i>
            </div>
            <div>
                <h2 class="font-extrabold text-3xl text-obsidian leading-tight tracking-tight">
                    {{ __('Explorer') }}
                </h2>
                <p class="text-sm text-mono-500 font-medium tracking-wide">Trouvez des talents ou des recruteurs</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search Form -->
            <div class="bg-white shadow-tactile rounded-4xl overflow-hidden mb-10 relative animate-fade-in-up">
                <div class="absolute top-0 right-0 w-48 h-48 bg-mono-50 rounded-full -mr-24 -mt-24 opacity-50 pointer-events-none"></div>
                
                <form method="GET" action="{{ route('search.index') }}" class="p-6 md:p-8 relative z-10">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-5">
                        <!-- Name Search -->
                        <div class="space-y-2">
                            <x-input-label for="name" :value="__('Nom')" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-mono-400"></i>
                                </div>
                                <x-text-input id="name" name="name" type="text" class="pl-12 w-full" :value="request('name')" placeholder="Rechercher par nom..." />
                            </div>
                        </div>

                        <!-- Specialty Search -->
                        <div class="space-y-2">
                            <x-input-label for="specialty" :value="__('Spécialité')" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-briefcase text-mono-400"></i>
                                </div>
                                <x-text-input id="specialty" name="specialty" type="text" class="pl-12 w-full" :value="request('specialty')" placeholder="Ex: Développeur, Designer..." />
                            </div>
                        </div>

                        <!-- User Type Filter -->
                        <div class="space-y-2">
                            <x-input-label for="user_type" :value="__('Type')" />
                            <select id="user_type" name="user_type" class="w-full bg-mono-50 border-2 border-transparent focus:bg-white focus:border-obsidian focus:ring-0 rounded-2xl shadow-pressed text-obsidian transition-all duration-300 font-medium py-3.5 px-5 tracking-wide">
                                <option value="">Tous les profils</option>
                                <option value="job_seeker" {{ request('user_type') == 'job_seeker' ? 'selected' : '' }}>Talents</option>
                                <option value="recruiter" {{ request('user_type') == 'recruiter' ? 'selected' : '' }}>Recruteurs</option>
                            </select>
                        </div>

                        <!-- Search Button -->
                        <div class="flex items-end">
                            <x-primary-button class="w-full !py-3.5">
                                <i class="fas fa-search mr-2"></i>
                                {{ __('Rechercher') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Results -->
            @if($users->count() > 0)
                <div class="mb-8 flex items-center justify-between animate-fade-in-up" style="animation-delay: 0.1s;">
                    <p class="text-sm text-mono-600 font-medium">
                        <span class="font-extrabold text-obsidian text-lg">{{ $users->total() }}</span> 
                        {{ $users->total() > 1 ? 'résultats trouvés' : 'résultat trouvé' }}
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 md:gap-6">
                    @foreach($users as $index => $user)
                        <a href="{{ route('users.show', $user) }}" class="group bg-white shadow-tactile rounded-3xl overflow-hidden hover:shadow-tactile-hover transition-all duration-300 hover:-translate-y-2 animate-fade-in-up" style="animation-delay: {{ 0.1 + ($index * 0.05) }}s; opacity: 0;">
                            <div class="p-6 relative">
                                <div class="absolute top-0 right-0 w-20 h-20 bg-mono-50 rounded-full -mr-10 -mt-10 opacity-50 pointer-events-none group-hover:opacity-70 transition-opacity"></div>
                                
                                <!-- User Photo -->
                                <div class="flex justify-center mb-5 relative z-10">
                                    <img src="{{ $user->photo_url }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-2xl object-cover border-4 border-mono-100 shadow-tactile-sm group-hover:border-obsidian group-hover:scale-105 transition-all duration-300">
                                </div>

                                <!-- User Info -->
                                <div class="text-center relative z-10">
                                    <h3 class="font-bold text-lg text-obsidian group-hover:text-obsidian transition-colors duration-200 tracking-tight">{{ $user->name }}</h3>
                                    
                                    <!-- User Type Badge -->
                                    @if($user->isRecruiter())
                                        <span class="inline-flex items-center gap-1.5 mt-3 px-4 py-1.5 bg-obsidian text-white text-xs font-bold rounded-full uppercase tracking-wider shadow-gloss">
                                            <i class="fas fa-building-columns"></i>
                                            Recruteur
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 mt-3 px-4 py-1.5 bg-mono-100 text-obsidian text-xs font-bold rounded-full uppercase tracking-wider">
                                            <i class="fas fa-rocket"></i>
                                            Talent
                                        </span>
                                    @endif

                                    <!-- Specialty or Company -->
                                    @if($user->specialty)
                                        <p class="mt-4 text-sm text-mono-600 font-medium truncate">
                                            <i class="fas fa-code mr-2 text-mono-400"></i>
                                            {{ $user->specialty }}
                                        </p>
                                    @elseif($user->company)
                                        <p class="mt-4 text-sm text-mono-600 font-medium truncate">
                                            <i class="fas fa-building mr-2 text-mono-400"></i>
                                            {{ $user->company }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- View Profile Button -->
                            <div class="px-6 pb-6">
                                <div class="w-full py-3 text-center text-sm font-bold text-mono-500 bg-mono-50 rounded-2xl group-hover:bg-obsidian group-hover:text-white transition-all duration-300 shadow-pressed group-hover:shadow-gloss uppercase tracking-wider">
                                    <i class="fas fa-arrow-right mr-2 group-hover:translate-x-1 inline-block transition-transform"></i>
                                    Voir le profil
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-10">
                    {{ $users->links() }}
                </div>
            @else
                <!-- No Results -->
                <div class="bg-white shadow-tactile rounded-4xl p-12 md:p-16 text-center relative overflow-hidden animate-fade-in-up">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-mono-50 rounded-full -mr-24 -mt-24 opacity-50 pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-mono-50 rounded-full -ml-16 -mb-16 opacity-50 pointer-events-none"></div>
                    
                    <div class="relative z-10">
                        <div class="w-20 h-20 bg-mono-100 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-pressed">
                            <i class="fas fa-users-slash text-mono-400 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-obsidian mb-3 tracking-tight">Aucun résultat</h3>
                        <p class="text-mono-500 font-medium">Essayez de modifier vos critères de recherche.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
