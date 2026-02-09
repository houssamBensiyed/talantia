<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4 animate-fade-in-up">
            <a href="{{ route('jobs.index') }}" class="w-10 h-10 bg-white rounded-lg border border-mono-200 shadow-sm flex items-center justify-center hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group">
                <i class="fas fa-arrow-left text-mono-500 group-hover:text-obsidian transition-colors"></i>
            </a>
            <div>
                <h2 class="font-extrabold text-2xl text-obsidian tracking-tight">
                    {{ $job->title }}
                </h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-sm font-bold text-obsidian">{{ $job->company }}</span>
                    <span class="text-mono-300">•</span>
                    <span class="text-sm text-mono-500 font-medium">{{ $job->contract_type }}</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-6 p-4 bg-brand-accent/10 border border-brand-accent/20 text-obsidian rounded-lg font-medium flex items-center gap-3 animate-fade-in-up">
                    <i class="fas fa-check-circle text-lime-600"></i>
                    {{ session('status') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-700 rounded-lg font-medium flex items-center gap-3 animate-fade-in-up">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white border border-mono-200 rounded-xl overflow-hidden shadow-card animate-fade-in-up">
                <!-- Job Image Header -->
                <div class="relative h-64 md:h-80">
                    <img src="{{ $job->image_url }}" alt="{{ $job->title }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-obsidian/80 via-transparent to-transparent"></div>
                    
                    @if($job->is_closed)
                        <div class="absolute inset-0 bg-obsidian/60 backdrop-blur-sm flex items-center justify-center">
                            <span class="px-6 py-3 bg-white/90 backdrop-blur rounded-lg text-lg font-bold text-obsidian uppercase tracking-wider shadow-lg border border-white">
                                <i class="fas fa-lock mr-2"></i>Offre clôturée
                            </span>
                        </div>
                    @endif

                    <div class="absolute bottom-0 left-0 right-0 p-6 md:p-10">
                        <div class="flex flex-wrap gap-3 mb-4">
                            <span class="inline-flex items-center px-3 py-1 bg-brand-accent text-obsidian rounded-md text-sm font-bold uppercase tracking-wider shadow-sm">
                                {{ $job->contract_type }}
                            </span>
                            @if($job->specialty)
                                <span class="inline-flex items-center px-3 py-1 bg-white/20 backdrop-blur-md border border-white/30 rounded-md text-sm font-bold text-white">
                                    <i class="fas fa-tag mr-2 opacity-70"></i>{{ $job->specialty }}
                                </span>
                            @endif
                            @if($job->location)
                                <span class="inline-flex items-center px-3 py-1 bg-white/20 backdrop-blur-md border border-white/30 rounded-md text-sm font-bold text-white">
                                    <i class="fas fa-map-marker-alt mr-2 opacity-70"></i>{{ $job->location }}
                                </span>
                            @endif
                        </div>
                        <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight leading-tight">{{ $job->title }}</h1>
                    </div>
                </div>

                <div class="p-6 md:p-10 grid grid-cols-1 lg:grid-cols-3 gap-10">
                    <!-- Main Content -->
                    <div class="lg:col-span-2">
                        <div class="prose prose-lg max-w-none">
                            <h3 class="font-bold text-xl text-obsidian mb-4">À propos du poste</h3>
                            <div class="text-mono-600 whitespace-pre-line leading-relaxed">
                                {{ $job->description }}
                            </div>
                        </div>

                        <!-- Recruiter Info Block -->
                        <div class="mt-10 pt-8 border-t border-mono-200">
                             <div class="flex items-center gap-4 bg-mono-50 p-6 rounded-xl border border-mono-200">
                                <img src="{{ $job->recruiter->photo_url }}" alt="{{ $job->recruiter->name }}" class="w-16 h-16 rounded-lg object-cover border border-mono-200 shadow-sm">
                                <div>
                                    <p class="text-xs text-mono-500 uppercase tracking-wide font-bold mb-1">Publié par</p>
                                    <p class="font-bold text-lg text-obsidian">{{ $job->recruiter->name }}</p>
                                    <p class="text-sm text-mono-500">{{ $job->company }} • {{ $job->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Actions -->
                    <div class="lg:col-span-1 space-y-6">
                        @if(auth()->user()->isJobSeeker())
                            <div class="bg-mono-50 p-6 rounded-xl border border-mono-200 sticky top-24">
                                <h3 class="font-bold text-lg text-obsidian mb-2">Intéressé ?</h3>
                                <p class="text-sm text-mono-500 mb-6">Ne manquez pas cette opportunité chez {{ $job->company }}.</p>
                                
                                @if(!$job->is_closed)
                                    <div class="space-y-3">
                                        <livewire:application-button :job="$job" />
                                        <div class="text-center text-xs text-mono-400 font-medium">
                                            Postulez rapidement avec votre profil Talantia
                                        </div>
                                    </div>
                                @else
                                    <button disabled class="w-full py-3 bg-mono-200 text-mono-400 rounded-lg font-bold cursor-not-allowed">
                                        Candidatures fermées
                                    </button>
                                @endif
                            </div>
                        @elseif(auth()->id() === $job->user_id)
                            <div class="bg-mono-50 p-6 rounded-xl border border-mono-200 sticky top-24 space-y-3">
                                <h3 class="font-bold text-lg text-obsidian mb-4">Gestion de l'offre</h3>
                                
                                <a href="{{ route('jobs.edit', $job) }}" class="flex items-center justify-center gap-2 w-full py-3 bg-white border border-mono-300 rounded-lg font-bold text-obsidian hover:bg-mono-50 transition-all shadow-sm">
                                    <i class="fas fa-edit"></i>
                                    Modifier
                                </a>
                                
                                <a href="{{ route('jobs.applications', $job) }}" class="flex items-center justify-center gap-2 w-full py-3 bg-obsidian text-white rounded-lg font-bold hover:bg-obsidian-light transition-all shadow-lg">
                                    <i class="fas fa-users"></i>
                                    Candidats ({{ $job->applications()->count() }})
                                </a>

                                @if($job->is_closed)
                                    <form action="{{ route('jobs.reopen', $job) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="flex items-center justify-center gap-2 w-full py-3 bg-brand-accent text-obsidian rounded-lg font-bold hover:bg-brand-accent-hover transition-all shadow-md">
                                            <i class="fas fa-lock-open"></i>
                                            Réouvrir
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('jobs.close', $job) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="flex items-center justify-center gap-2 w-full py-3 bg-white border border-red-200 text-red-600 rounded-lg font-bold hover:bg-red-50 transition-all">
                                            <i class="fas fa-lock"></i>
                                            Clôturer
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
