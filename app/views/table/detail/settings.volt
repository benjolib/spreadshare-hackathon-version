{% extends 'layouts/main.volt' %}

{% block content %}

{{ partial('table/detail/header') }}

{{ flash.output() }}

<div class="tableSettings">
  <div class="addTable__content__main">
    <div class="addTable__content__main__options">
      <form method="POST">
        {% if page == "related" %}
          {{ partial('table/detail/settings/related') }}
        {% endif %}

        {% if page == "details" %}
          {{ partial('table/detail/settings/details') }}
        {% endif %}
      </form>
    </div>
  </div>

  <aside class="addTable__content__aside">
    <div class="addTable__content__aside__box">
      <a href="#">
        <div class="sign-box-selected">Table Details</div>
      </a>
      <a href="#">
        <div>Related Table</div>
      </a>
    </div>
  </aside>
</div>
{% endblock %}
