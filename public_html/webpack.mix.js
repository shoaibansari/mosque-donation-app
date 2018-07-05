const { mix } = require('laravel-mix');

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
mix.styles([
    'resources/assets/themes/default/css/bootstrap.min.css',
    'resources/assets/themes/default/css/theme-plugins.css',
    'resources/assets/themes/default/css/shortcodes.css',
    'resources/assets/themes/default/css/style.css',
    'resources/assets/themes/default/css/responsive.css',
    'resources/assets/themes/default/plugins/intl-tel-input/css/intlTelInput.css'
], 'public/frontend/default/css/app.css').options({
    processCssUrls: true
});

mix.scripts([
    'resources/assets/themes/default/js/vendor/jquery-2.1.4.min.js',
    'resources/assets/themes/default/js/bootstrap.min.js',
    'resources/assets/themes/default/js/plugins.js',
    'resources/assets/themes/default/js/main.js'
], 'public/frontend/default/js/app.js');


mix.version();

