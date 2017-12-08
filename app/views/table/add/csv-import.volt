{# flash messages #}
{{ flash.output() }}
<input type="hidden" name="tableId" value="{{ tableId }}" />

<div class="addTableImport__content__main__options">
  {# title #}
  <div class="addTableImport__content__main__options__item">
    <div class="addTableImport__content__main__options__item__tip">
        <p><img src="/assets/icons/tip.svg" />Importing&nbsp;<span>Hyperlinks</span>&nbsp;&&nbsp;<span>Special characters</span>&nbsp;is currently not supported by CSV import</p>
    </div>
  </div>
  <div class="addTableImport__content__main__options__item">
    <div class="addTableImport__content__main__options__item__column">
      <p>Upload file</p>
      <div class="addTableImport__content__main__options__item__row">
        <input type="text" disabled />
        <input id="importCSVInput" name="file-upload" type="file" accept=".csv" />
        <span id="importCSVText"></span>
        <button type="button" id="importCSVButton" class="addTableImport__content__main__options__item__browse">Browse</button>
      </div>
      <span>Acceptable file types: <i>CSV</i>, and other <i>tab-delimited text files</i></span>
      <div class="addTableImport__content__main__options__item__switch">
        <div class="layout__content__main__personal__switch">
          <div class="layout__content__main__personal__column">
            <div class="layout__content__main__personal__switch__text">
              <p>CSV file has header row?</p>
            </div>
            <div class="switch">
              <input type="hidden" name="csvFileHasHeaders" value="0">
              <button type="button" class="switch switch--left YSwitch" data-name="csvFileHasHeaders" value="1">
                Y
              </button>
              <button type="button" class="switch switch--right NSwitch active animated bounceIn" data-name="csvFileHasHeaders" value="0">
                N
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{# buttons #}
<div class="addTableImport__content__main__buttons">
  <a href="/table/add">Cancel</a>
  <button type="submit">Use this File</button>
</div>

{% block scripts %}
<script type="text/javascript">
  window.addEventListener('load', function () {
  window.initOnOffSwitches();
  });
</script>
{% endblock %}
