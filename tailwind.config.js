import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Montserrat', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'codevilla': {
                    'primary': '#1A2E6B',      // Azul escuro principal
                    'secondary': '#7A0C23',    // Vermelho vinho
                    'accent': '#2E63BF',       // Azul médio
                    'success': '#2AC95E',      // Verde
                    'bg': '#f4f6fb',           // Background
                    'text': '#11245C',         // Texto principal
                    'muted': '#5a6a9a',        // Texto secundário
                    'border': '#dde2f4',       // Bordas
                },
            },
        },
    },

    plugins: [forms],
};
