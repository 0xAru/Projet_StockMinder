/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
      "./assets/**/*.js",
      "./templates/**/*.html.twig",
      "./src/Form/*.php",
      "./public/assets/js/*.js"
  ],
  theme: {
    extend: {
        colors: {
            //Couleurs personnalisées
            'raisin-black': '#272525',
            'wine': '#5B262F',
            'persian-orange': '#F08E45',
            'dun': '#DBCCA8',
            'dutch-white': '#F4E6C3',
        },
    },
  },
  plugins: [
      require('@tailwindcss/forms'),
  ],
}

