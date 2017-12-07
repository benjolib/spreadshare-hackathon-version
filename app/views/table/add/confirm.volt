<div class="preview">
    {{ flash.output() }}

    <input type="hidden" name="tableId" value="{% if tableId is defined %}{{ tableId }}{% endif %}" />
    <input type="hidden" name="redirectToTable" value="{% if tableId is defined %}{{ redirectToTable }}{% endif %}" />

    <h4>Last step</h4>
    <p>This is how your table will look like. Go back if you want to change something.</p>

    <ul>
        <li>After publishing you can still <strong>fix columns, change content, or table details</strong> and also delete the table if you want to.</li>
        <li>Want to change the table structure? You have to <strong>change the file</strong> you uploaded (or) from where you are copying the data.</li>
    </ul>

    <br />
    <div class="addTableEmpty__content__main__options__item">
        <div class="addTableEmpty__content__main__options__item__column" style="display:inline;">
            <p>Fix rows</p>
            Fix the first
            <input type="text" style="width:30px;" placeholder="1" name="fixedRowsTop" value="{{ tableProps.fixedRowsTop }}" />
            Rows from top.
        </div>
    </div>

    <div class="addTableEmpty__content__main__options__item">
        <div class="addTableEmpty__content__main__options__item__column" style="display:inline;">
            <p>Fix columns</p>
            Fix the first
            <input type="text" style="width:30px;" placeholder="1" name="fixedColumnsLeft" value="{{ tableProps.fixedColumnsLeft }}" />
            Columns.
        </div>
    </div>


    {# buttons #}
    <div class="addTableEmpty__content__main__buttons">
      <a href="javascript:history.go(-1);">Go back</a>
      <button type="submit">Yes, publish now</button>
    </div>
</div>