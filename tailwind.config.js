import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./vendor/livewire/flux-pro/stubs/**/*.blade.php",
        "./vendor/livewire/flux/stubs/**/*.blade.php",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter", "sans-serif"],
            },
            colors: {
                // Accent variables are defined in resources/css/app.css...
                accent: {
                    DEFAULT: "var(--color-accent)",
                    content: "var(--color-accent-content)",
                    foreground: "var(--color-accent-foreground)",
                },
            },
        },
    },
    darkMode: "selector",
    plugins: [forms],
};
