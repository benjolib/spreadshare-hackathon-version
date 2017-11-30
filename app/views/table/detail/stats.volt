{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - Stats for table {{ table['title'] }}{% endblock %}

{% block content %}
{{ partial('table/detail/header') }}

Stats

{% endblock %}

{% block scripts %}
{{ partial('table/detail/flag') }}
{% endblock %}
