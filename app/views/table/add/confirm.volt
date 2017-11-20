{% extends 'layouts/main.volt' %}

{% block content %}
<form id="addEmptyTableForm" method="post" action="{{ action }}">
  <div class="addTableEmpty">
    <div class="addTableEmpty__content">
      <div class="addTableEmpty__content__wrapper">
        <p class="addTableEmpty__content__title">Add a Table</p>
        <p class="addTableEmpty__content__subtitle">As an table owner you receive 2,5% of all tokens a table generates</p>
        <div class="addTableEmpty__content__main">
          {{ flash.output() }}

          <input type="hidden" name="tableId" value="{{ tableId }}" />

          <p>You are about to publish this table. Are you sure?</p>

          {# buttons #}
          <div class="addTableEmpty__content__main__buttons">
            <a href="/">Cancel</a>
            <button type="submit">Yes, publish</button>
          </div>
        </div>
      </div>
      <aside class="addTableEmpty__content__aside">
        <div class="addTableEmpty__content__aside__box">
          <a href="/table/add">
            <div>Choose table</div>
          </a>
          <a href="#">
            <div>Description</div>
          </a>
          <a href="#">
            <div class="sign-box-selected">Confirm</div>
          </a>
        </div>
      </aside>
    </div>
  </div>
</form>
{% endblock %}
