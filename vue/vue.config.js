module.exports = {
  transpileDependencies: true,
  outputDir: '../web/vue',
  filenameHashing: false,

  devServer: {
    devMiddleware: {
      writeToDisk: true
    },
    client: {
      progress: true,
    },
  }
}
