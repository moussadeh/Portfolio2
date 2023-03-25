
const fs = require('fs');
const path = require('path');
const pathFile = require('../package.json')

const deleteFiles = async (dir) => {
    const files = await fs.promises.readdir(dir);
    
    for (const file of files) {
        const filePath = path.join(dir, file);
        const fileStat = await fs.promises.lstat(filePath);

        if (filePath !== "public/bundles" ) {
            
            if (fileStat.isDirectory()) {
                await deleteFiles(filePath);
            } else {
                if (file !== '.gitkeep') {
                    if (!file.includes('index.html')) { 
                        await fs.promises.unlink(filePath);
                    }
                }
            }
        }
    }
};

// deleteFiles('public');
deleteFiles( pathFile.config.dist);


