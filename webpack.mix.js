const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').vue()   

mix.styles([
    'public/css/bootstrap.css',
    'public/css/main.css',
    'public/css/common.css',
    'public/css/responsive.css',
    'public/css/font-awesome.min.css',
], 'public/css/all.css'); 

mix.copy('node_modules/push.js/bin/push.min.js', 'public/assets/js/push.min.js'); 