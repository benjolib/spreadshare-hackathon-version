{% extends 'layouts/main.volt' %}

{% block content %}

{{ partial('table/detail/header') }}

<div>
    {{ table['title'] }}
    {{ table['topic1Id'] }}
    {{ table['topic1'] }}
    {{ table['topic2Id'] }}
    {{ table['topic2'] }}
    {{ table['typeId'] }}
    {{ reactArray['tags'] }}
    {{ reactArray['locations'] }}
</div>

{% endblock %}