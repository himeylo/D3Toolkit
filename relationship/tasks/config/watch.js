module.exports = {
  css: {
    files: ['scss/*', 'scss/partials/*'],
    tasks: ['sass:dev', 'string-replace:dev']
  },
  js: {
    files: ['js/**/*', 'json/**/*', 'scss/*', 'scss/partials/*'],
    tasks: ['concat:js', 'string-replace:dev'],
  },
  options: { livereload: true }
};
