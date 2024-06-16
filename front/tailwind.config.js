/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/framework/**/*.vue'],
  theme: {
    extend: {
        colors: {
            'primary': '#118afa',
            'secondary': '#057ded',
            'black': '#333333'
        },
    },
  },
  plugins: [],
}

