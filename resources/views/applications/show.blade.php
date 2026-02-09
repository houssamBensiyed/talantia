<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4 animate-fade-in-up">
            <a href="{{ route('jobs.applications', $application->jobOffer) }}" class="w-12 h-12 bg-white rounded-2xl shadow-tactile flex items-center justify-center hover:shadow-tactile-hover hover:-translate-y-0.5 transition-all duration-300 group">
                <i class="fas fa-arrow-left text-mono-500 group-hover:text-obsidian transition-colors"></i>
            </a>
            <div>
                <h2 class="font-extrabold text-3xl text-obsidian leading-tight tracking-tight">
                    {{ $application->applicant->name }}
                </h2>
                <p class="text-sm text-mono-500 font-medium tracking-wide">Candidature pour {{ $application->jobOffer->title }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-6 p-4 bg-lime-100 text-lime-800 rounded-2xl font-medium flex items-center gap-3 animate-fade-in-up">
                    <i class="fas fa-check-circle"></i>
                    {{ session('status') }}
                </div>
            @endif

            @php $user = $application->applicant; @endphp
            @php $profile = $user->candidateProfile; @endphp

            <div class="bg-white shadow-tactile rounded-2xl overflow-hidden animate-fade-in-up">
                <!-- Header -->
                <div class="bg-obsidian p-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-white/5 rounded-full -mr-24 -mt-24"></div>
                    <div class="relative z-10 flex items-center justify-between">
                        <div class="flex items-center gap-6">
                            <img src="{{ $user->photo_url }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-2xl object-cover border-4 border-white/20">
                            <div>
                                <h1 class="text-2xl font-extrabold text-white">{{ $user->name }}</h1>
                                @if($profile)
                                    <p class="text-lg text-white/80 mt-1">{{ $profile->title }}</p>
                                @endif
                                <p class="text-sm text-white/60 mt-2">
                                    <i class="fas fa-envelope mr-2"></i>{{ $user->email }}
                                </p>
                            </div>
                        </div>
                        @php
                            $statusConfig = [
                                'pending' => ['bg' => 'bg-yellow-500', 'label' => 'En attente'],
                                'reviewed' => ['bg' => 'bg-blue-500', 'label' => 'Examinée'],
                                'accepted' => ['bg' => 'bg-lime-500', 'label' => 'Acceptée'],
                                'rejected' => ['bg' => 'bg-red-500', 'label' => 'Refusée'],
                            ];
                            $config = $statusConfig[$application->status];
                        @endphp
                        <span class="px-5 py-2.5 {{ $config['bg'] }} text-white rounded-full text-sm font-bold uppercase tracking-wider">
                            {{ $config['label'] }}
                        </span>
                    </div>
                </div>

                <div class="p-8 space-y-8">
                    <!-- Cover Letter -->
                    @if($application->cover_letter)
                        <div>
                            <h3 class="font-bold text-lg text-obsidian mb-4 flex items-center gap-3">
                                <div class="w-10 h-10 bg-mono-50 rounded-xl flex items-center justify-center shadow-pressed">
                                    <i class="fas fa-envelope-open-text text-mono-600"></i>
                                </div>
                                Lettre de motivation
                            </h3>
                            <div class="p-5 bg-mono-50 rounded-2xl text-mono-700 whitespace-pre-line">
                                {{ $application->cover_letter }}
                            </div>
                        </div>
                    @endif

                    @if($profile)
                        <!-- Skills -->
                        @if($profile->skills->count() > 0)
                            <div class="border-t border-mono-100 pt-8">
                                <h3 class="font-bold text-lg text-obsidian mb-4 flex items-center gap-3">
                                    <div class="w-10 h-10 bg-mono-50 rounded-xl flex items-center justify-center shadow-pressed">
                                        <i class="fas fa-code text-mono-600"></i>
                                    </div>
                                    Compétences
                                </h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($profile->skills as $skill)
                                        <span class="inline-flex items-center px-4 py-2 bg-lime-100 text-lime-800 rounded-full text-sm font-bold">
                                            {{ $skill->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Experiences -->
                        @if($profile->experiences->count() > 0)
                            <div class="border-t border-mono-100 pt-8">
                                <h3 class="font-bold text-lg text-obsidian mb-4 flex items-center gap-3">
                                    <div class="w-10 h-10 bg-mono-50 rounded-xl flex items-center justify-center shadow-pressed">
                                        <i class="fas fa-briefcase text-mono-600"></i>
                                    </div>
                                    Expériences professionnelles
                                </h3>
                                <div class="space-y-4">
                                    @foreach($profile->experiences as $experience)
                                        <div class="p-5 bg-mono-50 rounded-2xl">
                                            <p class="font-bold text-obsidian">{{ $experience->position }}</p>
                                            <p class="text-mono-600">{{ $experience->company }}</p>
                                            <p class="text-sm text-mono-400 mt-1">
                                                {{ $experience->start_date->format('M Y') }} - {{ $experience->end_date ? $experience->end_date->format('M Y') : 'Présent' }}
                                            </p>
                                            @if($experience->description)
                                                <p class="text-mono-600 mt-3 text-sm">{{ $experience->description }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Formations -->
                        @if($profile->formations->count() > 0)
                            <div class="border-t border-mono-100 pt-8">
                                <h3 class="font-bold text-lg text-obsidian mb-4 flex items-center gap-3">
                                    <div class="w-10 h-10 bg-mono-50 rounded-xl flex items-center justify-center shadow-pressed">
                                        <i class="fas fa-graduation-cap text-mono-600"></i>
                                    </div>
                                    Formations
                                </h3>
                                <div class="space-y-4">
                                    @foreach($profile->formations as $formation)
                                        <div class="p-5 bg-mono-50 rounded-2xl">
                                            <p class="font-bold text-obsidian">{{ $formation->diploma }}</p>
                                            <p class="text-mono-600">{{ $formation->school }}</p>
                                            <p class="text-sm text-mono-400 mt-1">{{ $formation->graduation_year }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="p-8 text-center text-mono-500">
                            <i class="fas fa-file-alt text-4xl mb-4 text-mono-300"></i>
                            <p>Ce candidat n'a pas encore créé de profil CV.</p>
                        </div>
                    @endif

                    <!-- Actions -->
                    @if(auth()->id() === $application->jobOffer->user_id)
                        <div class="border-t border-mono-100 pt-8">
                            <h3 class="font-bold text-lg text-obsidian mb-4">Actions</h3>
                            <form action="{{ route('applications.updateStatus', $application) }}" method="POST" class="flex flex-wrap gap-3">
                                @csrf
                                @method('PATCH')
                                <button type="submit" name="status" value="reviewed" class="px-5 py-2.5 bg-blue-100 text-blue-700 rounded-xl font-bold hover:bg-blue-200 transition-colors {{ $application->status == 'reviewed' ? 'ring-2 ring-blue-500' : '' }}">
                                    <i class="fas fa-eye mr-2"></i>Marquer comme examinée
                                </button>
                                <button type="submit" name="status" value="accepted" class="px-5 py-2.5 bg-lime-500 text-white rounded-xl font-bold hover:bg-lime-600 transition-colors {{ $application->status == 'accepted' ? 'ring-2 ring-lime-600' : '' }}">
                                    <i class="fas fa-check mr-2"></i>Accepter
                                </button>
                                <button type="submit" name="status" value="rejected" class="px-5 py-2.5 bg-red-100 text-red-700 rounded-xl font-bold hover:bg-red-200 transition-colors {{ $application->status == 'rejected' ? 'ring-2 ring-red-500' : '' }}">
                                    <i class="fas fa-times mr-2"></i>Refuser
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
