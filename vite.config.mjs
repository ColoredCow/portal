import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue2';
import fs from 'fs';

// Each module keeps its own JS/SASS entry under Resources/assets. Discover them
// from disk so a new module is picked up without editing this file.
const moduleEntries = fs.existsSync('Modules')
    ? fs
        .readdirSync('Modules')
        .flatMap((name) => [
            `Modules/${name}/Resources/assets/js/app.js`,
            `Modules/${name}/Resources/assets/sass/app.scss`,
        ])
        .filter((file) => fs.existsSync(file))
    : [];

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/sass/app.scss',
                ...moduleEntries,
            ],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: {
            // The app mounts with `new Vue({ el })` and in-DOM templates, so it
            // needs the full build that includes the template compiler.
            vue: 'vue/dist/vue.esm.js',
        },
        // Webpack/Mix resolved extensionless `.vue` imports; Vite does not by
        // default, so add it back to avoid touching every component import.
        extensions: ['.mjs', '.js', '.json', '.vue'],
    },
});
