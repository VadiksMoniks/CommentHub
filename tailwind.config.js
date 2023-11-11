/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        deepWater: '#3498db',
        creamy: '#FCEEC0',
        
      },
    },
  },
  plugins: [],
}
