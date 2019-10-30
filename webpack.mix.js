const mix = require('laravel-mix');

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

mix.webpackConfig({
    resolve: {
        alias: {
            'cldr$': 'cldrjs',
            'cldr': 'cldrjs/dist/cldr'
        }
    },
    module: {
        rules: [
            {
                test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
                use: {
                    loader: 'file-loader'
                }

            }
        ]
    }
});
mix.react('js/shortcodes/karzoom/App.js', 'includes/assets/js/hq-karzoom-booking-form.js');
mix.react('js/shortcodes/karzoom/AppForm.js', 'includes/assets/js/hq-karzoom-contact-form.js');
