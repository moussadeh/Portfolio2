const { src, dest, task, watch, series, parallel } = require("gulp");
// const Vinyl         = require('vinyl');

// Browers related plugins
// const browserSync   = require( 'browser-sync' ).create();

// CSS related plugins
const dartSass      = require("sass");
const gulpSass      = require("gulp-sass");
const sass          = gulpSass(dartSass);
const postcss       = require ( 'gulp-postcss' ) ;

// JS related plugins
const babel = require("gulp-babel");
const uglify = require('gulp-uglify');
const plumber = require("gulp-plumber");

// Utility plugins
const notify        = require('gulp-notify');
const concat        = require('gulp-concat');
const rev          = require('gulp-rev');
const rename = require('gulp-rename');


const messageFile = 'Fichier: <%= file.relative %> compilés !';

const path = require('./package.json')

// Fonction du serveur local

// function browserSyncSart() {
// 	browserSync.init({
//         proxy: path.config.serveur.url + path.config.serveur.path,
//         // server: path.config.dist + 'html',
//         open: path.config.serveur.open,
//     });
// }

// function browserSyncReload(done) {
// 	browserSync.reload();
// 	done();
// }

// Fonction css en DEV

function cssTask(done) {
    src( path.config.source + path.config.css.path + path.config.css.all, { sourcemaps: true })
        .pipe(sass())
        .on( 'error', console.error.bind( console ) )
        .pipe(postcss([require('tailwindcss'), require('autoprefixer')]))
        .pipe(dest(path.config.dist + path.config.css.path, { sourcemaps: '.' }))
    done();
};

// Fonction JS en DEV

function jsTask(done) {

    src(path.config.source + path.config.js.path + path.config.js.main, { sourcemaps: true })
        .pipe(plumber())
        .pipe(concat(path.config.js.outMain))
        .pipe(
            babel({
                presets: [[
                        "@babel/env",{ modules: false,},
                    ],],
                })
            )
        .pipe(dest(path.config.dist + path.config.js.path, { sourcemaps: '.' }));

    src( path.config.source + path.config.js.path + path.config.js.all, { sourcemaps: true })
        .pipe(dest(path.config.dist + path.config.js.path, { sourcemaps: '.' }))

    done();
}

// Fonction PROD minification des fichiers + hachage + génération du manifest;json

function manifestTask(done) {
    src([ path.config.dist + path.config.css.path + '*.css',path.config.dist + path.config.js.path + '*.js'], { base: path.config.dist })
        .pipe( rename( {
            suffix: '.min'
        } ) )
        .pipe(rev())
        .pipe(dest(path.config.dist))
        .pipe(rev.manifest( path.config.dist + 'manifest.json', {
            base: path.config.dist,
            merge: true
        }))
        .pipe(dest(path.config.dist))   
    done();
};

function cssMin(done) {
    src( path.config.dist + path.config.css.path + '*.min.css')
        .pipe(postcss([require('cssnano')]))
        .pipe(dest(path.config.dist + path.config.css.path))
    done();
};

function jsMin(done) {
    src( path.config.dist + path.config.js.path + '*.min.js')
        .pipe(uglify())
        .pipe(dest(path.config.dist + path.config.js.path))
    done();
};

// Fonction de gestion des fichier en live
const watchRootHTML = path.config.dist + path.config.html.html
const watchRootTWIG = path.config.html.twig
const watchRoot = watchRootTWIG

function watchFilesServer() {
    watch(path.config.source + path.config.css.path + path.config.css.all, series(cssTask, browserSyncReload));
	watch([path.config.source + path.config.js.path + path.config.js.all, path.config.source + path.config.js.path + path.config.js.main], series(jsTask, browserSyncReload));
	watch(watchRoot, series(cssTask, jsTask, browserSyncReload));
	src(path.config.dist)
        .pipe( notify({ message: 'Watch sur fichiers lancé' }) );
}

function watchFiles() {
    watch(path.config.source + path.config.css.path + path.config.css.all, cssTask);
	watch([path.config.source + path.config.js.path + path.config.js.all, path.config.source + path.config.js.path + path.config.js.main], jsTask);
    watch(watchRoot, series(cssTask, jsTask));
	src(path.config.dist)
        .pipe( notify({ message: 'Watch sur fichiers lancé' }) );
}
// Taches de DEV 
// task("serveur", browserSyncSart);
task("css", cssTask);
task("js", jsTask);
task("build", series(cssTask, jsTask, parallel(watchFiles)));
// task("build-serveur", series(cssTask, jsTask));

// Taches de Prod
task("manifest", manifestTask);
task("cssMin", cssMin);
task("jsMin", jsMin);