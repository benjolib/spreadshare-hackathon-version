{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - {{ table['title'] }} - {{ table['topic1'] }}{% endblock %}

{% block content %}
<div class="table">
  {{ partial('table/detail/header') }}

  <div id="tableContainer">
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


<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Table",
  "about": "{{ table['title'] }}"
  "description": "{{ table['tagline'] }}",
  "keywords": "{{ table['tags'] }}",
  "dateCreated": " {{ table['createdAt'] }}",
  "author": {
    "@type": "Person",
    "image": "{{ table['creatorImage'] }}",
    "name": "{{ table['creator'] }}",
    "sameAs": "/user/{{ table['creatorHandle'] }}"
  }
}
</script>


{% endblock %}
