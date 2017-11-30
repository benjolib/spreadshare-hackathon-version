{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - Users of {{ table['title'] }}{% endblock %}

{% block content %}
{{ partial('table/detail/header') }}

<div class="container container--tableUsers">
  <div class="container__content">
    <p>User overview</p>
    <div class="tableUsers">
      {% if tableUsers %}
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
            {% if auth().getUserId() != user['id'] %}
              <div class="tableUsers__item__follow">
                <button class="follow-user {% if user['following'] %}following-user selected {% else %}not-following-user {% endif %}" data-id="{{ user['id'] }}" type="button"></button>
              </div>
            {% else %}
              <div class="tableUsers__item__follow">
                <button disabled type="button">It's you</button>
              </div>
            {% endif %}
          </div>
        {% endfor %}
      {% else %}
        <div class="center">
          <img src="/assets/images/laptop.png" alt="" />
          <p>&nbsp;</p>
          <p>There are no users matching your filter, yet.</p>
        </div>
      {% endif %}
    </div>
  </div>
  <aside class="aside aside--tableUsers">
    <p>Filter users</p>
    <a href="/table/{{ table['id'] }}/users/subscribers">
      <div class="aside__item {% if userFilter == 'subscribers' %}item-selected{% endif %}">
        <p>Subscribers</p>
      </div>
    </a>
    <a href="/table/{{ table['id'] }}/users/upvoters">
      <div class="aside__item {% if userFilter == 'upvoters' %}item-selected{% endif %}">
        <p>Upvoted by</p>
      </div>
    </a>
    <a href="/table/{{ table['id'] }}/users/contributors">
      <div class="aside__item {% if userFilter == 'contributors' %}item-selected{% endif %}">
        <p>Contributors</p>
      </div>
    </a>
    <a href="/table/{{ table['id'] }}/users/admins">
      <div class="aside__item {% if userFilter == 'admins' %}item-selected{% endif %}">
        <p>Admins</p>
      </div>
    </a>
  </aside>
</div>
{% endblock %}

{% block scripts %}
{{ partial('table/detail/flag') }}
{% endblock %}
