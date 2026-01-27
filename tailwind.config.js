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
                'tactile-bg': '#F0F0F2',
                'obsidian': '#1A1A1A',
                'obsidian-light': '#2D2D2D',
                'electric-blue': '#00CFFF',
                'cyber-cyan': '#00F0FF',
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
                'tactile': '0 20px 40px -10px rgba(0, 0, 0, 0.06), 0 8px 16px -8px rgba(0, 0, 0, 0.04), inset 0 0 0 1px rgba(255, 255, 255, 0.5)',
                'tactile-hover': '0 25px 50px -12px rgba(0, 0, 0, 0.1), 0 12px 24px -8px rgba(0, 0, 0, 0.05), inset 0 0 0 1px rgba(255, 255, 255, 0.7)',
                'tactile-sm': '0 10px 20px -5px rgba(0, 0, 0, 0.04), 0 4px 8px -4px rgba(0, 0, 0, 0.02), inset 0 0 0 1px rgba(255, 255, 255, 0.4)',
                'pressed': 'inset 0 2px 6px 0 rgba(0, 0, 0, 0.08), inset 0 1px 2px 0 rgba(0, 0, 0, 0.04)',
                'pressed-hover': 'inset 0 1px 3px 0 rgba(0, 0, 0, 0.05)',
                'gloss': '0 10px 30px -5px rgba(26, 26, 26, 0.3), 0 4px 10px -3px rgba(26, 26, 26, 0.2)',
                'gloss-hover': '0 15px 40px -5px rgba(26, 26, 26, 0.4), 0 6px 15px -3px rgba(26, 26, 26, 0.25)',
                'inner-glow': 'inset 0 1px 0 0 rgba(255, 255, 255, 0.1)',
            },
            borderRadius: {
                '4xl': '2rem',
                '5xl': '2.5rem',
            },
            animation: {
                'marquee': 'marquee 40s linear infinite',
                'fade-in-up': 'fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                'fade-in-down': 'fadeInDown 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards',
            },
            keyframes: {
                marquee: {
                    '0%': { transform: 'translateX(0)' },
                    '100%': { transform: 'translateX(-50%)' },
                },
                fadeInUp: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                fadeInDown: {
                    '0%': { opacity: '0', transform: 'translateY(-20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
        },
    },

    plugins: [forms],
};
