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
    <aside class="addTable__content__aside">
      <div class="addTable__content__aside__box">
        <a>
          <div {% if tab == 'choose-method' %}class="sign-box-selected"{% endif %}>Choose Method</div>
        </a>
        <a>
          <div {% if tab == 'description' %}class="sign-box-selected"{% endif %}>Description</div>
        </a>
        {% if !hideChooseTable %}
        <a>
          <div {% if tab == 'choose-table' %}class="sign-box-selected"{% endif %}>Choose table</div>
        </a>
        {% endif %}
        <a>
          <div {% if tab == 'confirm' %}class="sign-box-selected"{% endif %}>Confirm</div>
        </a>
      </div>
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
