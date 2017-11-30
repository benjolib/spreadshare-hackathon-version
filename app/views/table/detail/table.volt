{% extends 'layouts/main.volt' %}

{% block content %}
<div class="table">
  {{ partial('table/detail/header') }}

  <div>
    <div id="Table" data-id="{{ table['id'] }}" data-permission="{% if auth.getUserId() == table['ownerUserId'] %}2{% elseif auth.loggedIn() %}1{% else %}0{% endif %}" class="react-component">
        <br/>
        <br/>
        <div class="loading"></div>
        <br/>
        <br/>
    </div>
  </div>
</div>
{% endblock %}


{% block scripts %}
{{ partial('table/detail/flag') }}
{% endblock %}
