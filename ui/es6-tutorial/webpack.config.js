var path = require('path');
var webpack = require('webpack');

module.exports = {
    entry: {
        babelpolyfill: 'babel-polyfill', 
        // app: './js/main.js', 
        // ratefinder: './js/ratefinder.js',
        // entry: './js/main.js',
        es6: './js/es6.js'
    },
    output: {
        path: path.resolve(__dirname, 'build'),
        filename: '[name].bundle.js'
        // filename: 'main.bundle.js'
    },
    module: {
        loaders: [
            {
                test: /\.js$/,
                loader: 'babel-loader',
                query: {
                    presets: ['es2015']
                }
            }
        ]
    },
    stats: {
        colors: true
    },
    devtool: 'source-map'
};