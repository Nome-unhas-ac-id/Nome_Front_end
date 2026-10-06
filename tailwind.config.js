/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./my-app/resources/**/*.blade.php",
    "./my-app/resources/**/*.js",
    "./resources/**/*.blade.php",
    "./**/*.html",
  ],
  theme: {
    extend: {
      colors: {
        canvas: '#F8F7F3',
        primary: {
          DEFAULT: '#ff5347',
          hover: '#e0453a',
          accent: '#ff5347',
        },
        border: {
          muted: '#d9d9d9',
        },
        surface: {
          card: '#ffffff',
        },
      },
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'sans-serif'],
      },
      borderRadius: {
        card: '12px',
        btn: '8px',
      },
    },
  },
  plugins: [],
};
