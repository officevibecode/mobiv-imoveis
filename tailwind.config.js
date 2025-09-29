import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Filament/**/*.php',
        './vendor/filament/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#01589F',
                    50: '#E6F0F9',
                    100: '#CCE1F3',
                    200: '#99C3E7',
                    300: '#66A5DB',
                    400: '#3387CF',
                    500: '#01589F',
                    600: '#01467F',
                    700: '#01345F',
                    800: '#002340',
                    900: '#001120',
                },
                accent: {
                    DEFAULT: '#C1D460',
                    50: '#F5F9E8',
                    100: '#EBF3D1',
                    200: '#D7E7A3',
                    300: '#C3DB75',
                    400: '#C1D460',
                    500: '#A8BB4D',
                    600: '#8F9F3A',
                    700: '#6B762C',
                    800: '#484E1D',
                    900: '#24270F',
                },
                ink: '#111827',
                muted: '#6B7280',
                surface: '#F5F7FA',
            },
            borderRadius: {
                '2xl': '1rem',
                '3xl': '1.5rem',
            },
            boxShadow: {
                'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                'soft-lg': '0 10px 40px -10px rgba(0, 0, 0, 0.1)',
            },
            container: {
                center: true,
                padding: {
                    DEFAULT: '1rem',
                    sm: '2rem',
                    lg: '4rem',
                    xl: '5rem',
                    '2xl': '6rem',
                },
            },
            aspectRatio: {
                '4/3': '4 / 3',
                '16/9': '16 / 9',
            },
        },
    },

    plugins: [forms, typography],
};
