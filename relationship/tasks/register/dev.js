module.exports = function (grunt) {
  grunt.registerTask('dev', [
    'clean:pre',
    'concat:js',
    'string-replace:dev'
  ]);
};
