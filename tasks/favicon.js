const generateFavicons = require('simple-favicon-generator');
const pathFile = require('../package.json')

const faviconGen = async (target, name, dest) => {
  await generateFavicons(target, name, dest)
};

faviconGen( pathFile.config.source + pathFile.config.favicon.name + '/' + pathFile.config.favicon.source , pathFile.name , pathFile.config.dist + pathFile.config.favicon.name)

