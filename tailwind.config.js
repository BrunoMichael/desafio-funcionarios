import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import plugin from 'tailwindcss/plugin';

export default {
  darkMode: 'class',
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './app/Livewire/**/*.php',
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#2563eb',
          light: '#3b82f6',
          dark: '#1e40af',
        },
        background: {
          light: '#f9fafb',
          dark: '#0f172a',
        },
        surface: {
          light: '#ffffff',
          dark: '#1e293b',
        },
      },
    },
  },
  plugins: [
    forms,
    plugin(function({ addUtilities, theme }) {
      const newUtilities = {
        '.scrollbar-dark': {
          '&::-webkit-scrollbar': {
            width: '8px',
            height: '8px',
            backgroundColor: theme('colors.gray.800'),
          },
          '&::-webkit-scrollbar-thumb': {
            backgroundColor: theme('colors.gray.600'),
          },
          '&::-webkit-scrollbar-thumb:hover': {
            backgroundColor: theme('colors.gray.400'),
          },
        },
      };
      addUtilities(newUtilities, ['dark']);
    }),
  ],
};
