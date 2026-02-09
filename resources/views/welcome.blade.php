<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Talantia - Elite Network</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,800;0,900;1,400;1,600&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            background-color: #F2F2F2;
            color: #111111;
            overflow-x: hidden;
        }
        
        /* Network Orbit System */
        .orbit-system {
            position: absolute;
            top: 50%;
            right: -20%;
            width: 1000px;
            height: 1000px;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .orbit-ring {
            position: absolute;
            top: 50%;
            left: 50%;
            border: 1px dashed #D4D4D4; /* Light grey styling */
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }

        .ring-1 { width: 300px; height: 300px; }
        .ring-2 { width: 500px; height: 500px; }
        .ring-3 { width: 700px; height: 700px; }
        .ring-4 { width: 900px; height: 900px; }

        /* Animation Keyframes */
        @keyframes orbit-rotate {
            from { transform: translate(-50%, -50%) rotate(0deg); }
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }
        
        @keyframes counter-rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(-360deg); }
        }

        /* Title Animations */
        @keyframes reveal-up {
            from { opacity: 0; transform: translateY(100%); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes reveal-width {
            from { width: 0; }
            to { width: 100%; }
        }

        .title-reveal-wrapper {
            overflow: hidden;
            display: inline-block;
            vertical-align: bottom;
        }
        
        .title-reveal-char {
            display: inline-block;
            animation: reveal-up 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(100%);
        }

        /* Animated Rings Container */
        .orbit-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* Animation Speeds */
        .animate-ring-1 { width: 300px; height: 300px; animation: orbit-rotate 40s linear infinite; }
        .animate-ring-2 { width: 500px; height: 500px; animation: orbit-rotate 60s linear infinite reverse; }
        .animate-ring-3 { width: 700px; height: 700px; animation: orbit-rotate 80s linear infinite; }
        .animate-ring-4 { width: 900px; height: 900px; animation: orbit-rotate 100s linear infinite reverse; }

        /* Node Positioning Helper within animated ring */
        .orbit-item {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
        }

        .orbit-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        
        /* Counter rotate avatars to keep them upright */
        .avatar-node, .status-dot {
            animation: counter-rotate 40s linear infinite; /* Durations must match ring durations */
        }
        .animate-ring-2 .avatar-node, .animate-ring-2 .status-dot { animation: counter-rotate 60s linear infinite reverse; }
        .animate-ring-3 .avatar-node, .animate-ring-3 .status-dot { animation: counter-rotate 80s linear infinite; }
        .animate-ring-4 .avatar-node, .animate-ring-4 .status-dot { animation: counter-rotate 100s linear infinite reverse; }


        /* Avatar Styling */
        /* Avatar Styling - Updated to prevent label clipping */
        .avatar-node-style {
            border-radius: 50%;
            background-color: #E5E7EB;
            border: 2px solid white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            filter: grayscale(100%);
            transition: all 0.3s ease;
        }
        
        .avatar-node-style img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .orbit-system:hover .avatar-node-style {
            filter: grayscale(0%);
            transform: scale(1.1);
        }

        /* Status Dot Styling */
        .status-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            box-shadow: 0 0 0 4px #F2F2F2;
        }
        .dot-green { background-color: #CCFF00; }
        .dot-grey { background-color: #A3A3A3; }
        .dot-black { background-color: #1A1A1A; }
        
        @media (max-width: 1024px) {
            .orbit-system {
                right: -50%;
                opacity: 0.3;
            }
        }

        /* Fixed Animations for Orbit System */
        @keyframes spin-cw {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        @keyframes spin-ccw {
            from { transform: rotate(0deg); }
            to { transform: rotate(-360deg); }
        }
        
        .animate-spin-slow {
            animation: spin-cw 40s linear infinite;
        }
        
        .animate-spin-reverse-slow {
            animation: spin-ccw 50s linear infinite;
        }
        
        /* Counter-rotations to keep avatars upright */
        .animate-spin-slow .animate-counter-spin {
            animation: spin-ccw 40s linear infinite;
        }
        
        .animate-spin-reverse-slow .animate-counter-spin-reverse {
            animation: spin-cw 50s linear infinite;
        }
    </style>
</head>
<body class="font-sans antialiased text-obsidian bg-tactile-bg">

    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-xl border-b border-mono-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 md:h-18 py-2 md:py-3">
                <!-- Logo Section -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-obsidian rounded-xl flex items-center justify-center shadow-gloss group-hover:shadow-gloss-hover group-hover:scale-105 transition-all duration-300">
                            <i class="fas fa-layer-group text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-extrabold text-obsidian tracking-tight">Talantia</span>
                    </a>
                </div>
                
                <!-- Navigation Links -->
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-bold text-obsidian hover:text-mono-600 transition-colors">Tableau de bord</a>
                    @else
                        <a href="{{ route('login') }}" class="font-bold text-mono-600 hover:text-obsidian transition-colors text-sm uppercase tracking-wide px-4">Connexion</a>
                        
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="group inline-flex items-center justify-center px-6 py-2.5 bg-obsidian border border-transparent rounded-full font-bold text-xs text-white tracking-wider uppercase hover:bg-obsidian-light focus:outline-none focus:ring-2 focus:ring-obsidian focus:ring-offset-2 transition-all duration-300 shadow-gloss hover:shadow-gloss-hover hover:scale-[1.02] active:scale-[0.98] relative overflow-hidden">
                                <span class="absolute inset-0 bg-gradient-to-b from-white/10 to-transparent pointer-events-none"></span>
                                <span class="relative flex items-center gap-2">Rejoindre</span>
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Hero Section -->
    <div class="relative min-h-screen flex items-center overflow-hidden pt-10">
        
        <!-- Background Elements -->
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
             <!-- Top Right Gradient Blob -->
            <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-gradient-to-b from-gray-100/50 to-transparent rounded-full blur-3xl opacity-60 transform translate-x-1/2 -translate-y-1/2"></div>
        </div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-8 h-full flex flex-col justify-center">
            
            <!-- Hero Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <!-- Left Column: Content -->
                <div class="max-w-2xl pt-20 relative z-20">
                    
                    <h1 class="text-7xl md:text-9xl font-black tracking-tight text-black mb-8 leading-[0.85] font-serif" style="font-family: 'Playfair Display', serif;">
                        <span class="block">
                            <span class="title-reveal-wrapper"><span class="title-reveal-char" style="animation-delay: 0.1s">L</span></span><span class="title-reveal-wrapper"><span class="title-reveal-char" style="animation-delay: 0.15s">e</span></span>
                            <!-- Removed Spacer w-8 to fix spacing -->
                            <span class="relative inline-block ml-4">
                                <span class="title-reveal-wrapper"><span class="title-reveal-char" style="animation-delay: 0.2s">R</span></span><span class="title-reveal-wrapper"><span class="title-reveal-char" style="animation-delay: 0.25s">é</span></span><span class="title-reveal-wrapper"><span class="title-reveal-char" style="animation-delay: 0.3s">s</span></span><span class="title-reveal-wrapper"><span class="title-reveal-char" style="animation-delay: 0.35s">e</span></span><span class="title-reveal-wrapper"><span class="title-reveal-char" style="animation-delay: 0.4s">a</span></span><span class="title-reveal-wrapper"><span class="title-reveal-char" style="animation-delay: 0.45s">u</span></span>
                                <span class="absolute left-0 bottom-2 h-4 bg-brand-accent -z-10 reseau-underline" style="width: 0%;"></span>
                            </span>
                        </span>
                        <span class="relative font-medium block vivant-wrapper origin-left">
                            <span class="title-reveal-wrapper"><span class="title-reveal-char" style="animation-delay: 0.6s">V</span></span><span class="title-reveal-wrapper"><span class="title-reveal-char" style="animation-delay: 0.65s">i</span></span><span class="title-reveal-wrapper"><span class="title-reveal-char" style="animation-delay: 0.7s">v</span></span><span class="title-reveal-wrapper"><span class="title-reveal-char" style="animation-delay: 0.75s">a</span></span><span class="title-reveal-wrapper"><span class="title-reveal-char" style="animation-delay: 0.8s">n</span></span><span class="title-reveal-wrapper"><span class="title-reveal-char" style="animation-delay: 0.85s">t</span></span>
                            <span class="title-reveal-wrapper"><span class="title-reveal-char" style="animation-delay: 1s"><span class="absolute -right-8 top-4 w-4 h-4 bg-brand-accent rounded-full"></span></span></span>
                        </span>
                    </h1>

                    <p class="text-xl text-gray-600 font-light leading-relaxed mb-12 max-w-lg animate-fade-in-up" style="animation-delay: 1.2s;">
                        Connectez-vous à la grille de talents la plus exclusive au monde. Pas d'intermédiaires, juste de la performance pure.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-6 animate-fade-in-up" style="animation-delay: 1.4s;">
                        <a href="{{ route('register') }}" class="group inline-flex items-center justify-center px-10 py-5 bg-obsidian border border-transparent rounded-full font-bold text-sm text-white tracking-wider uppercase hover:bg-obsidian-light focus:outline-none focus:ring-2 focus:ring-obsidian focus:ring-offset-2 transition-all duration-300 shadow-gloss hover:shadow-gloss-hover hover:scale-[1.02] active:scale-[0.98] relative overflow-hidden">
                            <span class="absolute inset-0 bg-gradient-to-b from-white/10 to-transparent pointer-events-none"></span>
                            <span class="relative flex items-center gap-2">
                                 Commencer Maintenant
                                 <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform ml-2"></i>
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Right Column: Network Graphics (Perfect Alignment) -->
                <div class="relative h-[900px] w-full hidden lg:flex items-center justify-center overflow-visible pointer-events-none">
                     <div class="relative w-[1000px] h-[1000px] orbit-system transform translate-x-[20%]">
                        
                        <!-- Core Center -->
                        <div class="absolute inset-0 m-auto w-32 h-32 bg-white rounded-full shadow-[0_0_30px_rgba(0,0,0,0.05)] flex items-center justify-center z-30">
                            <div class="w-2.5 h-2.5 bg-black rounded-full"></div>
                        </div>

                        <!-- Ring 1 (Inner) -->
                        <div class="absolute inset-0 m-auto w-[400px] h-[400px]">
                             <!-- Static Circle Line -->
                            <svg class="w-full h-full absolute inset-0" viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="50" fill="none" stroke="#9CA3AF" stroke-width="0.3" stroke-dasharray="1 3" />
                            </svg>
                            
                            <!-- Spinning Orbit Layer -->
                            <div class="absolute inset-0 w-full h-full animate-spin-slow">
                                <!-- Item 1: Avatar (Arm: 220deg) -->
                                <div class="absolute top-1/2 left-1/2 w-full h-0 -translate-x-1/2 -translate-y-1/2 rotate-[220deg]">
                                    <!-- Positioner -->
                                    <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/2">
                                        <!-- Animator -->
                                        <div class="animate-counter-spin">
                                            <!-- Corrector (Inverse 220deg) -->
                                            <div style="transform: rotate(-220deg);">
                                                <div class="w-16 h-16 avatar-node-style">
                                                    <img src="https://i.pravatar.cc/150?u=core1" alt="Avatar">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Item 2: Dot (Arm: 60deg) -->
                                <div class="absolute top-1/2 left-1/2 w-full h-0 -translate-x-1/2 -translate-y-1/2 rotate-[60deg]">
                                    <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/2">
                                         <div class="animate-counter-spin">
                                            <!-- Corrector (Inverse 60deg) -->
                                            <div style="transform: rotate(-60deg);">
                                                <div class="w-3 h-3 bg-brand-accent rounded-full"></div>
                                            </div>
                                         </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ring 2 (Medium) -->
                        <div class="absolute inset-0 m-auto w-[700px] h-[700px]">
                            <!-- Static Circle Line -->
                            <svg class="w-full h-full absolute inset-0" viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="50" fill="none" stroke="#9CA3AF" stroke-width="0.25" stroke-dasharray="1 3" />
                            </svg>
                            
                            <!-- Spinning Orbit Layer (Reverse) -->
                            <div class="absolute inset-0 w-full h-full animate-spin-reverse-slow">
                                <!-- Item 1: Avatar Top 1% (Arm: 160deg) -->
                                <div class="absolute top-1/2 left-1/2 w-full h-0 -translate-x-1/2 -translate-y-1/2 rotate-[160deg]">
                                    <!-- Positioner -->
                                    <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/2">
                                        <!-- Animator -->
                                        <div class="animate-counter-spin-reverse">
                                            <!-- Corrector (Inverse 160deg) -->
                                            <div style="transform: rotate(-160deg);">
                                                <div class="relative group">
                                                    <div class="w-20 h-20 avatar-node-style relative z-10">
                                                        <img src="https://i.pravatar.cc/150?u=med1" alt="Top Talent">
                                                    </div>
                                                    <!-- Label moved outside the overflow-hidden container if any, but now we use avatar-node-style which is safe -->
                                                    <div class="absolute -top-4 -right-4 z-20 bg-brand-accent text-black text-[11px] font-black px-3 py-1 rounded-full shadow-md whitespace-nowrap transform group-hover:scale-110 transition-transform">TOP 1%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                 <!-- Item 2: Dot (Arm: 340deg) -->
                                <div class="absolute top-1/2 left-1/2 w-full h-0 -translate-x-1/2 -translate-y-1/2 rotate-[340deg]">
                                    <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/2">
                                        <div class="animate-counter-spin-reverse">
                                            <div style="transform: rotate(-340deg);">
                                                <div class="w-3.5 h-3.5 bg-brand-accent rounded-full shadow-sm"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ring 3 (Large) -->
                        <div class="absolute inset-0 m-auto w-[1000px] h-[1000px]">
                             <!-- Static Circle Line -->
                             <svg class="w-full h-full absolute inset-0" viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="50" fill="none" stroke="#9CA3AF" stroke-width="0.2" stroke-dasharray="0.5 2" />
                            </svg>
                            
                            <!-- Spinning Orbit Layer -->
                            <div class="absolute inset-0 w-full h-full animate-spin-slow">
                                <!-- Item 1: CTO Avatar (Arm: 45deg) -->
                                <div class="absolute top-1/2 left-1/2 w-full h-0 -translate-x-1/2 -translate-y-1/2 rotate-[45deg]">
                                    <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/2">
                                        <div class="animate-counter-spin">
                                            <div style="transform: rotate(-45deg);">
                                                <div class="relative group">
                                                    <div class="w-24 h-24 avatar-node-style relative z-10">
                                                        <img src="https://i.pravatar.cc/150?u=lg1" alt="CTO">
                                                    </div>
                                                    <div class="absolute -bottom-3 -right-3 z-20 bg-black text-white text-[11px] font-bold px-3 py-1 rounded-full shadow-xl transform group-hover:scale-110 transition-transform">CTO</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Item 2: Small Avatar (Arm: 200deg) -->
                                <div class="absolute top-1/2 left-1/2 w-full h-0 -translate-x-1/2 -translate-y-1/2 rotate-[200deg]">
                                    <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/2">
                                         <div class="animate-counter-spin">
                                            <div style="transform: rotate(-200deg);">
                                                <div class="w-14 h-14 opacity-80 avatar-node-style">
                                                    <img src="https://i.pravatar.cc/150?u=lg2" alt="Member">
                                                </div>
                                            </div>
                                         </div>
                                    </div>
                                </div>

                                <!-- Item 3: Black Dot (Arm: 120deg) -->
                                <div class="absolute top-1/2 left-1/2 w-full h-0 -translate-x-1/2 -translate-y-1/2 rotate-[120deg]">
                                    <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/2">
                                        <div class="animate-counter-spin">
                                            <div style="transform: rotate(-120deg);">
                                                <div class="w-3 h-3 bg-gray-900 rounded-full"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Strip -->
    <div class="border-y border-gray-200 bg-white grid">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 w-full">
            <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-gray-200">
                <div class="py-12 md:px-8 first:pl-0">
                    <h3 class="text-lg font-bold mb-2">Vitesse</h3>
                    <p class="text-gray-500 text-sm leading-6">Recrutement en temps réel grâce à notre moteur de matching neural.</p>
                </div>
                <div class="py-12 md:px-8">
                    <h3 class="text-lg font-bold mb-2">Qualité</h3>
                    <p class="text-gray-500 text-sm leading-6">Seuls 1% des candidats réussissent nos tests techniques rigoureux.</p>
                </div>
                <div class="py-12 md:px-8 border-r-0">
                    <h3 class="text-lg font-bold mb-2">Transparence</h3>
                    <p class="text-gray-500 text-sm leading-6">Salaire et équité affichés dès le départ. Zéro surprise.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recruiters Testimonials Section -->
    @if(isset($recruiters) && $recruiters->count() > 0)
    <section class="py-24 bg-[#FAFAFA] overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 mb-16">
            <!-- Header -->
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-12">
                <div class="max-w-xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-gray-200 bg-white text-xs font-semibold text-gray-600 mb-6 shadow-sm">
                        <i class="fas fa-arrow-trend-up text-xs"></i>
                        <span>Témoignages</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight text-black leading-[1.1]">
                        Approuvé par +{{ $recruiters->count() * 100 }}+ <br>
                        Recruteurs Satisfaits
                    </h2>
                </div>
                
                <div class="lg:text-right max-w-md flex flex-col lg:items-end">
                    <p class="text-gray-500 font-medium leading-relaxed mb-6 text-base lg:text-right">
                        Talantia a aidé des entreprises de toutes tailles à trouver les meilleurs talents et atteindre leurs objectifs.
                    </p>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 bg-transparent text-black font-semibold text-sm hover:bg-black hover:text-white hover:border-black transition-all duration-300 group">
                        Commencer
                        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Auto-Scrolling Marquee -->
        <div class="relative w-full overflow-hidden">
            <div class="flex gap-6 animate-marquee whitespace-nowrap px-6" style="width: max-content;">
                <!-- Original Items -->
                @foreach($recruiters as $index => $recruiter)
                <div class="inline-block w-[340px] md:w-[380px] h-[500px] whitespace-normal align-top">
                    <div class="relative h-full w-full rounded-2xl overflow-hidden group cursor-pointer">
                        <!-- Image -->
                        <img src="{{ $recruiter->photo_url }}" alt="{{ $recruiter->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        
                        <!-- Gradient Overlay -->
                         @php
                            $gradients = [
                                'from-amber-400/80 via-orange-500/60 to-rose-500/80',
                                'from-emerald-400/80 via-teal-500/60 to-cyan-500/80',
                                'from-violet-400/80 via-purple-500/60 to-fuchsia-500/80',
                                'from-sky-400/80 via-blue-500/60 to-indigo-500/80',
                                'from-lime-400/80 via-green-500/60 to-emerald-500/80',
                                'from-rose-400/80 via-pink-500/60 to-fuchsia-500/80',
                            ];
                            $gradient = $gradients[$index % count($gradients)];
                        @endphp
                        <div class="absolute inset-0 bg-gradient-to-t {{ $gradient }} mix-blend-multiply opacity-60 group-hover:opacity-50 transition-opacity duration-500"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-90"></div>

                        <!-- Content -->
                        <div class="absolute inset-0 flex flex-col justify-end p-8 text-white z-10">
                            <p class="text-xl font-medium leading-snug mb-8 text-shadow-sm">"{{ Str::limit($recruiter->bio, 80) }}"</p>
                            
                            <div class="flex items-center justify-between pt-6 border-t border-white/20">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded bg-white flex items-center justify-center">
                                         <i class="fas fa-building text-black text-xs"></i>
                                    </div>
                                    <span class="font-bold text-sm tracking-wide">{{ $recruiter->company }}</span>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-sm">{{ $recruiter->name }}</div>
                                    <div class="text-[10px] uppercase tracking-wider opacity-80">{{ $recruiter->specialty }} Director</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Duplicate Items for Seamless Loop -->
                @foreach($recruiters as $index => $recruiter)
                <div class="inline-block w-[340px] md:w-[380px] h-[500px] whitespace-normal align-top" aria-hidden="true">
                    <div class="relative h-full w-full rounded-2xl overflow-hidden group cursor-pointer">
                        <img src="{{ $recruiter->photo_url }}" alt="{{ $recruiter->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        
                         @php
                            $gradient = $gradients[$index % count($gradients)];
                        @endphp
                        <div class="absolute inset-0 bg-gradient-to-t {{ $gradient }} mix-blend-multiply opacity-60 group-hover:opacity-50 transition-opacity duration-500"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-90"></div>

                        <div class="absolute inset-0 flex flex-col justify-end p-8 text-white z-10">
                            <p class="text-xl font-medium leading-snug mb-8 text-shadow-sm">"{{ Str::limit($recruiter->bio, 80) }}"</p>
                            
                            <div class="flex items-center justify-between pt-6 border-t border-white/20">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded bg-white flex items-center justify-center">
                                         <i class="fas fa-building text-black text-xs"></i>
                                    </div>
                                    <span class="font-bold text-sm tracking-wide">{{ $recruiter->company }}</span>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-sm">{{ $recruiter->name }}</div>
                                    <div class="text-[10px] uppercase tracking-wider opacity-80">{{ $recruiter->specialty }} Director</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- FAQ Section -->
    <section class="py-24 bg-white border-t border-gray-100">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-gray-200 bg-gray-50 text-xs font-semibold text-gray-600 mb-6 shadow-sm">
                    <i class="fas fa-circle-question text-xs"></i>
                    <span>Support</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight text-black mb-6">
                    Questions Fréquentes
                </h2>
                <p class="text-lg text-gray-500 max-w-2xl mx-auto">
                    Tout ce que vous devez savoir pour commencer à recruter ou trouver votre prochain poste.
                </p>
            </div>

            <div class="space-y-4" x-data="{ active: null }">
                <!-- FAQ Item 1 -->
                <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden transition-all duration-300 hover:border-gray-300" :class="{'shadow-lg border-gray-300': active === 1}">
                    <button @click="active = active === 1 ? null : 1" class="w-full flex items-center justify-between p-6 text-left group">
                        <span class="text-lg font-bold text-black group-hover:text-gray-700 transition-colors">Comment Talantia sélectionne-t-elle les talents ?</span>
                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center transition-transform duration-300" :class="{'rotate-180 bg-black text-white': active === 1}">
                            <i class="fas fa-chevron-down text-sm"></i>
                        </div>
                    </button>
                    <div x-show="active === 1" x-collapse>
                        <div class="px-6 pb-6 pt-0 text-gray-500 leading-relaxed">
                            Nous utilisons un processus de vérification rigoureux en 4 étapes : analyse IA des compétences, tests techniques chronométrés, vérification des expériences passées et entretien vidéo. Seuls le top 1% des candidats accèdent à la plateforme.
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden transition-all duration-300 hover:border-gray-300" :class="{'shadow-lg border-gray-300': active === 2}">
                    <button @click="active = active === 2 ? null : 2" class="w-full flex items-center justify-between p-6 text-left group">
                        <span class="text-lg font-bold text-black group-hover:text-gray-700 transition-colors">Quel est le modèle de tarification pour les entreprises ?</span>
                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center transition-transform duration-300" :class="{'rotate-180 bg-black text-white': active === 2}">
                            <i class="fas fa-chevron-down text-sm"></i>
                        </div>
                    </button>
                    <div x-show="active === 2" x-collapse>
                        <div class="px-6 pb-6 pt-0 text-gray-500 leading-relaxed">
                            Nous fonctionnons sur un modèle transparent : l'accès à la recherche est gratuit. Vous ne payez qu'une commission fixe de 15% sur le salaire annuel brut uniquement si vous embauchez un candidat. Satisfait ou remboursé sous 90 jours.
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden transition-all duration-300 hover:border-gray-300" :class="{'shadow-lg border-gray-300': active === 3}">
                    <button @click="active = active === 3 ? null : 3" class="w-full flex items-center justify-between p-6 text-left group">
                        <span class="text-lg font-bold text-black group-hover:text-gray-700 transition-colors">Combien de temps faut-il pour recruter ?</span>
                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center transition-transform duration-300" :class="{'rotate-180 bg-black text-white': active === 3}">
                            <i class="fas fa-chevron-down text-sm"></i>
                        </div>
                    </button>
                    <div x-show="active === 3" x-collapse>
                        <div class="px-6 pb-6 pt-0 text-gray-500 leading-relaxed">
                            Grâce à notre vivier de talents pré-qualifiés et disponibles immédiatement, nos clients réalisent leur première embauche en moyenne sous 7 jours, contre 45 jours pour le marché traditionnel.
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden transition-all duration-300 hover:border-gray-300" :class="{'shadow-lg border-gray-300': active === 4}">
                    <button @click="active = active === 4 ? null : 4" class="w-full flex items-center justify-between p-6 text-left group">
                        <span class="text-lg font-bold text-black group-hover:text-gray-700 transition-colors">Puis-je chercher un emploi en restant confidentiel ?</span>
                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center transition-transform duration-300" :class="{'rotate-180 bg-black text-white': active === 4}">
                            <i class="fas fa-chevron-down text-sm"></i>
                        </div>
                    </button>
                    <div x-show="active === 4" x-collapse>
                        <div class="px-6 pb-6 pt-0 text-gray-500 leading-relaxed">
                            Absolument. Votre profil peut être masqué pour votre employeur actuel. Vous contrôlez qui voit vos informations et vous ne recevez des demandes que des entreprises qui correspondent à vos critères.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="bg-[#111] text-white py-20 relative z-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 flex flex-col md:flex-row justify-between gap-12">
            <div>
                <span class="text-2xl font-black tracking-tighter">TALANTIA</span>
                <p class="text-gray-500 text-sm mt-4 max-w-xs">Le futur du travail est distribué. Nous construisons l'infrastructure pour le supporter.</p>
            </div>
            
            <div class="flex gap-16 text-sm font-bold text-gray-500 uppercase tracking-widest">
                <a href="#" class="hover:text-brand-accent transition-colors">Talents</a>
                <a href="#" class="hover:text-brand-accent transition-colors">Entreprises</a>
                <a href="{{ route('login') }}" class="hover:text-brand-accent transition-colors">Login</a>
            </div>
        </div>
    </footer>

    <!-- GSAP scripts only -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    <script>
        gsap.registerPlugin(ScrollTrigger);

        // Standard CSS smooth scroll for anchors
        document.documentElement.style.scrollBehavior = 'smooth';

        // Hardware Acceleration hint for animated elements
        gsap.set(".orbit-container, .avatar-node, .animate-marquee", { willChange: "transform" });

        // Hero Animations - Text Entrance
        const titleChars = document.querySelectorAll('.title-reveal-char');
        if(titleChars.length) {
            gsap.to(titleChars, {
                y: 0,
                opacity: 1,
                duration: 1,
                stagger: 0.03,
                ease: "power3.out"
            });
        }

        // New Animations requested: 
        // 1. Animate "Vivant" to oblique after 4 seconds (and loop)
        // 2. Animate "Réseau" underline after 4 seconds
        
        const timeline = gsap.timeline({ delay: 4, repeat: -1, repeatDelay: 2, yoyo: true });
        
        // Skew Vivant to look oblique/italic
        timeline.to(".vivant-wrapper", {
            skewX: -15, // Simulates heavy italic/oblique
            duration: 0.8,
            ease: "power2.inOut"
        }, 0);

        // Expand underline under Réseau
        timeline.to(".reseau-underline", {
            width: "100%",
            duration: 0.8,
            ease: "power2.inOut"
        }, 0);


        // Fade in description and button
        gsap.from(".animate-fade-in-up", {
            y: 20,
            opacity: 0,
            duration: 0.6,
            stagger: 0.1,
            ease: "power2.out",
            delay: 0.5
        });

        // Orbit System Scale In
        gsap.from(".orbit-system", {
            scale: 0.9,
            opacity: 0,
            duration: 1.2,
            ease: "power2.out",
            delay: 0.2
        });

        // Featured Grid Stagger
        const gridItems = document.querySelectorAll('.grid > div');
        if(gridItems.length) {
            ScrollTrigger.batch(gridItems, {
                start: "top 85%",
                onEnter: batch => gsap.to(batch, {opacity: 1, y: 0, duration: 0.4, stagger: 0.1, overwrite: true}),
            });
            gsap.set(gridItems, {opacity: 0, y: 20});
        }

        // FAQ Items Stagger
        const activeFaqItems = document.querySelectorAll('.space-y-4 > div');
        if(activeFaqItems.length) {
             ScrollTrigger.batch(activeFaqItems, {
                start: "top 90%",
                onEnter: batch => gsap.to(batch, {opacity: 1, y: 0, duration: 0.4, stagger: 0.05, overwrite: true}),
            });
            gsap.set(activeFaqItems, {opacity: 0, y: 20});
        }
    </script>
</body>
</html>
