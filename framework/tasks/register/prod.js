module.exports = function (grunt) {
  grunt.registerTask('prod', [
    'clean:pre',
    'sass:dist',
    'cssmin:prod',
    'concat:js',
    'uglify:prod',
    'clean:post',
    'string-replace:prod'
  ]);
};
