const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
  content: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/views/**/*.blade.php",
  ],

  theme: {
    colors: {
      mainTextDark: "#1D1B20",
      mainTextLight: "#FEFEFE",
      mainPrimary: "#31B492",
    },
    extend: {
      fontFamily: {
        sans: ["Nunito", ...defaultTheme.fontFamily.sans],
      },
    },
  },

  plugins: [require("@tailwindcss/forms")],
};
