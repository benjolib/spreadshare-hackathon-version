{% extends 'layouts/main.volt' %}

{% block content %}

{{ partial('table/detail/header') }}

<div>
  <div id="Table" data-tableId="{{ table['id'] }}" class="react-component">Table</div>
</div>
{% endblock %}