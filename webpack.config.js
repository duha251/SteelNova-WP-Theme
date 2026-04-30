const path = require('path');
const fs = require('fs');
const fg = require('fast-glob');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const RemoveEmptyScriptsPlugin = require('webpack-remove-empty-scripts');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

module.exports = (env, argv) => {
    const isProduction = argv.mode === 'production';
    const rootDir = __dirname;

    /*
    |--------------------------------------------------------------------------
    | THEME SCSS
    |--------------------------------------------------------------------------
    */
    const themeScssEntry = {
        theme: path.resolve(rootDir, 'assets/scss/style.scss'),
    };

    /*
    |--------------------------------------------------------------------------
    | ELEMENTOR SCSS
    |--------------------------------------------------------------------------
    */
    const elementorScssDir = path.resolve(rootDir, 'elementor/assets/scss');

    const elementorScssFiles = fg.sync('**/*.scss', {
        cwd: elementorScssDir,
        absolute: true,
        onlyFiles: true,
        ignore: ['**/_*.scss'],
    });

    const elementorEntries = elementorScssFiles.reduce((entries, filePath) => {
        const relativePath = path.relative(elementorScssDir, filePath);
        const normalizedPath = relativePath.replace(/\\/g, '/');
        const entryName = `elementor/${normalizedPath.replace(/\.scss$/i, '')}`;

        entries[entryName] = filePath;
        return entries;
    }, {});

    /*
    |--------------------------------------------------------------------------
    | WOO SCSS (NEW)
    |--------------------------------------------------------------------------
    */
    const wooScssDir = path.resolve(rootDir, 'woo/assets/scss');

    const wooScssFiles = fg.sync('**/*.scss', {
        cwd: wooScssDir,
        absolute: true,
        onlyFiles: true,
        ignore: ['**/_*.scss'],
    });

    const wooEntries = wooScssFiles.reduce((entries, filePath) => {
        const relativePath = path.relative(wooScssDir, filePath);
        const normalizedPath = relativePath.replace(/\\/g, '/');
        const entryName = `woo/${normalizedPath.replace(/\.scss$/i, '')}`;

        entries[entryName] = filePath;
        return entries;
    }, {});

    /*
    |--------------------------------------------------------------------------
    | PLUGINS
    |--------------------------------------------------------------------------
    */
    const plugins = [
        new RemoveEmptyScriptsPlugin(),

        new MiniCssExtractPlugin({
            filename: ({ chunk }) => {
                const name = chunk.name;

                // Theme
                if (name === 'theme') {
                    return 'assets/css/style.min.css';
                }

                // Elementor
                if (name.startsWith('elementor/')) {
                    const relativeCssPath = name.replace(/^elementor\//, '');
                    return `elementor/assets/css/${relativeCssPath}.min.css`;
                }

                // Woo (FIXED: dynamic output, not overwrite)
                if (name.startsWith('woo/')) {
                    const relativeCssPath = name.replace(/^woo\//, '');
                    return `woo/assets/css/${relativeCssPath}.min.css`;
                }

                return 'assets/css/[name].min.css';
            },
        }),
    ];

    /*
    |--------------------------------------------------------------------------
    | CLEAN (PRODUCTION ONLY)
    |--------------------------------------------------------------------------
    */
    if (isProduction) {
        plugins.push(
            new CleanWebpackPlugin({
                cleanOnceBeforeBuildPatterns: [
                    'assets/temp/**/*',
                    '**/*.css.map',
                ],
                verbose: false,
            }),
            {
                apply: (compiler) => {
                    compiler.hooks.afterEmit.tap('CleanupPlugin', () => {
                        const tempDir = path.resolve(rootDir, 'assets/temp');

                        if (fs.existsSync(tempDir)) {
                            fs.rmSync(tempDir, { recursive: true, force: true });
                        }
                    });
                },
            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CONFIG
    |--------------------------------------------------------------------------
    */
    return {
        entry: {
            ...themeScssEntry,
            ...elementorEntries,
            ...wooEntries, // 👈 ADD HERE
        },

        output: {
            path: rootDir,
            filename: 'assets/temp/[name].js',
            clean: false,
        },

        module: {
            rules: [
                {
                    test: /\.scss$/,
                    use: [
                        MiniCssExtractPlugin.loader,
                        {
                            loader: 'css-loader',
                            options: {
                                sourceMap: !isProduction,
                                importLoaders: 2,
                                url: false,
                            },
                        },
                        {
                            loader: 'postcss-loader',
                            options: {
                                sourceMap: !isProduction,
                            },
                        },
                        {
                            loader: 'sass-loader',
                            options: {
                                sourceMap: !isProduction,
                                sassOptions: {
                                    quietDeps: true,
                                },
                            },
                        },
                    ],
                },
            ],
        },

        plugins,

        optimization: {
            minimize: isProduction,
            minimizer: [
                '...',
                new CssMinimizerPlugin(),
            ],
        },

        mode: isProduction ? 'production' : 'development',
        devtool: isProduction ? false : 'source-map',
        watch: !isProduction,
        stats: 'errors-warnings',
    };
};