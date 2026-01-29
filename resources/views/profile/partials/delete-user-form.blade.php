<section class="space-y-6">
    <header class="flex items-center gap-5">
        <div class="w-14 h-14 bg-mono-50 rounded-2xl flex items-center justify-center shadow-pressed">
            <i class="fas fa-trash-alt text-obsidian text-xl"></i>
        </div>
        <div>
            <h2 class="text-xl font-bold text-obsidian tracking-tight">
                {{ __('Supprimer le compte') }}
            </h2>
            <p class="text-sm text-mono-500 font-medium">
                {{ __('Une fois supprimé, toutes vos données seront perdues définitivement.') }}
            </p>
        </div>
    </header>

    <div class="p-5 bg-mono-50 rounded-2xl border border-mono-200">
        <p class="text-sm text-mono-700 font-medium">
            <i class="fas fa-exclamation-triangle mr-2 text-mono-500"></i>
            {{ __('Avant de supprimer votre compte, téléchargez les données que vous souhaitez conserver.') }}
        </p>
    </div>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        <i class="fas fa-trash-alt mr-2"></i>
        {{ __('Supprimer mon compte') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <div class="flex items-center gap-5 mb-8">
                <div class="w-14 h-14 bg-mono-100 rounded-2xl flex items-center justify-center shadow-pressed">
                    <i class="fas fa-exclamation-triangle text-obsidian text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-obsidian tracking-tight">
                        {{ __('Confirmer la suppression') }}
                    </h2>
                    <p class="text-sm text-mono-500 font-medium">
                        {{ __('Cette action est irréversible.') }}
                    </p>
                </div>
            </div>

            <p class="text-sm text-mono-600 mb-6 font-medium">
                {{ __('Entrez votre mot de passe pour confirmer la suppression définitive de votre compte et de toutes vos données.') }}
            </p>

            <div>
                <x-input-label for="password" :value="__('Mot de passe')" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-2 block w-full"
                    placeholder="••••••••"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-4">
                <x-secondary-button x-on:click="$dispatch('close')">
                    <i class="fas fa-times mr-2"></i>
                    {{ __('Annuler') }}
                </x-secondary-button>

                <x-danger-button>
                    <i class="fas fa-trash-alt mr-2"></i>
                    {{ __('Supprimer définitivement') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
