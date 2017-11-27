{% extends 'layouts/main.volt' %}

{% block content %}

{{ partial('table/detail/header') }}

{{ flash.output() }}

<form method="POST">
  {% if page == "related" %}
    {{ partial('table/detail/settings/related') }}
  {% endif %}

  {% if page == "details" %}
    {{ partial('table/detail/settings/details') }}
  {% endif %}
</form>

{% endblock %}
