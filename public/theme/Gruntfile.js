module.exports = function(grunt) {
  grunt.initConfig({
    less: {
      development: {
        options: {
          compress: false,
          yuicompress: false,
          optimization: 2
        },
        files: {
          "css/main.css": "less/main.less"
        }
      }
    },
    autoprefixer: {
      development: {
        options: {
        },
        src: 'css/main.css',
        dest: 'css/main.css'
      }
    },
    watch: {
      styles: {
        files: ['less/**/*.less'],
        tasks: ['less', 'autoprefixer'],
        options: {
          nospawn: true
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-autoprefixer');

  grunt.registerTask('default', ['watch']);
};