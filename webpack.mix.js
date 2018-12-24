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

//mix.js('resources/assets/js/app.js', 'public/js')
//   .sass('resources/assets/sass/app.scss', 'public/css');
mix.styles([
            'resources/assets/css/bootstrap.min.css',
            'resources/assets/css/select2.min.css',
            'resources/assets/css/bootstrap-datepicker.standalone.min.css',
            'resources/assets/css/fontawesome-all.min.css',
            'resources/assets/css/app.css'
        ], 'public/css/app.css')
        .scripts([
            'resources/assets/js/jquery-3.3.1.slim.min.js',
            'resources/assets/js/bootstrap.bundle.min.js',
            'resources/assets/js/select2.full.min.js',
            'resources/assets/js/bootstrap-datepicker.min.js',
            'resources/assets/js/bootstrap-datepicker.fr.min.js',
            'resources/assets/js/fonction.js'
        ], 'public/js/app.js');