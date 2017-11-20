// @flow
/* eslint-disable no-console */
const copy = require("recursive-copy");

const fs = require("fs");
const path = require("path");

// vars
const mainLayoutFile = "../app/views/layouts/main.volt";
const directory = "../public/js/react";

// Removing previous build
fs.readdir(directory, (err, files) => {
  if (err) throw err;

  files.forEach(file => {
    if (file !== ".gitkeep") {
      fs.unlink(path.join(directory, file), err2 => {
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

copy("./build/static/js", "../public/js/react", options)
  .then(results => {
    console.info(`Copied ${results.length} files`);

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
