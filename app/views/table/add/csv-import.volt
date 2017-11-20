{% extends 'layouts/main.volt' %}

{% block header %}{% endblock %}

{% block content %}
<form id="addTableImportForm" method="post" enctype="multipart/form-data" action="/table/add/csv-import/{{ nextstep }}">
  <div class="addTableImport">
    <div class="addTableImport__content">
      <div class="addTableImport__content__wrapper">
        <p class="addTableImport__content__title">Add a Table</p>
        <p class="addTableImport__content__subtitle">As an table owner you receive 2,5% of all tokens a table generates</p>
        <div class="addTableImport__content__main">
          {# flash messages #}
          {{ flash.output() }}
          <div class="addTableImport__content__main__options">
            {# title #}
            <div class="addTableImport__content__main__options__item">
              <div class="addTableImport__content__main__options__item__column">
                <p>Upload file</p>
                <div class="addTableImport__content__main__options__item__row">
                  <input type="text" disabled />
                  <input id="importCSVInput" name="file-upload" type="file" accept=".csv" />
                  <span id="importCSVText"></span>
                  <button id="importCSVButton" class="addTableImport__content__main__options__item__browse">Browse</button>
                </div>
                <span>Acceptable file types: <i>CSV</i>, and other <i>tab-delimited text files</i></span>
              </div>
            </div>
          </div>
          {# buttons #}
          <div class="addTableImport__content__main__buttons">
            <a href="/table/add">Cancel</a>
            <button type="submit">Use this File</button>
          </div>
        </div>
      </div>
      <aside class="addTableImport__content__aside">
        <div class="addTableImport__content__aside__box">
          <a href="/table/add">
            <div class="sign-box-selected">Choose table</div>
          </a>
          <a href="#">
            <div>Description</div>
          </a>
          <a href="#">
            <div>Confirm</div>
          </a>
        </div>
      </aside>
    </div>
  </div>
</form>
{% endblock %}

{% block scripts %}
<script>
  $('#importCSVButton').on('click', function(ev) {
    ev.preventDefault()
    var $input = $('#importCSVInput')
    $input.click()
    $input.on('change', function() {
      $('#importCSVText').text(this.files[0].name)
    })
  })
</script>
{% endblock %}
