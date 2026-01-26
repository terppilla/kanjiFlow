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
                sans: ['Noto Sans SC', 'sans-serif'],
                serif: ['Noto Serif SC', 'serif'],
            },

            colors: {
                primary: '#7A1414', 
                secondary: '#F3CAA5', 
                background: '#f9fafb', 
              },
        },
    },

    plugins: [forms],
};
