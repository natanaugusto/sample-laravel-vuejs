const mix = require('laravel-mix')
const Dotenv = require('dotenv-webpack')

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

mix.js('resources/assets/app/js/app.js', 'public/app/js')
  .sass('resources/assets/app/sass/app.scss', 'public/app/css')
  .webpackConfig({
    plugins: [
      new Dotenv()
    ]
  })
