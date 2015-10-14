var elixir = require('laravel-elixir');
var gulp = require("gulp");
var shell = require("gulp-shell");

elixir(function (mix) {
    mix.sass('main.scss', 'resources/assets/css')

        .styles([
            '../bower_components/font-awesome/css/font-awesome.css',
            '../bower_components/select2/select2.css',
            '../bower_components/nivoslider/nivo-slider.css',
            'main.css'
        ], 'public/css/production.css')

        .scripts([
            '../bower_components/jquery/dist/jquery.js',
            '../bower_components/jquery.smooth-scroll/jquery.smooth-scroll.js',
            '../bower_components/bootstrap-sass/assets/javascripts/bootstrap.js',
            '../bower_components/select2/select2.js',
            '../bower_components/nivoslider/jquery.nivo.slider.js',
            '../bower_components/jquery-validate/dist/jquery.validate.js',
            'main.js'
        ], 'public/js/production.js')

        .task('publish_assets', ['public/**/*.css', 'public/**/*.js']);

    if (elixir.config.production)
    {
        mix.copy('resources/assets/bower_components/font-awesome/fonts', 'public/fonts');
        mix.copy('resources/assets/bower_components/select2/*.png', 'public/css');
        mix.copy('resources/assets/bower_components/world-flags-sprite/images', 'public/images');
    }
});

gulp.task('publish_assets', shell.task([
    "php ../../../artisan vendor:publish --tag=public --force"
]));