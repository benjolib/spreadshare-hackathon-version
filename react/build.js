// @flow
/* eslint-disable no-console */
const copy = require("recursive-copy");

const fs = require("fs");
const path = require("path");

// vars
const mainLayoutFile = "../app/views/layouts/main.volt";
const jsDirectory = "../public/js/react";
const cssDirectory = "../public/css";

// Removing previous build
fs.readdir(jsDirectory, (err, files) => {
  if (err) throw err;

  files.forEach(file => {
    const found = file.match(/(main\..*?\.js)$/i);
    if (found) {
      fs.unlink(path.join(jsDirectory, file), err2 => {
        if (err2) throw err2;
      });
    }
  });
});

// Removing css files from previous build
fs.readdir(cssDirectory, (err, files) => {
  if (err) throw err;

  files.forEach(file => {
    const found = file.match(/(main\..*?\.css)$/i);
    if (found) {
      fs.unlink(path.join(cssDirectory, file), err2 => {
        if (err2) throw err2;
      });
    }
  });
});

// Copying build into public js directory
const options = {
  overwrite: true,
  expand: true,
  dot: false
};

copy("./build/static/css", cssDirectory, options)
  .then(results => {
    console.info(`Copied ${results.length} css files`);

    // Replacing main bundle reference in backend's layout file
    results.forEach(result => {
      const found = result.dest.match(/css\/(main\..*?\.css)$/i);
      if (found) {
        const buildFile = found[1];

        fs.readFile(mainLayoutFile, "utf8", (err, data) => {
          if (err) {
            return console.log(err);
          }
          const resultAfter = data.replace(/main\..*?\.css/g, buildFile);

          fs.writeFile(mainLayoutFile, resultAfter, "utf8", err2 => {
            if (err2) return console.log(err2);
          });
        });
      }
    });
  })
  .catch(error => {
    console.error(`Copy failed: ${error}`);
  });

copy("./build/static/js", jsDirectory, options)
  .then(results => {
    console.info(`Copied ${results.length} js files`);

    // Replacing main bundle reference in backend's layout file
    results.forEach(result => {
      const found = result.dest.match(/react\/(main\..*?\.js)$/i);
      if (found) {
        const buildFile = found[1];

        fs.readFile(mainLayoutFile, "utf8", (err, data) => {
          if (err) {
            return console.log(err);
          }
          const resultAfter = data.replace(/main\..*?\.js/g, buildFile);

          fs.writeFile(mainLayoutFile, resultAfter, "utf8", err2 => {
            if (err2) return console.log(err2);
          });
        });
      }
    });
  })
  .catch(error => {
    console.error(`Copy failed: ${error}`);
  });
