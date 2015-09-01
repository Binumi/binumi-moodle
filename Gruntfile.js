module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        clean: ['release/<%= pkg.version %>'],
        compress: {
            local: {
                options: {
                    mode: 'zip',
                    archive: 'release/<%= pkg.version %>/local_binumi.zip'
                },
                files: [
                    {
                        expand: true,
                        cwd: 'local/binumi/',
                        src: ['*'],
                        dest: 'binumi',
                    }
                ]
            },
            filter: {
                options: {
                    mode: 'zip',
                    archive: 'release/<%= pkg.version %>/filter_binumi.zip'
                },
                files: [
                    {
                        expand: true,
                        cwd: 'filter/binumi/',
                        src: ['*'],
                        dest: 'binumi',
                    }
                ]
            },
            atto: {
                options: {
                    mode: 'zip',
                    archive: 'release/<%= pkg.version %>/atto_binumi.zip'
                },
                files: [
                    {
                        expand: true,
                        cwd: 'lib/editor/atto/plugins/binumi/',
                        src: ['*'],
                        dest: 'binumi',
                    }
                ]
            },
            tinymce: {
                options: {
                    mode: 'zip',
                    archive: 'release/<%= pkg.version %>/tinymce_binumi.zip'
                },
                files: [
                    {
                        expand: true,
                        cwd: 'lib/editor/tinymce/plugins/binumi/',
                        src: ['*'],
                        dest: 'binumi',
                    }
                ]
            },
        },
    });

    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-compress');

    grunt.registerTask('release', ['clean', 'compress']);
    grunt.registerTask('default', 'release');

};

