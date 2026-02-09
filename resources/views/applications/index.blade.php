<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4 animate-fade-in-up">
            <a href="{{ route('jobs.my') }}" class="w-12 h-12 bg-white rounded-2xl shadow-tactile flex items-center justify-center hover:shadow-tactile-hover hover:-translate-y-0.5 transition-all duration-300 group">
                <i class="fas fa-arrow-left text-mono-500 group-hover:text-obsidian transition-colors"></i>
            </a>
            <div class="w-14 h-14 bg-white rounded-2xl shadow-tactile flex items-center justify-center animate-float">
                <i class="fas fa-users text-obsidian text-xl"></i>
            </div>
            <div>
                <h2 class="font-extrabold text-3xl text-obsidian leading-tight tracking-tight">
                    Candidatures
                </h2>
                <p class="text-sm text-mono-500 font-medium tracking-wide">{{ $job->title }}</p>
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

            <!-- Job Summary Card -->
            <div class="bg-white shadow-tactile rounded-xl p-6 mb-8 animate-fade-in-up">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <img src="{{ $job->image_url }}" alt="{{ $job->title }}" class="w-16 h-16 rounded-2xl object-cover">
                        <div>
                            <h3 class="font-bold text-lg text-obsidian">{{ $job->title }}</h3>
                            <p class="text-sm text-mono-500">{{ $job->contract_type }} · {{ $job->location }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-extrabold text-obsidian">{{ $applications->total() }}</p>
                        <p class="text-sm text-mono-500">candidatures</p>
                    </div>
                </div>
            </div>

            @if($applications->isEmpty())
                <div class="bg-white shadow-tactile rounded-2xl p-12 text-center relative overflow-hidden animate-fade-in-up">
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-mono-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-inbox text-mono-400 text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-lg text-obsidian mb-2">Aucune candidature</h3>
                        <p class="text-mono-500">Cette offre n'a pas encore reçu de candidatures.</p>
                    </div>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($applications as $index => $application)
                        <div class="bg-white shadow-tactile rounded-xl p-6 hover:shadow-tactile-hover transition-all duration-300 animate-fade-in-up" style="animation-delay: {{ $index * 0.05 }}s;">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start gap-4">
                                    <img src="{{ $application->applicant->photo_url }}" alt="{{ $application->applicant->name }}" class="w-16 h-16 rounded-2xl object-cover border-2 border-mono-100">
                                    <div>
                                        <a href="{{ route('applications.show', $application) }}" class="font-bold text-lg text-obsidian hover:text-mono-600 transition-colors">
                                            {{ $application->applicant->name }}
                                        </a>
                                        <p class="text-sm text-mono-500">{{ $application->applicant->specialty }}</p>
                                        <p class="text-xs text-mono-400 mt-1">
                                            <i class="fas fa-clock mr-1"></i>Postulé {{ $application->created_at->diffForHumans() }}
                                        </p>
                                        @if($application->applicant->candidateProfile)
                                            <p class="text-sm text-mono-600 mt-2">
                                                <i class="fas fa-file-alt mr-1"></i>{{ $application->applicant->candidateProfile->title }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-3">
                                    @php
                                        $statusConfig = [
                                            'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'label' => 'En attente'],
                                            'reviewed' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'label' => 'Examinée'],
                                            'accepted' => ['bg' => 'bg-lime-100', 'text' => 'text-lime-700', 'label' => 'Acceptée'],
                                            'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Refusée'],
                                        ];
                                        $config = $statusConfig[$application->status];
                                    @endphp
                                    <span class="px-4 py-2 {{ $config['bg'] }} {{ $config['text'] }} rounded-full text-sm font-bold">
                                        {{ $config['label'] }}
                                    </span>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('applications.show', $application) }}" class="px-4 py-2 bg-obsidian text-white rounded-xl text-sm font-bold hover:bg-mono-800 transition-colors">
                                            Voir CV
                                        </a>
                                        <form action="{{ route('applications.updateStatus', $application) }}" method="POST" class="flex gap-1">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()" class="text-sm bg-mono-50 border-0 rounded-xl px-3 py-2 font-medium">
                                                <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                                <option value="reviewed" {{ $application->status == 'reviewed' ? 'selected' : '' }}>Examinée</option>
                                                <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Accepter</option>
                                                <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Refuser</option>
                                            </select>
                                        </form>
                                    </div>
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
