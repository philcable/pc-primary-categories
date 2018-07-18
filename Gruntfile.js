module.exports = function( grunt ) {
	grunt.initConfig( {
		pkg: grunt.file.readJSON( "package.json" ),

		phpcs: {
			plugin: {
				src: [ "./*.php", "./includes/*.php" ]
			},
			options: {
				bin: "vendor/bin/phpcs --extensions=php --ignore=\"*/vendor/*,*/node_modules/*\"",
				standard: "phpcs.ruleset.xml"
			}
		},

		jscs: {
			scripts: {
				src: "js/*.js",
				options: {
					preset: "jquery",
					maximumLineLength: 250
				}
			}
		},

		jshint: {
			people_scripts: {
				src: "js/*.js",
				options: {
					bitwise: true,
					curly: true,
					eqeqeq: true,
					forin: true,
					freeze: true,
					noarg: true,
					nonbsp: true,
					quotmark: "double",
					undef: true,
					unused: true,
					browser: true, // Define globals exposed by modern browsers.
					jquery: true,  // Define globals exposed by jQuery.
				}
			}
		},

	} );

	grunt.loadNpmTasks( "grunt-contrib-jshint" );
	grunt.loadNpmTasks( "grunt-jscs" );
	grunt.loadNpmTasks( "grunt-phpcs" );

	// Default task(s).
	grunt.registerTask( "default", [ "phpcs", "jscs", "jshint" ] );
};
