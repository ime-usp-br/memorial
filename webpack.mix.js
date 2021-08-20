const mix = require('laravel-mix');

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

 module.exports = {

    // stuff removed for clarity ...
  
    module: {
      loaders: [
        {
            test: /\.(scss)$/,
            use: [{
              loader: 'style-loader', // inject CSS to page
            }, {
              loader: 'css-loader', // translates CSS into CommonJS modules
            }, {
              loader: 'postcss-loader', // Run postcss actions
              options: {
                plugins: function () { // postcss plugins, can be exported to postcss.config.js
                  return [
                    require('autoprefixer')
                  ];
                }
              }
            }, {
              loader: 'sass-loader' // compiles Sass to CSS
            }]
          },
      ],
    },
  
    // stuff removed for clarity ...
  
    sassResources: './config/sass-resources.scss',
  }


mix
    .sass('resources/views/scss/style.scss', 'public/site/style.css')
    .scripts('node_modules/jquery/dist/jquery.js', 'public/site/jquery.js')
    .scripts('node_modules/bootstrap/dist/js/bootstrap.bundle.js', 'public/site/bootstrap.js');
