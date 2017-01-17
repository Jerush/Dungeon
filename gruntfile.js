'use strict';

module.exports = function (grunt) {
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // Config
    grunt.initConfig({

        concat: {

            // Application
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - -

            dg: {
                files: {
                    'www/assets/js/dungeon.js': [
                        'src/Dungeon/js/Application.js',
                        'src/Dungeon/js/*/**/*.js',
                        'src/Dungeon/js/Bootstrap.js'
                    ]
                }
            }
        },

        postcss: {

            // Libraries
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - -

            bt: {
                options: {
                    map: true,
                    processors: [
                        require('autoprefixer')({
                            browsers: ['last 2 versions']
                        }),
                        require('cssnano')({
                            discardComments: {
                                removeAll: true
                            }
                        })
                    ]
                },
                files: {
                    'www/assets/css/lib/bootstrap.min.css': [
                        'www/assets/css/lib/bootstrap.css'
                    ]
                }
            },

            // Application
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - -

            dg: {
                options: {
                    map: true,
                    processors: [
                        require('autoprefixer')({
                            browsers: ['last 2 versions']
                        }),
                        require('cssnano')({
                            discardComments: {
                                removeAll: true
                            }
                        })
                    ]
                },
                files: {
                    'www/assets/css/dungeon.min.css': [
                        'www/assets/css/dungeon.css'
                    ]
                }
            }
        },

        sass: {

            // Libraries
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - -

            bt: {
                options: {
                    sourcemap: 'file'
                },
                files: {
                    'www/assets/css/lib/bootstrap.css': [
                        'src/Bootstrap/scss/bootstrap.scss'
                    ]
                }
            },

            // Application
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - -

            dg: {
                options: {
                    loadPath: [
                        'src/Bootstrap/scss',
                        'src/Dungeon/scss'
                    ],
                    sourcemap: 'file'
                },
                files: {
                    'www/assets/css/dungeon.css': [
                        'src/Dungeon/scss/dungeon.scss'
                    ]
                }
            }
        },

        uglify: {

            // Application
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - -

            dg: {
                options: {
                    sourceMap: true
                },
                files: {
                    'www/assets/js/dungeon.min.js': [
                        'www/assets/js/dungeon.js'
                    ]
                }
            }
        },

        watch: {

            // Stylesheets
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - -

            dg_sass: {
                files: [
                    'src/Dungeon/scss/**/*.scss',
                    'src/Dungeon/scss/*.scss'
                ],
                tasks: [
                    'sass:dg',
                    'postcss:dg'
                ]
            },
            bt_sass: {
                files: [
                    'src/Bootstrap/**/*.scss'
                ],
                tasks: [
                    'sass:bt',
                    'postcss:bt'
                ]
            },

            // Scripts
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - -

            dg_concat: {
                files: [
                    'src/Dungeon/js/**/*.js',
                    'src/Dungeon/js/*.js'
                ],
                tasks: [
                    'concat:dg',
                    'uglify:dg',
                ]
            }
        }
    });

    // Default task
    grunt.registerTask('default', ['watch']);

    // External modules
    grunt.loadNpmTasks('grunt-postcss');
};