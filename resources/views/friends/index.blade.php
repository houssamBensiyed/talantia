<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4 animate-fade-in-up">
            <div class="w-14 h-14 bg-white rounded-2xl shadow-tactile flex items-center justify-center animate-float">
                <i class="fas fa-user-friends text-obsidian text-xl"></i>
            </div>
            <div>
                <h2 class="font-extrabold text-3xl text-obsidian leading-tight tracking-tight">
                    {{ __('Mes amis') }}
                </h2>
                <p class="text-sm text-mono-500 font-medium tracking-wide">Gérez vos connexions</p>
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

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-2xl font-medium flex items-center gap-3 animate-fade-in-up">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Pending Friend Requests -->
            @if($pendingRequests->count() > 0)
                <div class="bg-white shadow-tactile rounded-2xl overflow-hidden mb-8 animate-fade-in-up">
                    <div class="p-6 border-b border-mono-100 bg-mono-50">
                        <h3 class="font-bold text-lg text-obsidian flex items-center gap-3">
                            <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-bell text-yellow-600"></i>
                            </div>
                            Demandes reçues ({{ $pendingRequests->count() }})
                        </h3>
                    </div>
                    <div class="divide-y divide-mono-100">
                        @foreach($pendingRequests as $request)
                            <div class="p-6 flex items-center justify-between hover:bg-mono-50 transition-colors">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $request->sender->photo_url }}" alt="{{ $request->sender->name }}" class="w-14 h-14 rounded-2xl object-cover border-2 border-mono-100">
                                    <div>
                                        <a href="{{ route('users.show', $request->sender) }}" class="font-bold text-obsidian hover:text-mono-600 transition-colors">
                                            {{ $request->sender->name }}
                                        </a>
                                        <p class="text-sm text-mono-500">
                                            {{ $request->sender->specialty ?? $request->sender->company }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <form action="{{ route('friends.accept', $request) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-5 py-2.5 bg-obsidian text-white rounded-xl font-bold hover:bg-mono-800 transition-colors">
                                            <i class="fas fa-check mr-1"></i>Accepter
                                        </button>
                                    </form>
                                    <form action="{{ route('friends.reject', $request) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-5 py-2.5 bg-mono-100 text-mono-600 rounded-xl font-bold hover:bg-mono-200 transition-colors">
                                            Refuser
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Sent Requests -->
            @if($sentRequests->count() > 0)
                <div class="bg-white shadow-tactile rounded-2xl overflow-hidden mb-8 animate-fade-in-up" style="animation-delay: 0.1s;">
                    <div class="p-6 border-b border-mono-100 bg-mono-50">
                        <h3 class="font-bold text-lg text-obsidian flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-paper-plane text-blue-600"></i>
                            </div>
                            Demandes envoyées ({{ $sentRequests->count() }})
                        </h3>
                    </div>
                    <div class="divide-y divide-mono-100">
                        @foreach($sentRequests as $request)
                            <div class="p-6 flex items-center justify-between hover:bg-mono-50 transition-colors">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $request->receiver->photo_url }}" alt="{{ $request->receiver->name }}" class="w-14 h-14 rounded-2xl object-cover border-2 border-mono-100">
                                    <div>
                                        <a href="{{ route('users.show', $request->receiver) }}" class="font-bold text-obsidian hover:text-mono-600 transition-colors">
                                            {{ $request->receiver->name }}
                                        </a>
                                        <p class="text-sm text-mono-400 italic">En attente de réponse...</p>
                                    </div>
                                </div>
                                <form action="{{ route('friends.cancel', $request) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 text-mono-500 hover:text-red-600 font-medium transition-colors">
                                        Annuler
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Friends List -->
            <div class="bg-white shadow-tactile rounded-2xl overflow-hidden animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="p-6 border-b border-mono-100 bg-mono-50">
                    <h3 class="font-bold text-lg text-obsidian flex items-center gap-3">
                        <div class="w-10 h-10 bg-lime-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-lime-600"></i>
                        </div>
                        Mes amis ({{ $friends->count() }})
                    </h3>
                </div>
                @if($friends->isEmpty())
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-mono-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user-plus text-mono-400 text-xl"></i>
                        </div>
                        <h4 class="font-bold text-obsidian mb-2">Aucun ami pour l'instant</h4>
                        <p class="text-mono-500 mb-6">Recherchez des utilisateurs pour les ajouter.</p>
                        <a href="{{ route('search.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-obsidian text-white rounded-xl font-bold hover:bg-mono-800 transition-colors">
                            <i class="fas fa-search"></i>
                            Explorer
                        </a>
                    </div>
                @else
                    <div class="divide-y divide-mono-100">
                        @foreach($friends as $friend)
                            <div class="p-6 flex items-center justify-between hover:bg-mono-50 transition-colors">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $friend->photo_url }}" alt="{{ $friend->name }}" class="w-14 h-14 rounded-2xl object-cover border-2 border-mono-100">
                                    <div>
                                        <a href="{{ route('users.show', $friend) }}" class="font-bold text-obsidian hover:text-mono-600 transition-colors">
                                            {{ $friend->name }}
                                        </a>
                                        <p class="text-sm text-mono-500">
                                            {{ $friend->isRecruiter() ? $friend->company : $friend->specialty }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('users.show', $friend) }}" class="px-4 py-2 bg-mono-100 text-mono-600 rounded-xl font-medium hover:bg-mono-200 transition-colors text-sm">
                                        Voir profil
                                    </a>
                                    <form action="{{ route('friends.remove', $friend) }}" method="POST" onsubmit="return confirm('Supprimer cet ami ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 text-mono-400 hover:text-red-600 transition-colors">
                                            <i class="fas fa-user-minus"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
