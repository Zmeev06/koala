const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./resources/**/*.{js,jsx,ts,tsx,vue,php}"],
  safelist: ["bg-[#F5F5F5"],

  theme: {
    extend: {
      fontFamily: {
        sans: ["Inter var", ...defaultTheme.fontFamily.sans],
      },
      colors: {
        textcolor: "#130032",
      },
      width: {
        "1/7": "14.2857143%",
      },
      fontSize: {
        small: ["12px", "1rem"],
      },
      boxShadow: {
        small: "0px 0px 6px rgba(0, 0, 0, 0.25)",
      },
    },
  },
  plugins: [require("@tailwindcss/forms"), require("@tailwindcss/typography")],
};
