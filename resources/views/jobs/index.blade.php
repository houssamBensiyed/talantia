<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between animate-fade-in-up">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-xl shadow-card flex items-center justify-center border border-mono-200">
                    <i class="fas fa-briefcase text-obsidian text-lg"></i>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-obsidian tracking-tight">
                        {{ __('Offres d\'emploi') }}
                    </h2>
                    <p class="text-sm text-mono-500 font-medium">Découvrez les opportunités</p>
                </div>
            </div>
            @if(auth()->user()->isRecruiter())
                <a href="{{ route('jobs.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-obsidian text-white rounded-lg font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 text-sm">
                    <i class="fas fa-plus"></i>
                    Créer une offre
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
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

            <!-- 3-column layout - Full Width -->
            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- Left Sidebar: User Profile Card (Sticky) -->
                <aside class="lg:w-64 xl:w-72 flex-shrink-0">
                    <div class="lg:sticky lg:top-24 space-y-6">
                        <!-- Profile Card -->
                        <div class="bg-white border border-mono-200 rounded-xl overflow-hidden shadow-card">
                            <!-- Helper Background -->
                            <div class="h-24 bg-mono-100 relative overflow-hidden">
                                <div class="absolute inset-0 bg-pattern-grid opacity-5"></div>
                            </div>
                            
                            <!-- Profile Info -->
                            <div class="px-5 pb-5 -mt-10 relative">
                                <a href="{{ route('profile.edit') }}" class="block group">
                                    <img 
                                        src="{{ Auth::user()->photo_url }}" 
                                        alt="{{ Auth::user()->name }}"
                                        class="w-20 h-20 rounded-xl object-cover border-4 border-white shadow-sm group-hover:scale-105 transition-transform duration-300"
                                    >
                                </a>
                                <div class="mt-3">
                                    <h3 class="font-bold text-lg text-obsidian">{{ Auth::user()->name }}</h3>
                                    <p class="text-sm text-mono-500 font-medium">
                                        @if(Auth::user()->isRecruiter())
                                            {{ Auth::user()->company ?? 'Recruteur' }}
                                        @else
                                            {{ Auth::user()->specialty ?? 'Talent' }}
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="border-t border-mono-100 grid grid-cols-2 divide-x divide-mono-100">
                                @if(Auth::user()->isRecruiter())
                                    <div class="p-3 text-center hover:bg-mono-50 transition-colors">
                                        <div class="text-lg font-bold text-obsidian">{{ Auth::user()->jobOffers()->count() }}</div>
                                        <div class="text-xs text-mono-500 font-medium uppercase tracking-wide">Offres</div>
                                    </div>
                                    <div class="p-3 text-center hover:bg-mono-50 transition-colors">
                                        <div class="text-lg font-bold text-obsidian">{{ Auth::user()->jobOffers()->withCount('applications')->get()->sum('applications_count') }}</div>
                                        <div class="text-xs text-mono-500 font-medium uppercase tracking-wide">Candidatures</div>
                                    </div>
                                @else
                                    <div class="p-3 text-center hover:bg-mono-50 transition-colors">
                                        <div class="text-lg font-bold text-obsidian">{{ Auth::user()->applications()->count() }}</div>
                                        <div class="text-xs text-mono-500 font-medium uppercase tracking-wide">Candidatures</div>
                                    </div>
                                    <div class="p-3 text-center hover:bg-mono-50 transition-colors">
                                        <div class="text-lg font-bold text-obsidian">{{ Auth::user()->friends()->count() }}</div>
                                        <div class="text-xs text-mono-500 font-medium uppercase tracking-wide">Réseau</div>
                                    </div>
                                @endif
                            </div>

                            <!-- Quick Links -->
                            <div class="border-t border-mono-100 p-3">
                                @if(Auth::user()->isRecruiter())
                                    <a href="{{ route('jobs.my') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-bold text-mono-600 hover:bg-mono-50 hover:text-obsidian transition-colors">
                                        <i class="fas fa-folder-open text-mono-400 w-4"></i>
                                        Mes offres
                                    </a>
                                @else
                                    <a href="{{ route('candidate.profile.edit') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-bold text-mono-600 hover:bg-mono-50 hover:text-obsidian transition-colors">
                                        <i class="fas fa-id-card text-mono-400 w-4"></i>
                                        Mon CV
                                    </a>
                                    <a href="{{ route('applications.my') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-bold text-mono-600 hover:bg-mono-50 hover:text-obsidian transition-colors">
                                        <i class="fas fa-paper-plane text-mono-400 w-4"></i>
                                        Mes candidatures
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Main Content: Job Listings -->
                <main class="flex-1 min-w-0">
                    <livewire:job-offer-list />
                </main>

                <!-- Right Sidebar: Trending & Suggestions -->
                <aside class="hidden xl:block xl:w-72 flex-shrink-0">
                    <div class="lg:sticky lg:top-24 space-y-6">
                        <!-- Trending Specialties -->
                        <div class="bg-white border border-mono-200 rounded-xl p-5 shadow-card">
                            <h3 class="font-bold text-sm text-obsidian mb-4 flex items-center gap-2 uppercase tracking-wide">
                                <i class="fas fa-fire text-orange-500"></i>
                                Tendance
                            </h3>
                            <div class="space-y-1">
                                @php
                                    $trendingSpecialties = \App\Models\JobOffer::selectRaw('specialty, count(*) as count')
                                        ->whereNotNull('specialty')
                                        ->where('is_closed', false)
                                        ->groupBy('specialty')
                                        ->orderByDesc('count')
                                        ->limit(5)
                                        ->get();
                                @endphp
                                @forelse($trendingSpecialties as $spec)
                                    <a href="{{ route('jobs.index', ['specialty' => $spec->specialty]) }}" class="flex items-center justify-between group p-2 rounded-lg hover:bg-mono-50 transition-colors">
                                        <span class="text-sm font-medium text-mono-600 group-hover:text-obsidian transition-colors">{{ $spec->specialty }}</span>
                                        <span class="text-xs font-bold text-mono-500 bg-mono-100 px-2 py-0.5 rounded border border-mono-200 group-hover:border-obsidian/20 transition-colors">{{ $spec->count }}</span>
                                    </a>
                                @empty
                                    <p class="text-sm text-mono-500 px-2">Aucune donnée</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Recent Recruiters -->
                        <div class="bg-white border border-mono-200 rounded-xl p-5 shadow-card">
                            <h3 class="font-bold text-sm text-obsidian mb-4 flex items-center gap-2 uppercase tracking-wide">
                                <i class="fas fa-building text-electric-blue"></i>
                                Recruteurs Actifs
                            </h3>
                            <div class="space-y-3">
                                @php
                                    $activeRecruiters = \App\Models\User::where('user_type', 'recruiter')
                                        ->whereHas('jobOffers', fn($q) => $q->where('is_closed', false))
                                        ->withCount(['jobOffers' => fn($q) => $q->where('is_closed', false)])
                                        ->orderByDesc('job_offers_count')
                                        ->limit(4)
                                        ->get();
                                @endphp
                                @forelse($activeRecruiters as $recruiter)
                                    <a href="{{ route('users.show', $recruiter) }}" class="flex items-center gap-3 group p-2 -mx-2 rounded-lg hover:bg-mono-50 transition-colors">
                                        <img src="{{ $recruiter->photo_url }}" alt="{{ $recruiter->name }}" class="w-9 h-9 rounded-lg object-cover border border-mono-200">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-bold text-mono-700 group-hover:text-obsidian transition-colors truncate">{{ $recruiter->name }}</p>
                                            <p class="text-xs text-mono-500 font-medium">{{ $recruiter->job_offers_count }} offre(s)</p>
                                        </div>
                                    </a>
                                @empty
                                    <p class="text-sm text-mono-500">Aucun recruteur</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Quick Tips -->
                        <div class="bg-obsidian rounded-xl p-5 text-white shadow-lg relative overflow-hidden">
                             <div class="absolute top-0 right-0 w-24 h-24 bg-brand-accent opacity-10 rounded-full -mr-10 -mt-10"></div>
                             
                            <h3 class="font-bold text-sm mb-3 flex items-center gap-2 text-brand-accent">
                                <i class="fas fa-lightbulb"></i>
                                Conseil Pro
                            </h3>
                            @php
                                $tips = [
                                    'Personnalisez votre lettre de motivation.',
                                    'Complétez votre profil à 100%.',
                                    'Soyez réactif aux messages.',
                                    'Mettez en avant vos soft skills.',
                                ];
                                $tip = $tips[array_rand($tips)];
                            @endphp
                            <p class="text-sm text-mono-100 font-medium leading-relaxed">{{ $tip }}</p>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
