{% extends 'layouts/main.volt' %}

{% block content %}
<div class="addTable">
  <div class="addTable__content">
    <div class="addTable__content__wrapper">
      <p class="addTable__content__title">Add a Table</p>
      <p class="addTable__content__subtitle">As a table owner you receive 2.5% of all tokens a table generates</p>
      <div class="addTable__content__main">
        <div class="addTable__content__main__options" style="width: 100%;">
          <form id="addTableForm" method="post" action="{{ action }}" enctype="multipart/form-data">
            {{ flash.output() }}

            <input type="hidden" name="tableId" value="{{ tableId }}" />
            {% include content %}
          </form>
        </div>
      </div>
    </div>
    <aside class="aside aside--addTable">
      <a>
        <div class="aside__item {% if tab == 'choose-method' %}item-selected{% endif %}"><p>Choose Method</p></div>
      </a>
      <a>
        <div class="aside__item {% if tab == 'description' %}item-selected{% endif %}"><p>Description</p></div>
      </a>
      {% if !hideChooseTable %}
      <a>
        <div class="aside__item {% if tab == 'choose-table' %}item-selected{% endif %}"><p>Choose table</p></div>
      </a>
      {% endif %}
      <a>
        <div class="aside__item {% if tab == 'choose-confirm' %}item-selected{% endif %}"><p>Confirm</p></div>
      </a>
    </aside>
  </div>
</div>
{% endblock %}

{% block scripts %}
  {% if content_js %}
    <script>
          {% include content_js %}
    </script>
  {% endif %}
{% endblock %}
