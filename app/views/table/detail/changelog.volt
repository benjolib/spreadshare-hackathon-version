{% extends 'layouts/main.volt' %}

{% block content %}

{{ partial('table/detail/header') }}

{% if requests %}
<div>
    {% for request in requests %}
    <div>
        {{ request['from'] }}
        {{ request['to'] }}
        {{ request['user'] }}
        {{ request['userHandle'] }}
        {{ formatTimestamp(request['createdAt']) }}
        {% if request['status'] == 0%}
        <input type="text" name="comment" class="changelog-comment-{{ request['id'] }}" />
        <button class="review-change-request" data-id="{{ request['id'] }}" data-type="confirm">Confirm</button>
        <button class="review-change-request" data-id="{{ request['id'] }}" data-type="reject">Reject</button>
        {% elseif request['status'] == 2 %}
        <div>Change has been rejected.</div>
        <div>{{ request['comment'] }}</div>
        {% else %}
        <div>Change has been approved.</div>
        <div>{{ request['comment'] }}</div>
        {% endif %}
    </div>
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
