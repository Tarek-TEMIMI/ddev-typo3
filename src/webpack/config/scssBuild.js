const
	fs = require('fs'),
	sass = require('sass'),
	mkdirp = require('mkdirp'),
	path = require('path'),
	getDirName = require('path').dirname,
	postcss = require('postcss'),
	parseArgs = require('minimist'),
	chalk = require('chalk'),
	bold = chalk.bold,
	error = chalk.bold.red,
	warn = chalk.keyword('orange'),
	success = chalk.keyword('green');

/**
 * SCSS build
 */
class ScssBuild {

	constructor(_config = {}) {
		this.config = _config;
	}

	/**
	 * build
	 * process all SCSS file
	 * @returns {void}
	 */
	build() {
		console.log(bold('\nProcess SCSS file(s)'));
		console.log('------------');

		for (const [dest, src] of Object.entries(this.config.scss.files)) {
			this.processScssFile({
				src : path.resolve(__dirname, src),
				dest: path.resolve(__dirname, dest)
			});
		}
	}

	/**
	 * process scss file
	 * @param {Object} options to process scss file
	 * @returns {void}
	 */
	processScssFile(options = {}) {

		const targetFileName = path.basename(options.dest);

		// render the result
		const result = sass.renderSync({
			file       : options.src,
			outputStyle: options.style,
			style      : 'compressed'
		});

		const postcssPlugins = [
			require('autoprefixer')()
		];

		// group media queries
		if (this.config.scss.groupMediaQueries) {
			postcssPlugins.push(require('css-mqpacker')());
		}

		postcssPlugins.push(
			require('cssnano')({ preset: 'default' }),
			require('cssstats')({}, { importantDeclarations: true })
		);

		// post process the css files
		// see plugins and options: https://github.com/postcss/postcss
		postcss(postcssPlugins).process(
			result.css.toString(),
			{ from: undefined }
		).then(result => {

			// write the result to file
			mkdirp(getDirName(options.dest), (err) => {
				if (err) {
					throw err;
				}
				fs.writeFile(options.dest, result.css, (error) => {
					if (error) {
						console.log(error(`Can't write file: ${options.dest} error: ${error}`));
					}

					if (result.messages) {
						console.log(bold(`\n${targetFileName} stats:`));
						this.logCssFileStats(result.messages);
					}

					console.log(success(`${path.basename(options.dest)} build successful\n`));
				});
			});
		});
	}

	/**
	 * make sure CSS public directory exists and is clean
	 * @returns {void}
	 */
	clear() {
		const cssPath = path.resolve(__dirname, this.config.scss.path.target);
		if (!fs.existsSync(cssPath)) {
			fs.mkdirSync(cssPath);
		}

		fs.readdirSync(cssPath).forEach((file) => {

			// don't remove critical css files
			if (!file.match(/critical-/g)) {
				fs.unlinkSync(path.resolve(__dirname, `${this.config.scss.path.target}/${file}`), (err) => {
					if (err) {
						console.log(error(err));
						throw err;
					}
				});
			}
		});
	}

	/**
	 * log css file stats
	 * @param {Array} messages css stats
	 * @returns {void}
	 */
	logCssFileStats(messages = []) {
		messages.forEach((message) => {
			console.log(`  - file size: ${message.stats.humanizedSize}`);
			console.log(`  - media queries: ${message.stats.mediaQueries.total}`);
			console.log(`  - font sizes: ${message.stats.declarations.getAllFontSizes()}`);
			console.log(`  - !importans: ${Object.entries(message.stats.declarations.important).length}`);
		});
	}
}

module.exports = (function() {
	const argv = parseArgs(process.argv.slice(2));
	const config = require(`./${argv.env}`);

	const scssBuild = new ScssBuild(config);
	scssBuild.clear();
	scssBuild.build();
})();
