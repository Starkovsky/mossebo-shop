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

publicDir = 'public';

mix.js('resources/assets/js/app.js', publicDir + '/assets/js')
    .sass('resources/assets/sass/app.scss', publicDir + '/assets/css')
    .options({
        processCssUrls: false,
        postCss: [
            //require('postcss-cssnext'),
            require('postcss-custom-media'),
            require('postcss-short-position'),
            require('postcss-short-font-size'),
        ]
    })
    .extract([
        'babel-polyfill',
        'vue',
        'vuex',
        'jquery',
        'lodash',
        'popper.js',
        'axios',
        'bootstrap',
        'slick-carousel',
        'magnific-popup'
    ])
    .version();

if (!mix.inProduction()) {
    mix.webpackConfig({
        devtool: 'source-map'
    })
        .sourceMaps()
}

mix.autoload({
    jquery: ['$', 'window.jQuery', 'jQuery']
});

mix.browserSync({
    proxy: {
        target: "https://mossebo-shop.test"
    },
    https: true,
    open: false
});


mix.setResourceRoot(path.normalize(publicDir));
mix.setPublicPath(path.normalize(publicDir));
