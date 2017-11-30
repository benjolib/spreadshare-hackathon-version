{% extends 'layouts/main.volt' %}

{% block content %}
{{ partial('table/detail/header') }}

Stats

{% endblock %}

{% block scripts %}
{{ partial('table/detail/flag') }}
{% endblock %}
