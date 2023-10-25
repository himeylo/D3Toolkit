var timestamp = Date.now();

module.exports = {
  prodJs: 'build/app' + timestamp + '.js',
  prodCss: 'build/app' + timestamp + '.css',

  css: [
    'build/app.css'
  ],

  libraries: [],

  js: [
    'js/config/*.js',
    'js/*/*.js',
    'js/*.js'
  ]
};
