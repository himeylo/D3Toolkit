var prodFiles = {};
prodFiles[require('../pipeline').prodJs] = [ 'build/strategy-relationships.js' ];

module.exports = {
  js: {
    files: {
      'build/strategy-relationships.js' : [ 'build/strategy-relationships.js' ]
    }
  },
  prod: { files: prodFiles },
  options: {
    mangle: true,
    preserveComments: false
  }
};
