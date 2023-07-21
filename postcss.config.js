//module.exports = {
//  plugins: {
//    tailwindcss: {},
//    autoprefixer: {},
//  },
//}
module.exports = {
  plugins: [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
    // Ajoutez d'autres plugins PostCSS ici si nécessaire
  ],
};