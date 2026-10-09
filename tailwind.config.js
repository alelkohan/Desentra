/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./app/Views/**/*.{php,html}",
    "./public/**/*.{js,html}",
  ],
  theme: {
    extend: {
      colors: {
        desentra: {
          orange: '#F08F0E',
          gold: '#F1B435',
          teal: '#008683',
          turquoise: '#00B6AA',
          blue: '#3C7087',
          'blue-dark': '#1469A5',
          white: '#FFFFFF',
          dark: '#131313',
          'mint-light': '#9ECECA',
        }
      },
      fontFamily: {
        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
      }
    },
  },
  plugins: [],
}
