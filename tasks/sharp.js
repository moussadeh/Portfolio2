const fs = require('fs')
const sharp = require('sharp')
const pathFile = require('../package.json')
const source = pathFile.config.source + pathFile.config.img.name + '/'
const dest = pathFile.config.dist + pathFile.config.img.name + '/'
const files = fs.readdirSync(source)

const generateImages = async () => {
    for (const file of files) {

        const folder = file.replace(/\.[^/.]+$/, "")

        if (!fs.existsSync('./' + dest + folder)){
            fs.mkdirSync('./' + dest + folder);
            console.log('Folder Created Successfully.');
        }

        sharp( source + '/' + file)
            .metadata()
            .then((metadata) => {
                const width = metadata.width;

                for (const size of pathFile.config.img.sizes) {
                    if (width >= size.size) {
                        for (const format of pathFile.config.img.formats) { 
                            sharp(source + '/' + file)
                                .resize({
                                    width: size.size
                                })
                                .toFile('./' + dest + folder  + '/' + file.split('.').slice(0, -1).join('.') + '-' + size.name + '.' + format)
                                .then(() => {})
                                    .catch((error) => {
                                        console.log("Une erreur s'est produite :", error);
                                });
                        }
                    } 
                } 
        })
    }
    console.log("Les images sont enregistrées avec succès !");
}

generateImages();

