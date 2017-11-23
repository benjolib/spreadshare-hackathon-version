$('#importCSVButton').on('click', function (ev) {
  ev.preventDefault();
  var $input = $('#importCSVInput');
  $input.click();
  $input.on('change', function () {
    $('#importCSVText').text(this.files[0].name);
  });
});