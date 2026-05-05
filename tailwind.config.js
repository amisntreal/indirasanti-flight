/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                'display': ['Cormorant Garamond', 'serif'],
                'sans': ['Jost', 'sans-serif'],
            },
            colors: {
                primary: {
                    DEFAULT: '#C8A97E',
                    dark: '#A8855A',
                    light: '#E8D5B5',
                },
            },
        },
    },
    plugins: [],
};
