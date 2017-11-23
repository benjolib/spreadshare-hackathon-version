{{ flash.output() }}

<input type="hidden" name="tableId" value="{{ tableId }}" />

<p>You are about to publish this table. Are you sure?</p>

{# buttons #}
<div class="addTableEmpty__content__main__buttons">
  <a href="/">Cancel</a>
  <button type="submit">Yes, publish</button>
</div>
