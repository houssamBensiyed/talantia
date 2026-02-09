<div>
    <!-- Filters -->
    <div class="bg-white border border-mono-200 rounded-xl p-6 shadow-card mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Search -->
            <div class="lg:col-span-2 space-y-1.5">
                <x-input-label :value="__('Rechercher')" class="!text-xs !uppercase !tracking-wider !text-mono-500" />
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-mono-400 group-focus-within:text-obsidian transition-colors"></i>
                    </div>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Titre, entreprise..."
                        class="w-full pl-10 pr-4 py-2 bg-mono-50 border border-mono-200 rounded-lg text-sm text-obsidian placeholder-mono-400 focus:border-obsidian focus:ring-0 focus:bg-white transition-all shadow-sm"
                    />
                </div>
            </div>

            <!-- Specialty -->
            <div class="space-y-1.5">
                <x-input-label :value="__('Spécialité')" class="!text-xs !uppercase !tracking-wider !text-mono-500" />
                <select wire:model.live="specialty" class="w-full py-2 bg-mono-50 border border-mono-200 rounded-lg text-sm text-obsidian focus:border-obsidian focus:ring-0 focus:bg-white transition-all shadow-sm cursor-pointer hover:border-mono-300">
                    <option value="">Toutes</option>
                    @foreach($this->specialties as $spec)
                        <option value="{{ $spec }}">{{ $spec }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Contract Type -->
            <div class="space-y-1.5">
                <x-input-label :value="__('Contrat')" class="!text-xs !uppercase !tracking-wider !text-mono-500" />
                <select wire:model.live="contractType" class="w-full py-2 bg-mono-50 border border-mono-200 rounded-lg text-sm text-obsidian focus:border-obsidian focus:ring-0 focus:bg-white transition-all shadow-sm cursor-pointer hover:border-mono-300">
                    <option value="">Tous</option>
                    <option value="CDI">CDI</option>
                    <option value="CDD">CDD</option>
                    <option value="Stage">Stage</option>
                    <option value="Alternance">Alternance</option>
                    <option value="Freelance">Freelance</option>
                </select>
            </div>

            <!-- Location -->
            <div class="space-y-1.5">
                <x-input-label :value="__('Lieu')" class="!text-xs !uppercase !tracking-wider !text-mono-500" />
                <select wire:model.live="location" class="w-full py-2 bg-mono-50 border border-mono-200 rounded-lg text-sm text-obsidian focus:border-obsidian focus:ring-0 focus:bg-white transition-all shadow-sm cursor-pointer hover:border-mono-300">
                    <option value="">Tous</option>
                    @foreach($this->locations as $loc)
                        <option value="{{ $loc }}">{{ $loc }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if($search || $specialty || $contractType || $location)
            <div class="mt-5 flex items-center justify-between pt-5 border-t border-mono-100">
                <p class="text-sm text-mono-600 font-medium">
                    <span class="font-bold text-obsidian">{{ $this->totalJobs }}</span> 
                    résultat(s)
                </p>
                <button 
                    wire:click="clearFilters"
                    class="inline-flex items-center gap-2 text-xs uppercase tracking-wide font-bold text-red-500 hover:text-red-700 transition-colors"
                >
                    <i class="fas fa-times"></i>
                    Effacer les filtres
                </button>
            </div>
        @endif
    </div>

    <!-- Results Count -->
    <div class="mb-6 flex items-center justify-between animate-fade-in-up" style="animation-delay: 0.1s;">
        <p class="text-sm text-mono-500 font-medium">
            Affichage de <span class="font-bold text-obsidian">{{ $this->jobs->count() }}</span> sur 
            <span class="font-bold text-obsidian">{{ $this->totalJobs }}</span> offres
        </p>
    </div>

    <!-- Job Listings -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($this->jobs as $index => $job)
            <a href="{{ route('jobs.show', $job) }}" wire:key="job-{{ $job->id }}" 
               class="group flex flex-col bg-white border border-mono-200 rounded-xl overflow-hidden hover:border-mono-300 hover:shadow-gloss-hover transition-all duration-300">
                
                <!-- Job Image (Top) -->
                <div class="relative w-full h-56 flex-shrink-0 overflow-hidden">
                    <img 
                        src="{{ $job->image_url }}" 
                        alt="{{ $job->title }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        loading="lazy"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-obsidian/80 via-transparent to-transparent opacity-90"></div>
                    
                    <div class="absolute top-4 right-4">
                         <span class="inline-flex items-center px-3 py-1 bg-white/95 backdrop-blur-md rounded-lg text-xs font-bold text-obsidian shadow-sm">
                            {{ $job->contract_type }}
                        </span>
                    </div>

                    <div class="absolute bottom-4 left-5 right-5">
                        <div class="flex items-center gap-2 mb-2">
                            @if($job->specialty)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-brand-accent text-obsidian">
                                    {{ $job->specialty }}
                                </span>
                            @endif
                        </div>
                        <h3 class="font-extrabold text-xl text-white group-hover:text-brand-accent transition-colors tracking-tight line-clamp-1 drop-shadow-md">
                            {{ $job->title }}
                        </h3>
                         <p class="text-white/80 text-sm font-medium mt-1 flex items-center gap-1">
                            <i class="fas fa-building text-brand-accent text-xs"></i>
                            {{ $job->company }}
                        </p>
                    </div>
                </div>

                <!-- Job Content -->
                <div class="p-6 flex flex-col flex-1">
                    <div class="flex-1">
                        <div class="flex items-start gap-3 mb-4">
                            <img src="{{ $job->recruiter->photo_url }}" alt="{{ $job->recruiter->name }}" class="w-10 h-10 rounded-xl object-cover border border-mono-100 shadow-sm">
                            <div>
                                <p class="text-xs text-mono-400 font-bold uppercase tracking-wide mb-0.5">Recruté par</p>
                                <p class="text-sm font-bold text-obsidian">{{ $job->recruiter->name }}</p>
                            </div>
                        </div>

                        <p class="text-mono-600 text-sm line-clamp-3 mb-5 leading-relaxed">
                            {{ Str::limit(strip_tags($job->description), 150) }}
                        </p>

                        @if($job->location)
                        <div class="flex items-center gap-2 mb-2">
                             <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-mono-50 rounded-lg text-xs font-bold text-mono-600">
                                <i class="fas fa-map-marker-alt text-mono-400"></i>
                                {{ $job->location }}
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="flex items-center justify-between pt-5 mt-auto border-t border-mono-100">
                        <span class="text-xs text-mono-500 font-medium">
                            Publié {{ $job->created_at->diffForHumans() }}
                        </span>
                        <div class="flex items-center gap-2 text-sm font-bold text-obsidian group-hover:text-brand-accent-hover transition-colors">
                            Voir l'offre
                            <i class="fas fa-arrow-right text-xs transform group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-1 md:col-span-2 bg-white border border-mono-200 rounded-xl p-12 text-center shadow-sm">
                <div class="w-16 h-16 bg-mono-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search text-mono-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-obsidian mb-2">Aucune offre trouvée</h3>
                <p class="text-mono-500 font-medium text-sm">Essayez d'ajuster vos filtres pour voir plus de résultats.</p>
                <button wire:click="clearFilters" class="mt-4 text-sm font-bold text-brand-accent-hover hover:underline">
                    Effacer tous les filtres
                </button>
            </div>
        @endforelse
    </div>

    <!-- Infinite scroll trigger -->
    @if($this->hasMorePages)
        <div id="infinite-scroll-trigger" class="mt-8 flex justify-center py-6">
            <div wire:loading.flex wire:target="loadMore" class="items-center gap-3 px-5 py-3 bg-white rounded-lg border border-mono-200 shadow-sm">
                <div class="w-4 h-4 border-2 border-obsidian border-t-transparent rounded-full animate-spin"></div>
                <span class="text-sm font-bold text-obsidian">Chargement...</span>
            </div>
            <div wire:loading.remove wire:target="loadMore" class="flex items-center gap-2 text-mono-400 text-xs font-bold uppercase tracking-wide animate-pulse">
                <i class="fas fa-chevron-down"></i>
                <span>Plus d'offres</span>
            </div>
        </div>
    @else
        @if($this->jobs->count() > 0)
            <div class="mt-8 text-center border-t border-mono-200 pt-8">
                <p class="text-sm font-medium text-mono-400">Vous avez atteint la fin de la liste.</p>
            </div>
        @endif
    @endif
</div>

@script
<script>
    let loading = false;
    
    const handleScroll = () => {
        // Always check if trigger element exists (means there are more pages)
        const trigger = document.getElementById('infinite-scroll-trigger');
        if (!trigger || loading) return;
        
        const scrollPosition = window.innerHeight + window.scrollY;
        const threshold = document.body.offsetHeight - 500;
        
        if (scrollPosition >= threshold) {
            loading = true;
            $wire.loadMore().then(() => {
                // Small delay before allowing next load
                setTimeout(() => {
                    loading = false;
                }, 200);
            });
        }
    };
    
    window.addEventListener('scroll', handleScroll, { passive: true });
    
    // Cleanup on component destroy
    return () => {
        window.removeEventListener('scroll', handleScroll);
    };
</script>
@endscript
