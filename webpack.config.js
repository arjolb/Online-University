let themeLocation = './wp-content/themes/bio-ju/';

const path = require('path');

module.exports={
    entry:{
        Vendor: themeLocation+'js/Vendor/Vendor.js'
    },
    output:{
        path : path.resolve(__dirname,themeLocation+'js'),
        filename : '[name].js'
    },
    module:{
        rules: [
            {
                use:{
                    loader : 'babel-loader',
                    options:{
                        presets : ['@babel/preset-env']
                    }
                },
                test: /\.js$/,
                exclude: /node_modules/
            }
        ]
    }
}