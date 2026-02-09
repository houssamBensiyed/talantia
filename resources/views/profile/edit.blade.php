<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-white rounded-2xl shadow-tactile flex items-center justify-center">
                <i class="fas fa-user-circle text-obsidian text-xl"></i>
            </div>
            <div>
                <h2 class="font-extrabold text-3xl text-obsidian leading-tight tracking-tight">
                    {{ __('Mon profil') }}
                </h2>
                <p class="text-sm text-mono-500 font-medium tracking-wide">Gérez vos informations personnelles</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Profile Information -->
            <div class="bg-white shadow-tactile rounded-2xl overflow-hidden hover:shadow-tactile-hover transition-all duration-300">
                <div class="p-8 sm:p-10">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Password Update -->
            <div class="bg-white shadow-tactile rounded-2xl overflow-hidden hover:shadow-tactile-hover transition-all duration-300">
                <div class="p-8 sm:p-10">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account -->
            <div class="bg-white shadow-tactile rounded-2xl overflow-hidden hover:shadow-tactile-hover transition-all duration-300">
                <div class="p-8 sm:p-10">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
