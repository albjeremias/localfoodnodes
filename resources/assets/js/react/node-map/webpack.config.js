process.env.NODE_ENV = 'production';

var webpack = require('webpack')

module.exports = {
  entry: ['babel-polyfill', './index'],
  output: {
      path: __dirname,
      filename: '../../../../../public/js/node-map.js'
  },
  plugins: [
    new webpack.DefinePlugin({
      'process.env': {
        'NODE_ENV': JSON.stringify('production')
      }
    }),
    new webpack.optimize.UglifyJsPlugin({
      sourceMap: false,
      compress: {
        warnings: false,
        screw_ie8: true,
        conditionals: true,
        unused: true,
        comparisons: true,
        sequences: true,
        dead_code: true,
        evaluate: true,
        if_return: true,
        join_vars: true,
      }
    }),
    new webpack.optimize.DedupePlugin(),
    new webpack.optimize.AggressiveMergingPlugin()
  ],
  devtool: process.env.NODE_ENV === 'production' ? false : 'eval',
  module: {
    loaders: [
      {
        test: /\.js$/,
        loader: 'babel',
        exclude: /node_modules/,
        query: {
          presets:['react', 'es2015']
        }
      }
    ]
  }
};
