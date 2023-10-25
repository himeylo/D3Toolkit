module.exports = function (grunt) {
  grunt.registerTask('dev', [
    'clean:pre',
    'sass:dev',
    'concat:js',
    'string-replace:dev'
  ]);
};
