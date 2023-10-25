var prodFiles = {};
prodFiles[require('../pipeline').prodJs] = [ 'build/app.js' ];

module.exports = {
  js: {
    files: {
      'build/app.js' : [ 'build/app.js' ]
    }
  },
  prod: { files: prodFiles },
  options: {
    mangle: true,
    preserveComments: false
  }
};
