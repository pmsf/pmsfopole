module.exports = function (grunt) {
    const sass = require('node-sass');

    // load plugins as needed instead of up front
    require('jit-grunt')(grunt);
    require('phplint').gruntPlugin(grunt);

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        sass: {
            options: {
                implementation: sass
            },
            dist: {
                files: {
                    'static/dist/css/style.built.css': 'static/sass/main.scss'
                }
            }
        },
        eslint: {
            src: ['static/js/*.js', '!js/vendor/**/*.js']
        },
        babel: {
            options: {
                sourceMap: true,
                presets: ['env']
            },
            prod: {
                files: {
                    'static/dist/js/stats.built.js': 'static/js/stats.js'
                }
            },
            dev: {
                files: {
                    'static/dist/js/stats.min.js': 'static/js/stats.js'
                }
            }
        },
        uglify: {
            options: {
                banner: '/*\n <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> \n*/\n',
                sourceMap: true,
                compress: {
                    unused: false
                }
            },
            prod: {
                files: {
                    'static/dist/js/stats.min.js': 'static/dist/js/stats.built.js'
                }
            }
        },
        minjson: {
            build: {
                files: {
                    'static/dist/data/pokemon.min.json': 'static/data/pokemon.json',
                    'static/dist/data/items.min.json': 'static/data/items.json',
                    'static/dist/data/grunttype.min.json': 'static/data/grunttype.json',
                    'static/dist/locales/de.min.json': 'static/locales/de.json',
                    'static/dist/locales/pl.min.json': 'static/locales/pl.json'
                }
            }
        },
        clean: {
            build: {
                src: 'static/dist'
            }
        },
        watch: {
            options: {
                interval: 1000,
                spawn: true
            },
            js: {
                files: ['static/js/**/*.js'],
                options: {livereload: true},
                tasks: ['js-lint', 'js-build']
            },
            json: {
                files: ['static/data/*.json', 'static/locales/*.json'],
                options: {livereload: true},
                tasks: ['json']
            },
            css: {
                files: '**/*.scss',
                options: {livereload: true},
                tasks: ['css-build']
            }
        },
        cssmin: {
            options: {
                banner: '/*\n <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> \n*/\n'
            },
            build: {
                files: {
                    'static/dist/css/style.min.css': 'static/dist/css/style.built.css'
                }
            }
        },
        phplint: {
            files: ['**.php', '**/*.php', '!node_modules/**']
        },
        htmlmin: {
            dist: {
                options: {
                    removeComments: true,
                    collapseWhitespace: true
                },
                files: {
                    'index.php': 'pre-index.php'
                }
            }
        },
        cacheBust: {
            options: {
                assets: ['static/dist/**/*.css', 'static/dist/**/*.json', 'static/dist/**/*.js', '!static/dist/**/*built*']
            },
            taskName: {
                files: [{
                    src: ['index.php', 'user.php']
                }]
            }
        }
    });

    grunt.registerTask('js-build', ['babel:prod', 'newer:uglify']);
    grunt.registerTask('js-dev', ['babel:dev']);
    grunt.registerTask('css-build', ['newer:sass', 'newer:cssmin']);
    grunt.registerTask('js-lint', ['newer:eslint']);
    grunt.registerTask('json', ['newer:minjson']);
    grunt.registerTask('php-lint', ['newer:phplint']);
    grunt.registerTask('html-build', ['htmlmin', 'cacheBust']);

    grunt.registerTask('build', ['clean', 'js-build', 'css-build', 'json', 'html-build']);
    grunt.registerTask('dev', ['clean', 'js-dev', 'css-build', 'json', 'html-build']);
    grunt.registerTask('lint', ['js-lint', 'php-lint']);
    grunt.registerTask('default', ['build', 'watch']);

};
