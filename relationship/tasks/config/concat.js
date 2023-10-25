var pipeline = require('../pipeline');

module.exports = {
  js: {
    src: pipeline.libraries.concat(['js/config/parse.prod.env'], pipeline.js),
    dest: 'build/strategy-relationships.js'
  },
  experimental: {
    src: pipeline.libraries.concat(['js/config/parse.dev.env'], pipeline.js),
    dest: 'build/strategy-relationships.js'
  }
};
