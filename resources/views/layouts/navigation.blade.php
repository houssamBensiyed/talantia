<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-xl border-b border-mono-100 sticky top-0 z-40">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center flex-1">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-obsidian rounded-xl flex items-center justify-center shadow-gloss group-hover:shadow-gloss-hover group-hover:scale-105 transition-all duration-300">
                            <i class="fas fa-layer-group text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-extrabold text-obsidian tracking-tight hidden lg:inline">Talantia</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex md:ms-6 lg:ms-10 space-x-1 lg:space-x-2">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="px-3 xl:px-5">
                        <i class="fas fa-th-large xl:mr-2"></i>
                        <span class="hidden xl:inline text-sm font-bold whitespace-nowrap">{{ __('Tableau de bord') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('jobs.index')" :active="request()->routeIs('jobs.index') || request()->routeIs('jobs.show')" class="px-3 xl:px-5">
                        <i class="fas fa-briefcase xl:mr-2"></i>
                        <span class="hidden xl:inline text-sm font-bold whitespace-nowrap">{{ __('Offres') }}</span>
                    </x-nav-link>
                    @if(Auth::user()->isRecruiter())
                        <x-nav-link :href="route('jobs.my')" :active="request()->routeIs('jobs.my') || request()->routeIs('jobs.create') || request()->routeIs('jobs.edit') || request()->routeIs('jobs.applications')" class="px-3 xl:px-5">
                            <i class="fas fa-folder-open xl:mr-2"></i>
                            <span class="hidden xl:inline text-sm font-bold whitespace-nowrap">{{ __('Mes offres') }}</span>
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('applications.my')" :active="request()->routeIs('applications.my')" class="px-3 xl:px-5">
                            <i class="fas fa-paper-plane xl:mr-2"></i>
                            <span class="hidden xl:inline text-sm font-bold whitespace-nowrap">{{ __('Candidatures') }}</span>
                        </x-nav-link>
                        <x-nav-link :href="route('candidate.profile.edit')" :active="request()->routeIs('candidate.profile.*')" class="px-3 xl:px-5">
                            <i class="fas fa-id-card xl:mr-2"></i>
                            <span class="hidden xl:inline text-sm font-bold whitespace-nowrap">{{ __('Mon CV') }}</span>
                        </x-nav-link>
                    @endif
                    <x-nav-link :href="route('friends.index')" :active="request()->routeIs('friends.*')" class="px-3 xl:px-5">
                        <i class="fas fa-user-friends xl:mr-2"></i>
                        <span class="hidden xl:inline text-sm font-bold whitespace-nowrap">{{ __('Amis') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('search.index')" :active="request()->routeIs('search.*')" class="px-3 xl:px-5">
                        <i class="fas fa-compass xl:mr-2"></i>
                        <span class="hidden xl:inline text-sm font-bold whitespace-nowrap">{{ __('Explorer') }}</span>
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden md:flex md:items-center md:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2 text-sm font-medium rounded-2xl text-obsidian bg-white border border-mono-200 hover:border-mono-300 hover:shadow-tactile-sm focus:outline-none focus:ring-2 focus:ring-obsidian focus:ring-offset-2 transition-all duration-300">
                            <img src="{{ Auth::user()->photo_url }}" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-xl object-cover ring-2 ring-mono-100">
                            <div class="text-left hidden lg:block">
                                <div class="font-bold text-sm whitespace-nowrap">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-mono-500 whitespace-nowrap">
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
            <div class="-me-2 flex items-center md:hidden">
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
            <x-responsive-nav-link :href="route('jobs.index')" :active="request()->routeIs('jobs.index') || request()->routeIs('jobs.show')">
                <i class="fas fa-briefcase mr-3"></i>
                {{ __('Offres d\'emploi') }}
            </x-responsive-nav-link>
            @if(Auth::user()->isRecruiter())
                <x-responsive-nav-link :href="route('jobs.my')" :active="request()->routeIs('jobs.my') || request()->routeIs('jobs.create')">
                    <i class="fas fa-folder-open mr-3"></i>
                    {{ __('Mes offres') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('applications.my')" :active="request()->routeIs('applications.my')">
                    <i class="fas fa-paper-plane mr-3"></i>
                    {{ __('Mes candidatures') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('candidate.profile.index')" :active="request()->routeIs('candidate.profile.*')">
                    <i class="fas fa-file-alt mr-3"></i>
                    {{ __('Mon CV') }}
                </x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('friends.index')" :active="request()->routeIs('friends.*')">
                <i class="fas fa-user-friends mr-3"></i>
                {{ __('Amis') }}
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
