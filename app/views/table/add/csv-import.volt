{# flash messages #}
{{ flash.output() }}
<input type="hidden" name="tableId" value="{{ tableId }}" />

<div class="addTableImport__content__main__options">
  {# title #}
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
    </div>
  </div>
</div>
{# buttons #}
<div class="addTableImport__content__main__buttons">
  <a href="/table/add">Cancel</a>
  <button type="submit">Use this File</button>
</div>
