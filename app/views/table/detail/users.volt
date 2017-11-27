{% extends 'layouts/main.volt' %}

{% block content %}
{{ partial('table/detail/header') }}

<div class="container container--tableUsers">
  <div class="container__content">
    <div class="tableUsers">
      {% for user in tableUsers %}
        <div class="tableUsers__item">
          <div class="tableUsers__item__avatar">
            <img src="{{ user['image'] }}" />
          </div>
          <div class="tableUsers__item__info">
            <div class="tableUsers__item__info__title">
              <h5><a href="/user/{{ user['handle'] }}">{{ user['name'] }}</a></h5>
            </div>
            <div class="tableUsers__item__info__subtitle">
              {% if user['location'] and user['tagline']%}
                <p>{{ user['location'] }} ● {{ user['tagline'] }}</p>
              {% elseif user['location'] %}
                <p>{{ user['location'] }}</p>
              {% elseif user['tagline'] %}
                <p>{{ user['tagline'] }}</p>
              {% endif %}
            </div>
          </div>
          <div class="tableUsers__item__follow">
            <button class="follow-user {% if user['following'] %}following-user selected {% else %}not-following-user {% endif %}" data-id="{{ user['id'] }}" type="button"></button>
          </div>
        </div>
      {% endfor %}
    </div>
  </div>
  <aside class="aside">
    <a href="#">
      <div class="aside__item item-selected">
        <p>All</p>
      </div>
    </a>
    <a href="#">
      <div class="aside__item">
        <p>Subscribers</p>
      </div>
    </a>
    <a href="#">
      <div class="aside__item">
        <p>Upvoted by</p>
      </div>
    </a>
    <a href="#">
      <div class="aside__item">
        <p>Contributors</p>
      </div>
    </a>
    <a href="#">
      <div class="aside__item">
        <p>Admins</p>
      </div>
    </a>
  </aside>
</div>
{% endblock %}
