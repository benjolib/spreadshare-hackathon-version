{% extends 'layouts/main.volt' %}

{% block content %}
<div class="table">
  {{ partial('table/detail/header') }}

  <div>
    <div id="Table" data-id="{{ table['id'] }}" data-editable="{% if auth.loggedIn() %}1{% else %}0{% endif %}" class="react-component">Table</div>
  </div>
</div>
{% endblock %}
