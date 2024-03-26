/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      colors: {
        "pblue": "#ace4e7",
        "pred": "#e58463",
        "pbg": "#1e646f"
      }
    },
  },
  plugins: [],
}
