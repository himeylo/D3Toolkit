module.exports = {
  dev: {
    files: {
      '../page-smart-strategies.php': '../page-smart-strategies.php',
      // '../page-finance-strategies.php': '../page-finance-strategies.php',
      // '../page-public_engagement-strategies.php': '../page-public_engagement-strategies.php',
      '../page-strategy-relationships.php': '../page-strategy-relationships.php'
    },
    options: {
      replacements: [{
        pattern: /build\/app.*\.js/,
        replacement: 'build/app.js'
      }, {
        pattern: /build\/app.*\.css/,
        replacement: 'build/app.css'
      }]
    }
  },
  prod: {
    files: {
      '../page-smart-strategies.php': '../page-smart-strategies.php',
      // '../page-finance-strategies.php': '../page-finance-strategies.php',
      // '../page-public_engagement-strategies.php': '../page-public_engagement-strategies.php',
      '../page-strategy-relationships.php': '../page-strategy-relationships.php'
    },
    options: {
      replacements: [{
        pattern: /build\/app.*\.js/,
        replacement: require('../pipeline').prodJs
      }, {
        pattern: /build\/app.*\.css/,
        replacement: require('../pipeline').prodCss
      }]
    }
  }
};
