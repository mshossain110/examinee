const mix = require('laravel-mix')
const path = require('path')
require('laravel-mix-eslint-config')

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

function assetsPath (dir = '') {
    return path.join(__dirname, './resources/assets/', dir)
}

function publicPath (dir = '') {
    return path.join(__dirname, './public/', dir)
}

mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue', '.json', '.scss'],
        alias: {
            vue$: 'vue/dist/vue.esm.js',
            node_modules: './node_modules',
            '@c': assetsPath('js/components'),
            '@src': assetsPath('js')
        }
    }
})

mix.copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', publicPath('fonts/fontawesome'))
mix.copy('node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.js', publicPath('js/lib/jquery.fancybox.min.js'))
mix.copy('node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.css', publicPath('css/lib/jquery.fancybox.min.css'))

mix.js(assetsPath('js/app.js'), publicPath('js')).eslint()
mix.js(assetsPath('js/bootstrap.js'), publicPath('js')).eslint()
mix.extract(['vue', 'vue-router', 'jquery', 'popper.js', 'bootstrap', 'axios', 'lodash', 'moment'])

mix.sass(assetsPath('sass/app.scss'), publicPath('css'))

if (mix.inProduction()) {
    mix.version()
}
