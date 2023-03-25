
const fs = require('fs');
const path = require('path');
const pathFile = require('../package.json')

const deleteFiles = async (dir) => {
    const files = await fs.promises.readdir(dir);
    
    for (const file of files) {
        const filePath = path.join(dir, file);

        if (file.indexOf('.min') > -1 ) {
            await fs.promises.unlink(filePath);
        }

        if (file.indexOf('.json') > -1 ) {
            await fs.promises.unlink(filePath);
        }
    }
};

deleteFiles( pathFile.config.dist );
deleteFiles( pathFile.config.dist + pathFile.config.js.path );
deleteFiles( pathFile.config.dist + pathFile.config.css.path );
console.log('\x1b[32m La tache clean est terminée \x1b[0m')



