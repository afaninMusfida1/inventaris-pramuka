import defaultTheme from 'tailwindcss/defaultTheme';
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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#f6f0eb',
                    100: '#ebddd2',
                    200: '#dfcab9',
                    300: '#d2b69f',
                    400: '#c5a386',
                    500: '#A47750', // Warna utama
                    600: '#87603f',
                    700: '#6a4a30',
                    800: '#4c3420',
                    900: '#2e1e10',
                },
            },
        },
    },

    plugins: [forms],
};
