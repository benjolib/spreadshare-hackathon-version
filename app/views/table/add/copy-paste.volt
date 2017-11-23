{# flash messages #}
{{ flash.output() }}
<div class="addTableCopyPaste__content__main__options">
  {# title #}
  <div class="addTableCopyPaste__content__main__options__item">
    <div class="addTableCopyPaste__content__main__options__item__column">
      <div class="addTableCopyPaste__content__main__options__item__row addTableCopyPaste__content__main__options__item__row--divided">
        <p>Paste table content here</p>
        <p>Separate by <select name="separator">
          <option value="tab">tab</option>
          <option value="comma">comma</option>
          <option value="semicolon">semicolon</option>
        </select><i></i></p>
      </div>
      <textarea rows="20" name="data" autofocus></textarea>
      <label>
        <input type="checkbox" name="hasHeaders" value="1" /> Headers included?
      </label>
    </div>
  </div>
</div>
{# buttons #}
<div class="addTableCopyPaste__content__main__buttons">
  <a href="/table/add">Cancel</a>
  <button type="submit">Import pasted Data</button>
</div>
</div>
