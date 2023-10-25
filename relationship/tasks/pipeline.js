var timestamp = Date.now();

module.exports = {
  prodJs: 'build/strategy-relationships' + timestamp + '.js',

  libraries: [],

  js: [
    'js/config/*.js',
    'js/*/*.js',
    'js/*.js'
  ]
};
