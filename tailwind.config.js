/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
        "./templates/**/*.html.twig", 
        "./public/**/*.html", 
        "./assets/**/*.{js,ts,jsx,tsx}", 
    ],
	theme: {
		extend: {
			colors: {
				'primary': "var(--color--primary)",
				'secondary': "var(--color--secondary)",
				// 'tertiary': "var(--color--tertiary)",
				'dark': "var(--color--dark)",
				'light': "var(--color--light)",
			},
			zIndex: {
				"-10": "-10",
				"-20": "-20",
			},
		},
	},
};