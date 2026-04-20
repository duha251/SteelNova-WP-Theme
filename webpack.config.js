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

    const themeScssEntry = {
        theme: path.resolve(rootDir, 'assets/scss/style.scss'),
    };

    const elementorScssDir = path.resolve(rootDir, 'elementor/assets/scss');

    const elementorScssFiles = fg.sync('**/*.scss', {
        cwd: elementorScssDir,
        absolute: true,
        onlyFiles: true,
        ignore: [
            '**/_*.scss',
        ],
    });

    const elementorEntries = elementorScssFiles.reduce((entries, filePath) => {
        const relativePath = path.relative(elementorScssDir, filePath);
        const normalizedPath = relativePath.replace(/\\/g, '/');
        const entryName = `elementor/${normalizedPath.replace(/\.scss$/i, '')}`;

        entries[entryName] = filePath;
        return entries;
    }, {});

    const plugins = [
        new RemoveEmptyScriptsPlugin(),

        new MiniCssExtractPlugin({
            filename: ({ chunk }) => {
                const name = chunk.name;

                if (name === 'theme') {
                    return  'assets/css/style.min.css';
                }

                if (name.startsWith('elementor/')) {
                    const relativeCssPath = name.replace(/^elementor\//, '');
                    return `elementor/assets/css/${relativeCssPath}.min.css`;
                }

                return 'assets/css/[name].min.css';
            },
        }),
    ];

    if (isProduction) {
        plugins.push(
            new CleanWebpackPlugin({
                cleanOnceBeforeBuildPatterns: [
                    'assets/temp/**/*',
                    '**/*.css.map',
                ],
                dangerouslyAllowCleanPatternsOutsideProject: false,
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

    return {
        entry: {
            ...themeScssEntry,
            ...elementorEntries,
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