const mix = require('laravel-mix')
const path = require('path')
const webpack = require('webpack')
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
const CKEditorWebpackPlugin = require('@ckeditor/ckeditor5-dev-webpack-plugin')
const CKEStyles = require('@ckeditor/ckeditor5-dev-utils').styles
const CKERegex = {
    svg: /ckeditor5-[^/\\]+[/\\]theme[/\\]icons[/\\][^/\\]+\.svg$/,
    css: /ckeditor5-[^/\\]+[/\\]theme[/\\].+\.css/
}

Mix.listen('configReady', webpackConfig => {
    const rules = webpackConfig.module.rules
    const targetSVG = /(\.(png|jpe?g|gif|webp)$|^((?!font).)*\.svg$)/
    const targetCSS = /\.css$/

    // exclude CKE regex from mix's default rules
    // if there's a better way to loop/change this, open to suggestions
    for (const rule of rules) {
        if (rule.test.toString() === targetSVG.toString()) {
            rule.exclude = CKERegex.svg
        } else if (rule.test.toString() === targetCSS.toString()) {
            rule.exclude = CKERegex.css
        }
    }
})

mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue', '.json', '.scss'],
        alias: {
            vue$: 'vue/dist/vue.esm.js',
            node_modules: './node_modules',
            '@c': assetsPath('js/components'),
            '@src': assetsPath('js')
        }
    },
    plugins: [
        new CKEditorWebpackPlugin({
            language: 'en',
            addMainLanguageTranslationsToAllAssets: true
        }),
        new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/)
    ],
    module: {
        rules: [
            {
                test: CKERegex.svg,
                use: ['raw-loader']
            },
            {
                test: CKERegex.css,
                use: [
                    {
                        loader: 'style-loader',
                        options: {
                            // singleton: true,
                            injectType: 'singletonStyleTag'
                        }
                    },
                    {
                        loader: 'postcss-loader',
                        options: CKEStyles.getPostCssConfig({
                            themeImporter: {
                                themePath: require.resolve('@ckeditor/ckeditor5-theme-lark')
                            },
                            minify: true
                        })
                    }
                ]
            }
        ]
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
