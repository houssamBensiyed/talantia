<div>
    @if($job->is_closed)
        <div class="inline-flex items-center px-6 py-3 rounded-2xl bg-mono-100 text-mono-400 font-bold text-sm cursor-not-allowed border border-mono-200">
            <i class="fas fa-lock mr-2"></i>
            Offre clôturée
        </div>
    @elseif(!auth()->check())
        <a 
            href="{{ route('login') }}"
            class="inline-flex items-center px-6 py-3 rounded-2xl bg-brand-accent text-obsidian font-bold hover:bg-brand-accent-hover transition-all duration-300 shadow-gloss hover:shadow-gloss-hover hover:-translate-y-0.5"
        >
            Connectez-vous pour postuler
        </a>
    @elseif(!auth()->user()->isJobSeeker())
        <div class="inline-flex items-center px-6 py-3 rounded-2xl bg-mono-100 text-mono-500 font-bold text-sm cursor-not-allowed">
            Seuls les talents peuvent postuler
        </div>
    @elseif($hasApplied)
        <div class="flex items-center gap-4">
            <span class="inline-flex items-center px-6 py-3 rounded-2xl bg-mono-800 text-white font-bold shadow-tactile-sm">
                <i class="fas fa-check-circle mr-2 text-brand-accent"></i>
                Candidature envoyée
            </span>
            <button 
                wire:click="withdrawApplication"
                wire:confirm="Êtes-vous sûr de vouloir retirer votre candidature ?"
                class="text-sm text-red-500 hover:text-red-700 font-bold underline decoration-2 underline-offset-4 transition-colors"
            >
                Retirer
            </button>
        </div>
    @else
        <button 
            wire:click="openModal"
            class="inline-flex items-center px-8 py-4 rounded-2xl bg-brand-accent text-obsidian font-bold text-lg shadow-gloss hover:shadow-gloss-hover hover:scale-105 transition-all duration-300"
        >
            <i class="fas fa-paper-plane mr-2"></i>
            Postuler maintenant
        </button>
    @endif

    <!-- Application Modal -->
    @if($showModal)
        @teleport('body')
            <div 
                class="fixed inset-0 z-[9999] overflow-y-auto" 
                aria-labelledby="modal-title" 
                role="dialog" 
                aria-modal="true"
            >
                <!-- Background overlay -->
                <div 
                    class="fixed inset-0 bg-obsidian/60 backdrop-blur-sm transition-opacity animate-fade-in"
                    wire:click="closeModal"
                ></div>

                <div class="flex items-center justify-center min-h-screen p-4">
                    <!-- Modal panel -->
                    <div class="relative bg-white rounded-2xl shadow-tactile max-w-lg w-full overflow-hidden animate-fade-in-up transform transition-all">
                        <form wire:submit="apply">
                            <!-- Header -->
                            <div class="bg-mono-50 px-8 py-6 border-b border-mono-100 flex items-center gap-4">
                                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-pressed">
                                    <i class="fas fa-briefcase text-brand-accent-hover text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-extrabold text-obsidian tracking-tight" id="modal-title">
                                        Postuler
                                    </h3>
                                    <p class="text-sm text-mono-500 font-medium truncate max-w-xs">{{ $job->title }}</p>
                                </div>
                                <button type="button" wire:click="closeModal" class="ml-auto text-mono-400 hover:text-obsidian transition-colors">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>

                            <!-- Body -->
                            <div class="p-8 space-y-6">
                                <div class="space-y-2">
                                    <x-input-label for="cover_letter" :value="__('Lettre de motivation (optionnel)')" />
                                    <x-textarea
                                        wire:model="coverLetter"
                                        id="cover_letter"
                                        rows="6"
                                        placeholder="Présentez-vous brièvement et expliquez votre intérêt pour ce poste..."
                                    ></x-textarea>
                                    @error('coverLetter') 
                                        <p class="mt-2 text-sm text-red-600 font-bold flex items-center gap-1">
                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="bg-mono-50 px-8 py-6 border-t border-mono-100 flex gap-4 justify-end">
                                <button 
                                    type="button"
                                    wire:click="closeModal"
                                    class="px-6 py-3 bg-white border-2 border-mono-200 rounded-2xl font-bold text-mono-600 hover:bg-mono-100 transition-all duration-300"
                                >
                                    Annuler
                                </button>
                                <button 
                                    type="submit"
                                    class="px-8 py-3 bg-brand-accent text-obsidian rounded-2xl font-bold shadow-gloss hover:shadow-gloss-hover hover:-translate-y-0.5 transition-all duration-300 flex items-center"
                                >
                                    <span wire:loading.remove>Envoyer</span>
                                    <span wire:loading class="flex items-center gap-2">
                                        <i class="fas fa-circle-notch fa-spin"></i> Envoi...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endteleport
    @endif
</div>
