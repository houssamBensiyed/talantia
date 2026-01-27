<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-xl border-b border-mono-100 sticky top-0 z-40">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 md:h-18 py-2 md:py-3">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-obsidian rounded-xl flex items-center justify-center shadow-gloss group-hover:shadow-gloss-hover group-hover:scale-105 transition-all duration-300">
                            <i class="fas fa-layer-group text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-extrabold text-obsidian tracking-tight hidden sm:inline">Talantia</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:ms-8 md:ms-10 space-x-1 md:space-x-2">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <i class="fas fa-th-large mr-2"></i>
                        {{ __('Tableau de bord') }}
                    </x-nav-link>
                    <x-nav-link :href="route('search.index')" :active="request()->routeIs('search.*')">
                        <i class="fas fa-compass mr-2"></i>
                        {{ __('Explorer') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 md:gap-3 px-3 md:px-4 py-2 md:py-2.5 text-sm font-medium rounded-2xl text-obsidian bg-white border border-mono-200 hover:border-mono-300 hover:shadow-tactile-sm focus:outline-none focus:ring-2 focus:ring-obsidian focus:ring-offset-2 transition-all duration-300">
                            <img src="{{ Auth::user()->photo_url }}" alt="{{ Auth::user()->name }}" class="w-7 h-7 md:w-8 md:h-8 rounded-xl object-cover ring-2 ring-mono-100">
                            <div class="text-left hidden md:block">
                                <div class="font-bold text-sm">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-mono-500">
                                    @if(Auth::user()->isRecruiter())
                                        <i class="fas fa-building-columns mr-1"></i>Recruteur
                                    @else
                                        <i class="fas fa-briefcase mr-1"></i>Talent
                                    @endif
                                </div>
                            </div>
                            <i class="fas fa-chevron-down text-mono-400 text-xs ml-1"></i>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fas fa-user-circle mr-3 text-mono-400"></i>
                            {{ __('Mon profil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <i class="fas fa-arrow-right-from-bracket mr-3 text-mono-400"></i>
                                {{ __('Déconnexion') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2.5 rounded-xl text-mono-500 hover:text-obsidian hover:bg-mono-100 focus:outline-none focus:bg-mono-100 transition-all duration-200 active:scale-95">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-mono-100"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2">
        <div class="pt-4 pb-3 px-4 space-y-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <i class="fas fa-th-large mr-3"></i>
                {{ __('Tableau de bord') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('search.index')" :active="request()->routeIs('search.*')">
                <i class="fas fa-compass mr-3"></i>
                {{ __('Explorer') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-4 px-4 border-t border-mono-100">
            <div class="flex items-center gap-4 mb-4 p-4 bg-mono-50 rounded-2xl">
                <img src="{{ Auth::user()->photo_url }}" alt="{{ Auth::user()->name }}" class="w-12 h-12 rounded-xl object-cover ring-2 ring-white shadow-tactile-sm">
                <div class="flex-1 min-w-0">
                    <div class="font-bold text-base text-obsidian truncate">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-mono-500 truncate">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-2">
                <x-responsive-nav-link :href="route('profile.edit')">
                    <i class="fas fa-user-circle mr-3"></i>
                    {{ __('Mon profil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <i class="fas fa-arrow-right-from-bracket mr-3"></i>
                        {{ __('Déconnexion') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
