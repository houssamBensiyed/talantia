<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between animate-fade-in-up">
            <div class="flex items-center gap-4">
                <a href="{{ route('jobs.my') }}" class="w-12 h-12 bg-white rounded-2xl shadow-tactile flex items-center justify-center hover:shadow-tactile-hover hover:-translate-y-0.5 transition-all duration-300 group">
                    <i class="fas fa-arrow-left text-mono-500 group-hover:text-obsidian transition-colors"></i>
                </a>
                <div>
                    <h2 class="font-extrabold text-3xl text-obsidian leading-tight tracking-tight">
                        {{ __('Mes offres') }}
                    </h2>
                    <p class="text-sm text-mono-500 font-medium tracking-wide">Gérez vos opportunités</p>
                </div>
            </div>
            <a href="{{ route('jobs.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-obsidian text-white rounded-2xl font-bold shadow-gloss hover:shadow-gloss-hover hover:-translate-y-0.5 transition-all duration-300">
                <i class="fas fa-plus"></i>
                Nouvelle offre
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-6 p-4 bg-lime-100 text-lime-800 rounded-2xl font-medium flex items-center gap-3 animate-fade-in-up">
                    <i class="fas fa-check-circle"></i>
                    {{ session('status') }}
                </div>
            @endif

            @if($jobs->isEmpty())
                <div class="bg-white shadow-tactile rounded-2xl p-12 md:p-16 text-center relative overflow-hidden animate-fade-in-up">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-mono-50 rounded-full -mr-24 -mt-24 opacity-50 pointer-events-none"></div>
                    <div class="relative z-10">
                        <div class="w-20 h-20 bg-mono-100 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-pressed">
                            <i class="fas fa-folder-open text-mono-400 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-obsidian mb-3 tracking-tight">Aucune offre publiée</h3>
                        <p class="text-mono-500 font-medium mb-8">Créez votre première offre d'emploi.</p>
                        <a href="{{ route('jobs.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-obsidian text-white rounded-2xl font-bold shadow-gloss hover:shadow-gloss-hover transition-all duration-300">
                            <i class="fas fa-plus"></i>
                            Créer une offre
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($jobs as $index => $job)
                        <div class="bg-white shadow-tactile rounded-xl overflow-hidden hover:shadow-tactile-hover hover:-translate-y-1 transition-all duration-300 animate-fade-in-up" style="animation-delay: {{ $index * 0.05 }}s;">
                            <div class="relative">
                                <img src="{{ $job->image_url }}" alt="{{ $job->title }}" class="w-full h-40 object-cover">
                                @if($job->is_closed)
                                    <div class="absolute inset-0 bg-obsidian/70 flex items-center justify-center">
                                        <span class="px-4 py-2 bg-white rounded-full text-sm font-bold text-obsidian uppercase tracking-wider">Clôturée</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <h3 class="font-bold text-lg text-obsidian mb-2 tracking-tight">{{ $job->title }}</h3>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="inline-flex items-center px-3 py-1 bg-mono-100 rounded-full text-xs font-bold text-mono-600 uppercase tracking-wider">
                                        {{ $job->contract_type }}
                                    </span>
                                    <span class="inline-flex items-center px-3 py-1 bg-mono-100 rounded-full text-xs font-bold text-mono-600">
                                        <i class="fas fa-map-marker-alt mr-1"></i>{{ $job->location }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between text-sm text-mono-500 mb-4">
                                    <span><i class="fas fa-users mr-1"></i>{{ $job->applications()->count() }} candidatures</span>
                                    <span>{{ $job->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('jobs.show', $job) }}" class="flex-1 text-center py-2.5 bg-mono-50 rounded-xl font-bold text-mono-600 hover:bg-mono-100 transition-colors text-sm">
                                        Voir
                                    </a>
                                    <a href="{{ route('jobs.edit', $job) }}" class="flex-1 text-center py-2.5 bg-mono-50 rounded-xl font-bold text-mono-600 hover:bg-mono-100 transition-colors text-sm">
                                        Modifier
                                    </a>
                                    <a href="{{ route('jobs.applications', $job) }}" class="flex-1 text-center py-2.5 bg-obsidian rounded-xl font-bold text-white hover:bg-mono-800 transition-colors text-sm">
                                        Candidats
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $jobs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
