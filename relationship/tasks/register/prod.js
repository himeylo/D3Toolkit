module.exports = function (grunt) {
  grunt.registerTask('prod', [
    'clean:pre',
    'concat:js',
    'uglify:prod',
    'clean:post',
    'string-replace:prod'
  ]);
};
