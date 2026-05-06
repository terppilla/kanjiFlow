<<<<<<< HEAD
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
        },
    },

    plugins: [forms],
};
=======
/** @type {import('tailwindcss').Config} */
export default {
    content: [
      "./resources/views/**/*.blade.php",
      "./resources/js/**/*.js",
    ],
    theme: {
      extend: {},
    },
    plugins: [],
  }
  
>>>>>>> e3a0717bac623e7789a121de1a25aa2df13d4476
