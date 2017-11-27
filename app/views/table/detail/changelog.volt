{% extends 'layouts/main.volt' %}

{% block content %}

{{ partial('table/detail/header') }}

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

{% endblock %}