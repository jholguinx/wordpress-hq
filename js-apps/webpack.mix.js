const mix = require('laravel-mix');

mix.setPublicPath('../');
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
mix.react('shortcodes/map-form/App.js', 'includes/assets/js/hq-map-booking-form.js');
mix.react('shortcodes/availability-grid/App.js', 'includes/assets/js/hq-availability-grid.js');
mix.react('themes/gcar/shortcodes/vehicle-filter/App.js', 'includes/assets/js/hq-gcar-vehicle-filter.js');
