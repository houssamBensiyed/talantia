<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('search.index') }}" class="w-12 h-12 bg-white rounded-2xl shadow-tactile flex items-center justify-center hover:shadow-tactile-hover hover:-translate-y-0.5 transition-all duration-300 group">
                <i class="fas fa-arrow-left text-mono-500 group-hover:text-obsidian transition-colors"></i>
            </a>
            <div>
                <h2 class="font-extrabold text-3xl text-obsidian leading-tight tracking-tight">
                    {{ $user->name }}
                </h2>
                <p class="text-sm text-mono-500 font-medium tracking-wide flex items-center gap-2">
                    @if($user->isRecruiter())
                        <i class="fas fa-building-columns"></i>Recruteur
                    @else
                        <i class="fas fa-rocket"></i>Talent
                    @endif
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-tactile rounded-4xl overflow-hidden">
                <!-- Profile Header -->
                <div class="bg-obsidian px-10 py-14 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32 pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -ml-24 -mb-24 pointer-events-none"></div>
                    
                    <div class="flex flex-col sm:flex-row items-center gap-8 relative z-10">
                        <div class="relative">
                            <img src="{{ $user->photo_url }}" alt="{{ $user->name }}" 
                                 class="w-36 h-36 rounded-3xl object-cover border-4 border-white/20 shadow-2xl">
                            <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-electric-blue rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-check text-white text-sm"></i>
                            </div>
                        </div>
                        
                        <div class="text-center sm:text-left">
                            <h1 class="text-4xl font-extrabold text-white tracking-tight">{{ $user->name }}</h1>
                            
                            @if($user->isRecruiter())
                                <span class="inline-flex items-center gap-2 mt-4 px-5 py-2 bg-white/10 backdrop-blur-sm text-white text-sm font-bold rounded-full uppercase tracking-wider">
                                    <i class="fas fa-building-columns"></i>
                                    Recruteur
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 mt-4 px-5 py-2 bg-white/10 backdrop-blur-sm text-white text-sm font-bold rounded-full uppercase tracking-wider">
                                    <i class="fas fa-rocket"></i>
                                    Talent
                                </span>
                            @endif

                            @if($user->specialty)
                                <p class="mt-4 text-white/80 font-medium">
                                    <i class="fas fa-code mr-2"></i>{{ $user->specialty }}
                                </p>
                            @endif

                            @if($user->company)
                                <p class="mt-4 text-white/80 font-medium">
                                    <i class="fas fa-building mr-2"></i>{{ $user->company }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Profile Content -->
                <div class="p-10">
                    <!-- Bio Section -->
                    <div class="mb-10">
                        <h3 class="text-xl font-bold text-obsidian mb-5 flex items-center gap-3 tracking-tight">
                            <div class="w-10 h-10 bg-mono-50 rounded-xl flex items-center justify-center shadow-pressed">
                                <i class="fas fa-user-circle text-mono-600"></i>
                            </div>
                            À propos
                        </h3>
                        @if($user->bio)
                            <p class="text-mono-600 leading-relaxed font-medium pl-13">{{ $user->bio }}</p>
                        @else
                            <p class="text-mono-400 italic font-medium pl-13">Aucune bio renseignée.</p>
                        @endif
                    </div>

                    <!-- Details Section -->
                    <div class="border-t border-mono-100 pt-10">
                        <h3 class="text-xl font-bold text-obsidian mb-6 flex items-center gap-3 tracking-tight">
                            <div class="w-10 h-10 bg-mono-50 rounded-xl flex items-center justify-center shadow-pressed">
                                <i class="fas fa-info-circle text-mono-600"></i>
                            </div>
                            Informations
                        </h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            @if($user->isRecruiter() && $user->company)
                                <div class="flex items-center gap-5 p-5 bg-mono-50 rounded-2xl shadow-pressed hover:shadow-tactile-sm transition-all duration-300">
                                    <div class="w-14 h-14 bg-white rounded-xl flex items-center justify-center shadow-tactile-sm">
                                        <i class="fas fa-building text-obsidian text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-mono-500 font-medium">Entreprise</p>
                                        <p class="font-bold text-obsidian tracking-tight">{{ $user->company }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($user->isJobSeeker() && $user->specialty)
                                <div class="flex items-center gap-5 p-5 bg-mono-50 rounded-2xl shadow-pressed hover:shadow-tactile-sm transition-all duration-300">
                                    <div class="w-14 h-14 bg-white rounded-xl flex items-center justify-center shadow-tactile-sm">
                                        <i class="fas fa-code text-obsidian text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-mono-500 font-medium">Spécialité</p>
                                        <p class="font-bold text-obsidian tracking-tight">{{ $user->specialty }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="flex items-center gap-5 p-5 bg-mono-50 rounded-2xl shadow-pressed hover:shadow-tactile-sm transition-all duration-300">
                                <div class="w-14 h-14 bg-white rounded-xl flex items-center justify-center shadow-tactile-sm">
                                    <i class="fas fa-calendar text-obsidian text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-mono-500 font-medium">Membre depuis</p>
                                    <p class="font-bold text-obsidian tracking-tight">{{ $user->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="mt-10 pt-8 border-t border-mono-100">
                        <a href="{{ route('search.index') }}" class="inline-flex items-center gap-3 text-mono-500 hover:text-obsidian font-bold transition-colors duration-200 group">
                            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                            Retour à la recherche
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
