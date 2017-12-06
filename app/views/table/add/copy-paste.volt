{# flash messages #}
{{ flash.output() }}
<div class="addTableCopyPaste__content__main__options">
    {# title #}
    <div class="addTableCopyPaste__content__main__options__item">
        <div class="addTableCopyPaste__content__main__options__item__column">
            <div class="addTableCopyPaste__content__main__options__item__row addTableCopyPaste__content__main__options__item__row--divided">
                <p>Paste table content here</p>
                <p>Separate by
                    <select name="separator">
                        <option value="tab">tab</option>
                        <option value="comma">comma</option>
                        <option value="semicolon">semicolon</option>
                    </select>
                </p>
            </div>
            <textarea rows="20" name="data" autofocus></textarea>

            <br />
            <br />
            <div class="layout__content__main__personal__switch">
                <div class="layout__content__main__personal__column">
                    <div class="layout__content__main__personal__switch__text">
                        <p>Headers included?</p>
                    </div>
                    <div class="switch">
                        <input type="hidden" name="hasHeaders" value="0" />
                        <button type="button" class="switch switch--left YSwitch"
                                data-name="hasHeaders" value="1">
                            Y
                        </button>
                        <button type="button" class="switch switch--right NSwitch active"
                                data-name="hasHeaders" value="0">
                            N
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{# buttons #}
<div class="addTableCopyPaste__content__main__buttons">
    <a href="/table/add">Cancel</a>
    <button type="submit">Import pasted Data</button>
</div>

<script type="text/javascript">
  window.addEventListener('load', function () {
    window.initOnOffSwitches();
  });
</script>