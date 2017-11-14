const copy = require('recursive-copy');

const options = {
  overwrite: true,
  expand: true,
  dot: false,
};

copy('./build/static/js', '../public/js/react', options)
  .then(function (results) {
    console.info('Copied ' + results.length + ' files');
  })
  .catch(function (error) {
    console.error('Copy failed: ' + error);
  });

