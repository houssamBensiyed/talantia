<div>
    @if($status === 'self')
        {{-- Don't show anything for self --}}
    @elseif($status === 'friends')
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 text-sm font-medium">
                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
                Amis
            </span>
            <button 
                wire:click="removeFriend"
                wire:confirm="Êtes-vous sûr de vouloir supprimer cet ami ?"
                class="p-1.5 text-gray-400 hover:text-red-500 transition-colors"
                title="Supprimer l'ami"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @elseif($status === 'pending_sent')
        <button 
            wire:click="cancelRequest"
            class="inline-flex items-center px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors"
        >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Demande envoyée
        </button>
    @elseif($status === 'pending_received')
        <div class="flex items-center gap-2">
            <button 
                wire:click="acceptRequest"
                class="inline-flex items-center px-4 py-2 rounded-lg bg-lime-500 text-gray-900 text-sm font-medium hover:bg-lime-400 transition-colors"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Accepter
            </button>
            <button 
                wire:click="rejectRequest"
                class="inline-flex items-center px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-red-100 dark:hover:bg-red-900 hover:text-red-700 dark:hover:text-red-300 transition-colors"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Refuser
            </button>
        </div>
    @else
        <button 
            wire:click="sendRequest"
            class="inline-flex items-center px-4 py-2 rounded-lg bg-lime-500 text-gray-900 text-sm font-medium hover:bg-lime-400 transition-colors"
        >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Ajouter en ami
        </button>
    @endif
</div>
