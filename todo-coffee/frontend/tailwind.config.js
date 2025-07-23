/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,jsx,ts,tsx}"
  ],
theme: {
    extend: {
      colors: {
        coffee: {
          cream: '#ece0d1',
          light: '#dbc1ac',
          medium: '#967259',
          dark: '#634832',
          espresso: '#38220f'
        }
      }
    }
  },
  plugins: [],
}
