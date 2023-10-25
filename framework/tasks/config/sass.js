const sass = require('sass');

module.exports = {
  options: {
    implementation: sass,
    includePaths: ['scss/', 'libraries/foundation/scss/', 'libraries/compass-mixins/lib/'],
    outFile: 'build/app.css'
  },
  dev: {
    options: {
      sourceComments: true,
      sourceMap: true,
    },
    files: {
      'build/app.css': 'scss/*.scss'
    }
  },
  dist: {
    options: {
      outputStyle: 'compressed',
    },
    files: {
      'build/app.css': 'scss/*.scss'
    }
  }
};
