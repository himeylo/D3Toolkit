module.exports = function (grunt) {
  grunt.registerTask('default', [
    'clean:pre',
    'sass:dist',
    'cssmin:dist',
    'concat:js',
    'uglify:js',
    'string-replace:dev'
  ]);
};
