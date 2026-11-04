import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    darkMode: "class",

    theme: {
        extend: {
            fontFamily: {
                sans: ["Instrument Sans", "ui-sans-serif", "system-ui"],
            },
        },
    },

    plugins: [forms, typography],
};
