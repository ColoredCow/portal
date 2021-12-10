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
mix.js('Modules/User/Resources/assets/js/app.js', 'public/js/user.js')
   .sass('Modules/User/Resources/assets/sass/app.scss', 'public/css/user.css');
mix.js('Modules/SalesAutomation/Resources/assets/js/app.js', 'public/js/salesautomation.js')
   .sass('Modules/SalesAutomation/Resources/assets/sass/app.scss', 'public/css/salesautomation.css');
mix.js('Modules/EffortTracking/Resources/assets/js/app.js', 'public/js/efforttracking.js')
   .sass('Modules/EffortTracking/Resources/assets/sass/app.scss', 'public/css/efforttracking.css');
mix.js('Modules/Invoice/Resources/assets/js/app.js', 'public/js/invoice.js')
   .sass('Modules/Invoice/Resources/assets/sass/app.scss', 'public/css/invoice.css');

mix.version();