{# fixed rows and columns #}
<div class="addTableEmpty__content__main__options__item">
    <div class="addTableEmpty__content__main__options__item__column" style="display:inline;">
        <p>Fixed Rows</p>
        Fix the first
        <input type="text" style="width:30px;" placeholder="1" name="fixedRowsTop" value="{{ tableProps.fixedRowsTop }}" />
        Rows from top.
    </div>
</div>

<div class="addTableEmpty__content__main__options__item">
    <div class="addTableEmpty__content__main__options__item__column" style="display:inline;">
        <p>Fixed columns</p>
        Fix the first
        <input type="text" style="width:30px;" placeholder="1" name="fixedColumnsLeft" value="{{ tableProps.fixedColumnsLeft }}" />
        Columns.
    </div>
</div>

<div class="addTableEmpty__content__main__options__item">
    <div class="addTableEmpty__content__main__options__item__column" style="display:inline;">

        <div class="layout__content__main__personal__switch">
            <div class="layout__content__main__personal__column">
                <div class="layout__content__main__personal__switch__text">
                    <p>Table is published</p>
                    <span>You can publish or unpublish your table at any time.</span>
                    <p></p>
                </div>
                <div class="switch">
                    <input type="hidden" name="flags" value="{{ table['flags'] }}" />
                    <button type="button" class="switch switch--left YSwitch {% if table['flags'] == 2 %}active{% endif %}"
                            data-name="flags" value="1">
                        Y
                    </button>
                    <button type="button" class="switch switch--right NSwitch {% if table['flags'] == 1 %}active{% endif %}"
                            data-name="flags" value="0">
                        N
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  window.addEventListener('load', function () {
    window.initOnOffSwitches();
  });
</script>