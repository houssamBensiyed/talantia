<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4 animate-fade-in-up">
            <a href="{{ route('applications.my') }}" class="w-12 h-12 bg-white rounded-2xl shadow-tactile flex items-center justify-center hover:shadow-tactile-hover hover:-translate-y-0.5 transition-all duration-300 group">
                <i class="fas fa-arrow-left text-mono-500 group-hover:text-obsidian transition-colors"></i>
            </a>
            <div class="w-14 h-14 bg-white rounded-2xl shadow-tactile flex items-center justify-center animate-float">
                <i class="fas fa-paper-plane text-obsidian text-xl"></i>
            </div>
            <div>
                <h2 class="font-extrabold text-3xl text-obsidian leading-tight tracking-tight">
                    {{ __('Mes candidatures') }}
                </h2>
                <p class="text-sm text-mono-500 font-medium tracking-wide">Suivez vos opportunités</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-6 p-4 bg-lime-100 text-lime-800 rounded-2xl font-medium flex items-center gap-3 animate-fade-in-up">
                    <i class="fas fa-check-circle"></i>
                    {{ session('status') }}
                </div>
            @endif

            @if($applications->isEmpty())
                <div class="bg-white shadow-tactile rounded-2xl p-12 md:p-16 text-center relative overflow-hidden animate-fade-in-up">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-mono-50 rounded-full -mr-24 -mt-24 opacity-50 pointer-events-none"></div>
                    <div class="relative z-10">
                        <div class="w-20 h-20 bg-mono-100 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-pressed">
                            <i class="fas fa-inbox text-mono-400 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-obsidian mb-3 tracking-tight">Aucune candidature</h3>
                        <p class="text-mono-500 font-medium mb-8">Parcourez les offres d'emploi pour postuler.</p>
                        <a href="{{ route('jobs.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-obsidian text-white rounded-2xl font-bold shadow-gloss hover:shadow-gloss-hover transition-all duration-300">
                            <i class="fas fa-briefcase"></i>
                            Voir les offres
                        </a>
                    </div>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($applications as $index => $application)
                        <div class="bg-white shadow-tactile rounded-xl p-6 hover:shadow-tactile-hover transition-all duration-300 animate-fade-in-up" style="animation-delay: {{ $index * 0.05 }}s;">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start gap-4">
                                    <img src="{{ $application->jobOffer->image_url }}" alt="{{ $application->jobOffer->title }}" class="w-20 h-20 rounded-2xl object-cover">
                                    <div>
                                        <a href="{{ route('jobs.show', $application->jobOffer) }}" class="font-bold text-lg text-obsidian hover:text-mono-600 transition-colors">
                                            {{ $application->jobOffer->title }}
                                        </a>
                                        <p class="text-sm text-mono-500 font-medium">
                                            <i class="fas fa-building mr-1"></i>{{ $application->jobOffer->company }} 
                                            <span class="text-mono-300">•</span> {{ $application->jobOffer->contract_type }}
                                        </p>
                                        <p class="text-xs text-mono-400 mt-1">
                                            <i class="fas fa-clock mr-1"></i>Postulé {{ $application->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    @php
                                        $statusConfig = [
                                            'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'icon' => 'fa-clock', 'label' => 'En attente'],
                                            'reviewed' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => 'fa-eye', 'label' => 'Examinée'],
                                            'accepted' => ['bg' => 'bg-lime-100', 'text' => 'text-lime-700', 'icon' => 'fa-check', 'label' => 'Acceptée'],
                                            'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => 'fa-times', 'label' => 'Refusée'],
                                        ];
                                        $config = $statusConfig[$application->status];
                                    @endphp
                                    <span class="inline-flex items-center gap-2 px-4 py-2 {{ $config['bg'] }} {{ $config['text'] }} rounded-full text-sm font-bold">
                                        <i class="fas {{ $config['icon'] }}"></i>
                                        {{ $config['label'] }}
                                    </span>
                                    @if($application->status === 'pending')
                                        <form action="{{ route('applications.destroy', $application) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir retirer cette candidature ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 bg-mono-100 text-mono-600 rounded-xl font-medium hover:bg-red-100 hover:text-red-700 transition-colors text-sm">
                                                Retirer
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $applications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
