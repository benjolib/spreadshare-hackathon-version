{% extends 'layouts/main.volt' %}

{% block content %}

{{ partial('table/detail/header') }}

{{ flash.output() }}

<div class="container container--tableDetails">
  <div class="container__content">
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

  <aside class="aside aside--tableDetails">
    <a href="#">
      <div class="aside__item item-selected"><p>Table Details</p></div>
    </a>
    <a href="#">
      <div class="aside__item"><p>Related Table</p></div>
    </a>
  </aside>
</div>
{% endblock %}

{% block scripts %}
{{ partial('table/detail/flag') }}
{% endblock %}
