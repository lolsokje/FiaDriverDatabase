const mix = require('laravel-mix');
const path = require('path');

mix.webpackConfig({
    resolve: {
        alias: {
            ziggy: path.resolve('vendor/tightenco/ziggy/dist'),
        },
    },
});

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/css/app.scss', 'public/css')
    .vue();
