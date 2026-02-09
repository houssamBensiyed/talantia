import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: [
                    'Inter',
                    'ui-sans-serif',
                    'system-ui',
                    '-apple-system',
                    'BlinkMacSystemFont',
                    '"Segoe UI"',
                    'Roboto',
                    '"Helvetica Neue"',
                    'Arial',
                    '"Noto Sans"',
                    'sans-serif',
                    '"Apple Color Emoji"',
                    '"Segoe UI Emoji"',
                    '"Segoe UI Symbol"',
                    '"Noto Color Emoji"'
                ],
            },
            letterSpacing: {
                'premium': '0.02em',
                'premium-wide': '0.05em',
            },
            colors: {
                'tactile-bg': '#F4F4F5', // Slightly cooler gray
                'obsidian': '#09090B', // Zinc-950, deeper black
                'obsidian-light': '#18181B', // Zinc-900
                'electric-blue': '#0EA5E9', // Sky-500, clearer blue
                'brand': {
                    'accent': '#CCFF00', // The distinct Lime Green
                    'accent-hover': '#B3E600',
                },
                // Grayscale palette for monochrome design
                'mono': {
                    50: '#FAFAFA',
                    100: '#F5F5F5',
                    200: '#E5E5E5',
                    300: '#D4D4D4',
                    400: '#A3A3A3',
                    500: '#737373',
                    600: '#525252',
                    700: '#404040',
                    800: '#262626',
                    900: '#171717',
                },
            },
            boxShadow: {
                // Sharper, more defined shadows
                'tactile': '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
                'tactile-hover': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
                'card': '0 0 0 1px rgba(0,0,0,0.05), 0 1px 3px 0 rgba(0,0,0,0.1)',
                'card-hover': '0 0 0 1px rgba(0,0,0,0.1), 0 4px 6px -1px rgba(0,0,0,0.1)',
                'gloss': '0 4px 14px 0 rgba(0, 0, 0, 0.1)',
                'gloss-hover': '0 6px 20px rgba(0, 0, 0, 0.15)',
                'inner': 'inset 0 2px 4px 0 rgba(0, 0, 0, 0.06)',
            },
            borderRadius: {
                '4xl': '2rem',
                '5xl': '2.5rem',
            },
            animation: {
                'marquee': 'marquee 40s linear infinite',
                'fade-in-up': 'fadeInUp 0.5s ease-out forwards',
                'fade-in-down': 'fadeInDown 0.5s ease-out forwards',
            },
            keyframes: {
                marquee: {
                    '0%': { transform: 'translateX(0)' },
                    '100%': { transform: 'translateX(-50%)' },
                },
                fadeInUp: {
                    '0%': { opacity: '0', transform: 'translateY(10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                fadeInDown: {
                    '0%': { opacity: '0', transform: 'translateY(-10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
        },
    },

    plugins: [forms],
};
