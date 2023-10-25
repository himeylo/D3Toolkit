module.exports = function (grunt) {
  grunt.registerTask('default', [
    'clean:pre',
    'concat:js',
    'uglify:js',
    'string-replace:dev'
  ]);
};
