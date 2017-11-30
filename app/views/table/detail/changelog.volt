{% extends 'layouts/main.volt' %}

{% block content %}

{{ partial('table/detail/header') }}

{% if requests %}
<div>
  {% for request in requests %}
  {{ request['from'] }}
  {{ request['to'] }}
  {{ request['comment'] }}
  {{ request['user'] }}
  {{ request['userHandle'] }}
  {{ formatTimestamp(request['createdAt']) }}
  {% endfor %}
</div>


{% else %}
<div class="center">
  <img src="/assets/images/desktop.png" alt="" />
  <p>&nbsp;</p>
  <p>There are no change requests, yet.</p>

  {% if auth().getUserId() != table['ownerUserId'] %}
    <p><a href="/table/{{ table['id'] }}">Go</a> and make your first contribution to this table.</p>
  {% endif %}
</div>
{% endif %}

{% endblock %}

{% block scripts %}
{{ partial('table/detail/flag') }}
{% endblock %}
