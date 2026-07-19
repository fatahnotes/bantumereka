import animate from 'tailwindcss-animate'

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#C62828',
          dark: '#A51D1D',
          light: '#EF5350',
        },
        deep: {
          DEFAULT: '#0A2540',
          light: '#1A3A5C',
        },
        gold: {
          DEFAULT: '#D4AF37',
          light: '#F9E79F',
          dark: '#C9A52C',
        },
        cream: '#FFF8F0',
        soft: '#E8F0FE',
      },
      fontFamily: {
        sans: ['Segoe UI', 'system-ui', '-apple-system', 'sans-serif'],
      },
      borderRadius: {
        'xl': '16px',
        '2xl': '24px',
      },
    },
  },
  plugins: [animate],
}
