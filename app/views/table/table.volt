{% extends 'layouts/main.volt' %}

{% block content %}
<h1>{{ table['title'] }}</h1>
<h3>{{ table['tagline'] }}</h3>

<div>
  <div id="Table" class="react-component">Table</div>
</div>
{% endblock %}