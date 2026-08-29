import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.{js,ts,jsx,tsx,vue}', // បន្ថែមផ្លូវនេះ ប្រសិនបើអ្នកមានប្រើ Vue / React / JS
    ],

    theme: {
        extend: {
            colors: {
                primary: {
                    50: "#effafd",
                    100: "#d8f1f8",
                    200: "#b4e4f0",
                    300: "#81d0e2",
                    400: "#47b5cc",
                    500: "#0e7ea3",
                    600: "#0c6b8b",
                    700: "#0c5871",
                    800: "#0d495d",
                    900: "#0e3d4e",
                    950: "#062630",
                    DEFAULT: "#0e7ea3",
                    foreground: "#ffffff",
                },
                // 移ក រំកិល colorblue មកដាក់ក្នុង colors វិញ
                colorblue: {
                    50:  '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6', // Standard / Base Blue
                    600: '#2563eb',
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#1e3a8a',
                    950: '#172554',
                },
            },
            fontFamily: {
                sans: ['Times New Roman', 'Khmer OS Battambang', 'Times', 'serif', ...defaultTheme.fontFamily.sans],
                khmersimple: ['Khmer OS Muol Light', 'Muol Light', ...defaultTheme.fontFamily.sans],
                english: ['Times New Roman', 'Times', 'serif'], 
                khmersmart: ['Times New Roman', 'Khmer M1', 'sans-serif'],
            },
        },
    },

    plugins: [forms],
};