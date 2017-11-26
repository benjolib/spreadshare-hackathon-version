{% extends 'layouts/main.volt' %}

{% block content %}

{{ partial('table/detail/header') }}

<div class="tableAbout">
  <div class="tableAbout__info">
    <div class="tableAbout__info__content tableAbout__info__content--left">
      <div class="tableAbout__comments">
        {% for user in tableUsers%}
        <div class="tableAbout__comments__container">
          <span>{{ user['name'] }}</span>
          <img src="{{ user['image'] }}" />
          <span>{{ user['location'] }}</span>
          <span>{{ user['tagline'] }}</span>
          <button class="follow-user {% if user['following'] %}selected{% endif %}" data-id="{{ user['id'] }}" type="button">Follow</button>
        </div>
        {% endfor %}
      </div>
    </div>
  </div>
</div>

{% endblock %}