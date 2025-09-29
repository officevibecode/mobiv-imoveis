/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./app/View/Components/**/*.php",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#01589F',
          50: '#E6F2FA',
          100: '#CCE5F5',
          200: '#99CBE8',
          300: '#66B1DB',
          400: '#3397CE',
          500: '#01589F',
          600: '#01467F',
          700: '#01345F',
          800: '#012240',
          900: '#001120',
        },
        accent: {
          DEFAULT: '#C1D460',
          50: '#F5F9E6',
          100: '#EBF3CC',
          200: '#D7E799',
          300: '#C3DB66',
          400: '#AFCF33',
          500: '#C1D460',
          600: '#9AAA4D',
          700: '#73803A',
          800: '#4D5527',
          900: '#262B13',
        },
      },
    },
  },
  plugins: [],
}
