{% extends 'layouts/main.volt' %}

{% block content %}
<div class="addTable">
  <div class="addTable__content">
    <div class="addTable__content__wrapper">
      <p class="addTable__content__title">Add a Table</p>
      <p class="addTable__content__subtitle">As an table owner you receive 2,5% of all tokens a table generates</p>
      <div class="addTable__content__main">
        <div class="addTable__content__main__options">
          {# from scratch #}
          <div class="addTable__content__main__options__item">
            <div class="addTable__content__main__options__item__column">
              <p>From scratch</p>
              <p>Start with an empty table</p>
            </div>
            <a class="button" href="/table/add/empty">Select</a>
          </div>
          {# import file #}
          <div class="addTable__content__main__options__item">
            <div class="addTable__content__main__options__item__column">
              <p>Import file</p>
              <p>Import a table from a CSV file</p>
            </div>
            <a class="button" href="/table/add/csv-import">Select</a>
          </div>
          {# copy & paste #}
          <div class="addTable__content__main__options__item">
            <div class="addTable__content__main__options__item__column">
              <p>Copy & Paste</p>
              <p>Copy and paste content from any table-format file e.g. Excel, Google Sheets a.o.</p>
            </div>
            <a class="button" href="/table/add/copy-paste">Select</a>
          </div>
        </div>
      </div>
    </div>
    <aside class="addTable__content__aside">
      <div class="addTable__content__aside__box">
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
{% endblock %}
