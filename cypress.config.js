const { defineConfig } = require("cypress");

module.exports = defineConfig({
	e2e: {
		// We've imported your old cypress plugins here.
		// You may want to clean this up later by importing these.
		"baseUrl": "http://127.0.0.1:8000",
		"$schema": "https://on.cypress.io/cypress.schema.json",
		// setupNodeEvents(on, config) {
		// 	return config;
		// },
	},
});
