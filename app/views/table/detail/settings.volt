{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - Settings for table {{ table['title'] }}{% endblock %}

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
    {# buttons #}
    <div class="addTableEmpty__content__main__buttons">
      <div class="" style="position: absolute;left: 20px;top: 20px;">
        <button name="action" value="delete" class="button red">Delete Table</button>
      </div>
      <a href="/table/add">Cancel</a>
      <button type="submit">Save Changes</button>
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
