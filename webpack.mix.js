let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

require('laravel-mix-merge-manifest');
mix.mergeManifest();

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');
mix.js('Modules/HR/Resources/assets/js/app.js', 'public/js/hr.js')
    .sass('Modules/HR/Resources/assets/sass/app.scss', 'public/css/hr.css');

mix.version();