const mix = require('laravel-mix');
const path = require('path');
const fs = require('fs-extra');
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

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css')
    .vue()
    .disableSuccessNotifications()
    .extract([
        'vue-router',
        'axios',
        'laravel-mix',
        'lodash',
        'vue-loader',
        'vue-template-compiler',
        'bootstrap',
        'bootstrap-vue',
        'jquery',
        'popper.js',
        'vue-meta',
        'vuex',
        'vuex-persistedstate',
    ]);


if (mix.inProduction()) {
    mix.version();
} else {
    mix.sourceMaps();
}




mix.then(() => {
    if (mix.inProduction()) {
        // process.nextTick(() => publishAssets())
    }
});

function publishAssets() {
    const publicDir = path.resolve(__dirname, './public');
    fs.removeSync(path.join(publicDir, 'dest'));
    fs.copySync(path.join(publicDir, '/', 'dest'), path.join(publicDir, 'dest'));
    fs.removeSync(path.join(publicDir, '/'));
};

mix.copyDirectory('resources/assets/fonts', 'public/assets/fonts');

mix.webpackConfig({
    devServer: {
        host: '127.0.0.1',
        port: 8081,
        hot: true
    }
});

mix.options({
    hmrOptions: {
        host: '127.0.0.1',
        port: 8081
    }
});