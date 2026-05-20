import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/views/**/*.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                rentalin: {
                    primary: '#34699A',
                    secondary: '#FFE980',
                    subtle: '#EDF2F7',
                    background: '#F9FAFB',
                    gray: '#696969',
                    danger: '#FF566A',
                    success: '#2FD870',
                },
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                poppins: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                soft: '0 2px 4px rgba(0, 0, 0, 0.16)',
                card: '0 2px 10px rgba(0, 0, 0, 0.04)',
            },
        },
    },

    plugins: [forms],
};