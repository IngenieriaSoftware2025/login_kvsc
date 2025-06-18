const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
module.exports = {
  mode: 'development',
  entry: {
    'js/app' : './src/js/app.js',
    'js/inicio' : './src/js/inicio.js',
    'js/login/index' : './src/js/login/index.js',
    'js/registro/index' : './src/js/registro/index.js',
    'js/aplicacion/index' : './src/js/aplicacion/index.js',
    'js/permisos/index' : './src/js/permisos/index.js',
    'js/asignacion/index' : './src/js/asignacion/index.js',
    'js/marca/index' : './src/js/marca/index.js',
    'js/cliente/index' : './src/js/cliente/index.js',
    'js/inventario/index' : './src/js/inventario/index.js',
    'js/venta/index' : './src/js/venta/index.js',
    'js/reparacion/index' : './src/js/reparacion/index.js',
    'js/estadistica/index' : './src/js/estadistica/index.js',
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'public/build')
  },
  plugins: [
    new MiniCssExtractPlugin({
        filename: 'styles.css'
    })
  ],
  module: {
    rules: [
      {
        test: /\.(c|sc|sa)ss$/,
        use: [
            {
                loader: MiniCssExtractPlugin.loader
            },
            'css-loader',
            'sass-loader'
        ]
      },
      {
        test: /\.(png|svg|jpe?g|gif)$/,
        type: 'asset/resource',
      },
    ]
  }
};