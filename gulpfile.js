var theme = 'patch-lite',
	gulp 		= require('gulp'),
	sass 		= require('gulp-sass'),
	prefix 		= require('gulp-autoprefixer'),
	exec 		= require('gulp-exec'),
	replace 	= require('gulp-replace'),
	del         = require('del'),
	minify 		= require('gulp-minify-css'),
	livereload 	= require('gulp-livereload'),
	concat 		= require('gulp-concat'),
	notify 		= require('gulp-notify'),
	beautify 	= require('gulp-beautify'),
	csscomb 	= require('gulp-csscomb'),
	cmq 		= require('gulp-combine-media-queries'),
	prompt		= require('gulp-prompt'),
	fs          = require('fs');

jsFiles = [
	'./assets/js/vendor/*.js',
	'./assets/js/main/wrapper_start.js',
	'./assets/js/main/shared_vars.js',
	'./assets/js/modules/*.js',
	'./assets/js/main/main.js',
	'./assets/js/main/functions.js',
	'./assets/js/main/wrapper_end.js'
];



var theme_name = 'patch-lite',
	main_branch = 'self-hosted',
	options = {
		silent: true,
		continueOnError: true // default: false
	};

gulp.task('styles', function () {
	return gulp.src('assets/scss/**/*.scss')
			.pipe(sass({'sourcemap=auto': true, style: 'expanded'}))
			.pipe(prefix("last 1 version", "> 1%"))
			//.pipe(cmq())
			.pipe(csscomb())
      .pipe( replace(/^@charset \'UTF-8\';\n/gm, '' ) )
			.pipe(gulp.dest('./', {"mode": "0644"}));
});

gulp.task('styles-watch', function () {
	livereload.listen();
	return gulp.watch('assets/scss/**/*.scss', ['styles']);
});


// javascript stuff
gulp.task('scripts', function () {
	return gulp.src(jsFiles)
		.pipe(concat('main.js'))
		.pipe(beautify({indentSize: 2}))
		.pipe(gulp.dest('./assets/js/', {"mode": "0644"}));
});

gulp.task('scripts-watch', function () {
	livereload.listen();
	return gulp.watch('assets/js/**/*.js', ['scripts']);
});

gulp.task('watch', function () {
	gulp.watch('assets/scss/**/*.scss', ['styles']);
	gulp.watch('assets/js/**/*.js', ['scripts']);
});

// usually there is a default task for lazy people who just wanna type gulp
gulp.task('start', ['styles', 'scripts'], function () {
	// silence
});

gulp.task('server', ['styles', 'scripts'], function () {
	console.log('The styles and scripts have been compiled for production! Go and clear the caches!');
});


/**
 * Copy theme folder outside in a build folder, recreate styles before that
 */
gulp.task('copy-folder', function () {

	return gulp.src('./')
		.pipe(exec('rm -Rf ./../build; mkdir -p ./../build/' + theme + '; rsync -av --exclude="node_modules" ./* ./../build/' + theme + '/', options));
});

/**
 * Clean the folder of unneeded files and folders
 */
gulp.task('build', ['copy-folder'], function () {

	// files that should not be present in build
	files_to_remove = [
		'**/codekit-config.json',
		'node_modules',
		'config.rb',
		'gulpfile.js',
		'package.json',
		'pxg.json',
		'build',
		'css',
		'.idea',
		'**/.svn*',
		'**/*.css.map',
		'**/.sass*',
		'.sass*',
		'**/.git*',
		'*.sublime-project',
		'*.sublime-workspace',
		'.DS_Store',
		'**/.DS_Store',
		'__MACOSX',
		'**/__MACOSX',
		'tests',
		'circle.yml',
		'circle_scripts',
		'README.md',
		'.labels',
        '.circleci',
	];

	files_to_remove.forEach(function (e, k) {
		files_to_remove[k] = '../build/' + theme + '/' + e;
	});

	return del.sync(files_to_remove, {force: true});
});

/**
 * Create a zip archive out of the cleaned folder and delete the folder
 */
gulp.task('zip', ['build'], function(){

	var versionString = '';
	//get theme version from styles.css
	var contents = fs.readFileSync("./style.css", "utf8");

	// split it by lines
	var lines = contents.split(/[\r\n]/);

	function checkIfVersionLine(value, index, ar) {
		var myRegEx = /^[Vv]ersion:/;
		if ( myRegEx.test(value) ) {
			return true;
		}
		return false;
	}

	// apply the filter
	var versionLine = lines.filter(checkIfVersionLine);

	versionString = versionLine[0].replace(/^[Vv]ersion:/, '' ).trim();
	versionString = '-' + versionString.replace(/\./g,'-');

	return gulp.src('./')
		.pipe(exec('cd ./../; rm -rf' + theme[0].toUpperCase() + theme.slice(1) + '*.zip; cd ./build/; zip -r -X ./../' + theme[0] + theme.slice(1) + '.zip ./; cd ./../; rm -rf build'));

});

// usually there is a default task  for lazy people who just wanna type gulp
gulp.task('default', ['start'], function () {
	// silence
});


gulp.task('update-demo', function () {

	var run_exec = require('child_process').exec;

	gulp.src('./')
		.pipe(prompt.confirm( "This task will stash all your local changes without commiting them,\n Make sure you did all your commits and pushes to the main " + main_branch + " branch! \n Are you sure you want to continue?!? "))
		.pipe(prompt.prompt({
			type: 'list',
			name: 'demo_update',
			message: 'Which demo would you like to update?',
			choices: ['cancel', 'test.demos.pixelgrade.com/' + theme_name, 'demos.pixelgrade.com/' + theme_name]
		}, function(res){

			if ( res.demo_update === 'cancel' ) {
				console.log( 'No hard feelings!' );
				return false;
			}

			console.log('This task may ask for a github user / password or a ssh passphrase');

			if ( res.demo_update ===  'test.demos.pixelgrade.com/' + theme_name ) {
				run_exec('git fetch; git checkout test; git pull origin ' + main_branch + '; git push origin test; git checkout ' + main_branch + ';', function (err, stdout, stderr) {
					// console.log(stdout);
					// console.log(stderr);
				});
				console.log( " ==== The master branch is up-to-date now. But is the CircleCi job to update the remote test.demo.pixelgrade.com" );
				return true;
			}


			if ( res.demo_update === 'demos.pixelgrade.com/' + theme_name ) {
				run_exec('git fetch; git checkout master; git pull origin test; git push origin master; git checkout ' + main_branch + ';', function (err, stdout, stderr) {
					// console.log(stdout);
					// console.log(stderr);
				});

				console.log( " ==== The master branch is up-to-date now. But is the CircleCi job to update the remote demo.pixelgrade.com" );
				return true;
			}
		}));
});


/**
 * Short commands help
 */
gulp.task('help', function () {

	var $help = '\nCommands available : \n \n' +
		'=== General Commands === \n' +
		'start              (default)Compiles all styles and scripts and makes the theme ready to start \n' +
		'zip               	Generate the zip archive \n' +
		'build						  Generate the build directory with the cleaned theme \n' +
		'help               Print all commands \n' +
		'=== Style === \n' +
		'styles             Compiles styles in production mode\n' +
		'=== Scripts === \n' +
		'scripts            Concatenate all js scripts \n' +
		'=== Watchers === \n' +
		'watch              Watches all js and scss files \n' +
		'styles-watch       Watch only styles\n' +
		'scripts-watch      Watch scripts only \n';

	console.log($help);

});
