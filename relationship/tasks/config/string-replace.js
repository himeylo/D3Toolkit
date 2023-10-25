module.exports = {
  dev: {
    files: {
      '../page-strategy-relationships.php': '../page-strategy-relationships.php'
    },
    options: {
      replacements: [{
        pattern: /build\/strategy-relationships.*\.js/,
        replacement: 'build/strategy-relationships.js'
      }]
    }
  },
  prod: {
    files: {
      '../page-strategy-relationships.php': '../page-strategy-relationships.php'
    },
    options: {
      replacements: [{
        pattern: /build\/strategy-relationships.*\.js/,
        replacement: require('../pipeline').prodJs
      }]
    }
  }
};
