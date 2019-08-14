import gulp from 'gulp'
import yargs from 'yargs'
import sass from 'gulp-sass'
import cleanCSS from 'gulp-clean-css'
import gulpif from 'gulp-if'
import sourcemaps from 'gulp-sourcemaps'
import imagemin from 'gulp-imagemin'
import del from 'del'
import webpack from 'webpack-stream'
import uglify from 'gulp-uglify'
import named from 'vinyl-named'
import browserSync from 'browser-sync'
import postcss from 'gulp-postcss'
import cssDeclarationSorter from 'css-declaration-sorter'
import cssNext from 'postcss-preset-env'
import zip from 'gulp-zip'
import replace from 'gulp-replace'
import info from './package.json'

// Instantiate browserSync
const server = browserSync.create()

// Set production variable
const PRODUCTION = yargs.argv.prod

// Common Paths
const paths = {
	styles: {
		src: ['src/assets/scss/bundle.scss', 'src/assets/scss/admin.scss'],
		dest: 'dist/assets/css'
	},
	images: {
		src: ['src/assets/images/**/*.{jpg,jpeg,png,svg,gif}'],
		dest: 'dist/assets/images'
	},
	scripts: {
		src: 'src/assets/js/*.js',
		dest: 'dist/assets/js'
	},
	other: {
		src: ['src/assets/**/*', '!src/assets/{images,js,scss}', '!src/assets/{images,js,scss}/**/*'],
		dest: 'dist/assets'
	},
	package: {
		src: ['**/*', '!.vscode', '!node_modules', '!node_modules{,/**}', '!packaged{,/**}', '!src{,/**}', '!.bablerc', '!.gitignore', '!gulpfile.babel.js', '!package.json', '!package-lock.json'],
		dest: 'dist/packaged'
	}
}

// Serve BrowserSync refresh
export const serve = (done) => {
	server.init({
		proxy: 'noveltypress.local'
	})
	done()
}

export const reload = (done) => {
	server.reload()
	done()
}

// Delete the dist folder
export const clean = () => del(['dist']);

// Preprocess Sass, Minify and move CSS to the dist folder
export const styles = () => {
	return gulp.src(paths.styles.src)
		.pipe(gulpif(PRODUCTION, sourcemaps.init()))
		.pipe(sass().on('error', sass.logError))
		.pipe(postcss([cssNext, cssDeclarationSorter({ order: 'smacss' })]))		
		.pipe(gulpif(PRODUCTION, cleanCSS({compatibility: 'ie8'})))
		.pipe(gulpif(PRODUCTION, sourcemaps.write()))
		.pipe(gulp.dest(paths.styles.dest))
		.pipe(server.stream())
}

// Minify and copy images to the dist folder
export const images = () => {
	return gulp.src(paths.images.src)
		.pipe(gulpif(PRODUCTION, imagemin()))
		.pipe(gulp.dest(paths.images.dest))
}

// Watch for local edits
export const watch = () => {
	gulp.watch('src/assets/scss/**/*.scss', gulp.series(styles, reload))
	gulp.watch('src/assets/js/**/*.js', gulp.series(scripts, reload))
	gulp.watch('**/*.php', reload)
	gulp.watch('**/*.twig', reload)
	gulp.watch(paths.images.src, gulp.series(images, reload))
	gulp.watch(paths.other.src, gulp.series(copy, reload))
}

// Copy all other assets to the dist folder
export const copy = () => {
	return gulp.src(paths.other.src)
		.pipe(gulp.dest(paths.other.dest))
}

// Copy all other assets to the dist folder
export const scripts = () => {
	return gulp.src(paths.scripts.src)
		.pipe(named())
		.pipe(webpack({
			module: {
				rules: [
					{
						test: /\.js$/,
						use: {
							loader: 'babel-loader',
							options: {
								presets: ['@babel/preset-env'] //or ['babel-preset-env']
							}
						}
					},
				]
			},
			output: {
				filename: '[name].js'
			},
			externals: {
				jquery: 'jQuery',
			},
			devtool: !PRODUCTION ? 'inline-source-map' : false,
			mode: PRODUCTION ? 'production' : 'development' //add this
		}))
		.pipe(gulpif(PRODUCTION, uglify())) //you can skip this now since mode will already minify
		.pipe(gulp.dest(paths.scripts.dest));
}

export const compress = () => {
	return gulp.src(paths.package.src)
		.pipe(replace('_themename', info.name))
		.pipe(zip(`${info.name}.zip`))
		.pipe(gulp.dest(paths.package.dest))
}

// Clean the dist folder, ten build all tasks
export const dev = gulp.series(clean, gulp.parallel(styles, scripts, images, copy), serve, watch)
export const build = gulp.series(clean, gulp.parallel(styles, scripts, images, copy))
export const bundle = gulp.series(build, compress)

export default dev