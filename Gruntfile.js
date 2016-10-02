module.exports = function (grunt) {

	// load all grunt tasks matching the `grunt-*` pattern
	// Ref. https://npmjs.org/package/load-grunt-tasks
	require('load-grunt-tasks')(grunt);

	grunt.initConfig({
		// Internationalize WordPress themes and plugins
		// Ref. https://www.npmjs.com/package/grunt-wp-i18n
		//
		// IMPORTANT: `php` and `php-cli` should be installed in your system to run this task
		makepot: {
			target: {
				options: {
					cwd: '.', // Directory of files to internationalize.
					domainPath: 'languages/', // Where to save the POT file.
					exclude: ['node_modules/*', 'tests/*', 'docs/*'], // List of files or directories to ignore.
					mainFile: 'index.php', // Main project file.
					potFilename: 'wp-mobile.pot', // Name of the POT file.
					potHeaders: {// Headers to add to the generated POT file.
						poedit: true, // Includes common Poedit headers.
						'Last-Translator': 'Dhaval Parekh <dmparekh007@gmail.com>',
						'report-msgid-bugs-to': 'http://wpm.ciphersoul.com/',
						'x-poedit-keywordslist': true // Include a list of all possible gettext functions.
					},
					type: 'wp-plugin', // Type of project (wp-plugin or wp-theme).
					updateTimestamp: true // Whether the POT-Creation-Date should be updated without other changes.
				}
			}
		},
		//https://www.npmjs.com/package/grunt-checktextdomain
		checktextdomain: {
			options: {
				text_domain: 'wp-mobile', //Specify allowed domain(s)
				keywords: [//List keyword specifications
					'__:1,2d',
					'_e:1,2d',
					'_x:1,2c,3d',
					'esc_html__:1,2d',
					'esc_html_e:1,2d',
					'esc_html_x:1,2c,3d',
					'esc_attr__:1,2d',
					'esc_attr_e:1,2d',
					'esc_attr_x:1,2c,3d',
					'_ex:1,2c,3d',
					'_n:1,2,4d',
					'_nx:1,2,4c,5d',
					'_n_noop:1,2,3d',
					'_nx_noop:1,2,3c,4d'
				]
			},
			target: {
				files: [{
						src: [
							'*.php',
							'**/*.php',
							'!node_modules/**',
							'!tests/**',
							'!vendor/**'
						], //all php
						expand: true
					}]
			}
		}
	});

	// register task
	grunt.registerTask('default', ['checktextdomain', 'makepot']);
};
