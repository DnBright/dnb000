const defaultTheme = require('tailwindcss/defaultTheme');
const forms = require('@tailwindcss/forms');

/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.jsx',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
                heading: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    charcoal: '#0b0f14',
                    nearBlack: '#071019',
                    navy: '#081227',
                    cyan: {
                        DEFAULT: '#06f6ff',
                        400: '#06b6d4'
                    },
                    violet: '#8b5cf6',
                    accent: '#00e5ff'
                }
            },
            boxShadow: {
                'glow-sm': '0 6px 24px rgba(6, 182, 212, 0.08)',
                'glow-md': '0 12px 40px rgba(139, 92, 246, 0.08)'
            },
            transitionTimingFunction: {
                'brand-ease': 'cubic-bezier(.16,.84,.44,1)'
            }
        },
    },

    plugins: [forms],
};
