var PROD_DEST = "../www/"
var PUBLIC_PATH = "./public/"
/*global module:false*/
module.exports = function(grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        /* TEMPLATING */

        template: {
            views: {
                options: {
                    data: {
                        env: 'dev'
                    },
                },
                files: {
                    './public/index.html': PUBLIC_PATH + './index.tpl'
                }
            },
            prod: {
                options: {
                    data: {
                        env: 'prod'
                    }
                },
                files: {
                    './public/index.html': PUBLIC_PATH + './index.tpl'
                }
            },
            dev: {
                options: {
                    data: {
                        env: 'dev'
                    }
                },
                files: {
                    './public/index.html': PUBLIC_PATH + './index.tpl'
                }
            },
        },

        /* COMPILE OUR COFFEE SCRIPTS FILES */

        coffee: {
            dist: {
                options: {
                    bare: true
                },
                files: [{
                    expand: true,
                    cwd: PUBLIC_PATH + 'js',
                    src: ['{,*/}*.coffee'],
                    dest: PUBLIC_PATH + 'js',
                    ext: '.js'
                }]
            }
        },

    /* CONCAT AND MINIFY OUR JS FILES */

    uglify: {
        options: {
            banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - ' +
            '<%= grunt.template.today("yyyy-mm-dd") %> */',
            mangle:false
        },
        my_target: {
            files: {
                'app.js': [
                    PUBLIC_PATH + "js/storage.coffee"
                ]
            }
        }
    },

    /* COMPILE OUR SCSS FILES */

    sass: {
        options: {
            banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - ' +
            '<%= grunt.template.today("yyyy-mm-dd") %> */'
        },
        dist: {
            files: [{
                expand: true,
                src: ['public/css/*.scss'],
                ext: '.css'
            }]
        }
    },

    /* COMPRESS CSS RULE */

    cssmin: {
      minify: {
        files: {
            'css/app.css': ['css/app.css']
        }
      }
    },

    /* OUR WATCH RULES */

    watch: {
        html: {
            files: ['app/**/*.blade.php', 'public/partials/*.html'],
            options: {
                livereload: true
            }
        },
        coffee: {
            files: ['public/js/*.coffee'],
            tasks: ['coffee'],
            options: {
                livereload: true
            }
        },
        scss: {
            files: ['public/css/*.scss'],
            tasks: ['sass'],
            options: {
                livereload: true
            }
        },
    }

});

grunt.loadNpmTasks('grunt-contrib-watch');
grunt.loadNpmTasks('grunt-contrib-coffee');
grunt.loadNpmTasks('grunt-contrib-uglify');
grunt.loadNpmTasks('grunt-contrib-watch');
grunt.loadNpmTasks('grunt-contrib-sass');
grunt.loadNpmTasks('grunt-template');
grunt.loadNpmTasks('grunt-contrib-clean');
grunt.loadNpmTasks('grunt-contrib-cssmin');


grunt.registerTask('dev', ['watch']);
grunt.registerTask('prod', ['clean:prod' , 'sass', 'cssmin', 'coffee', 'uglify', 'template:prod', 'htmlmin' ]);
};