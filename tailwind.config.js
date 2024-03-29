/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      screens: {
        'tall': { 'raw': '(min-height: 768px)' },
        'medium': {'raw': '(min-height: 640px)'}
      },
      colors: {
        "pblue": "#ace4e7",
        "pred": "#e58463",
        "pbg": "#1e646f",
      },
      boxShadow: {
        "inset-2/4": "inset 2px 2px 4px #d1d9e6, inset -2px -2px 4px #f9f9f9",
        "inset-4/4": "inset 4px 4px 4px #d1d9e6, inset -4px -4px 4px #f9f9f9",
        "inset-8/12": "inset 8px 8px 12px #d1d9e6, inset -8px -8px 12px #f9f9f9",
        "outset-6/10": "6px 6px 10px #d1d9e6, -6px -6px 10px #f9f9f9",
        "outset-2/6": "2px 2px 6px #d1d9e6, -2px -2px 6px #f9f9f9",
        "outset-4/10": "4px 4px 10px #d1d9e6, -4px -4px 10px #f9f9f9",
        "outset-8/16": "8px 8px 16px #d1d9e6, -8px -8px 16px #f9f9f9",
        // tailwind color palette (https://tailwindcss.com/docs/customizing-colors#customizing), 200 and 400 strong colors
        "danger-inset-2/4": "inset 2px 2px 4px #f87171, inset -2px -2px 4px #fecaca",
        "success-inset-2/4": "inset 2px 2px 4px #4ade80, inset -2px -2px 4px #bbf7d0"
      }
    },
  },
  plugins: [],
}
