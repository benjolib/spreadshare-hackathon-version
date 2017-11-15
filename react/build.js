const copy = require('recursive-copy');

const fs = require('fs');
const path = require('path');

// vars
const mainLayoutFile = '../app/views/layouts/main.volt';
const directory = '../public/js/react';

// Removing previous build
fs.readdir(directory, (err, files) => {
  if (err) throw err;

  for (const file of files) {
    if (file !== '.gitkeep') {
      fs.unlink(path.join(directory, file), err => {
        if (err) throw err;
      });
    }
  }
});


// Copying build into public js directory
const options = {
  overwrite: true,
  expand: true,
  dot: false,
};

copy('./build/static/js', '../public/js/react', options)
  .then(function (results) {
    console.info('Copied ' + results.length + ' files');

    // Replacing main bundle reference in backend's layout file
    results.forEach((result) => {
      const found = result.dest.match(/react\/(main\..*?\.js)$/i);
      if (found) {
        const buildFile = found[1];

        fs.readFile(mainLayoutFile, 'utf8', function (err,data) {
        if (err) {
          return console.log(err);
        }
        const result = data.replace(/main\..*?\.js/g, buildFile);

        fs.writeFile(mainLayoutFile, result, 'utf8', function (err) {
           if (err) return console.log(err);
        });
      });
      }

    })
  })
  .catch(function (error) {
    console.error('Copy failed: ' + error);
  });

