var pipeline = require('../pipeline');

var prodFiles = {};
prodFiles[pipeline.prodCss] = pipeline.css;

module.exports = {
  options: {
    keepSpecialComments: 0
  },
  dist: {
    files: {
      'build/app.css': pipeline.css
    }
  },
  prod: { files: prodFiles }
};
