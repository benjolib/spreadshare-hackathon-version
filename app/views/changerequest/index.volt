{% extends 'layouts/main.volt' %}

{% block content %}
  {% for change in changes %}
    {{ dump(change) }}
    <p><strong>Change request id: </strong>{{ change['id'] }}</p>
    <p><strong>Changed from: </strong>{{ change['from'] }}</p>
    <p><strong>To: </strong>{{ change['to'] }}</p>
    <p><strong>Comments: </strong>{{ change['comment'] }}</p>
    <p><strong>Status: </strong>{{ change['status'] }}</p>
    
  {% endfor %}
{% endblock %}
