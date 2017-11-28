{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
<div class="profile">
  {{ flash.output() }}
  <div class="profile__hero">
    <div class="profile__row">
      <div class="profile__hero__avatar">
        <img src="{{ profile.image }}" />
      </div>
      <div class="profile__hero__info">
        <div class="profile__hero__info__name"><h3>{{ profile.name }}</h3></div>
        <div class="profile__hero__info__tagline">
          <p>{{ profile.tagline }}</p>
        </div>
        <div class="profile__row profile__row">
          <div class="profile__hero__info__location">
            {% if profile.location %}
            <p>{{profile.location}}</p>
            {% endif %}
          </div>
          <div class="profile__hero__info__website">
            {% if profile.website %}
            <span>●</span>
            <a href="{{ profile.website }}" target="_blank">{{profile.website}}</a>
            {% endif %}
          </div>
          <div class="profile__hero__info__mobile">
            <div class="profile__hero__info__mobile__website">
              {% if profile.website %}
              <a href="{{profile.website}}" target="_blank">{{profile.website}}</a>
              <span>●</span>
              {% endif %}
            </div>
            <div class="profile__hero__info__mobile__social">
              <ul>
                {% for connection in connections %}
                <li><a href="{{ connection['link'] }}"><img src="/assets/icons/{{ connection['name'] }}.svg" /></a></li>
                {% endfor %}
              </ul>
            </div>
          </div>
        </div>
        <div class="profile__row profile__row--pushToBottom">
          {% if auth.loggedIn() and auth.getUserId() != profile.id %}
          <div class="profile__hero__info__edit">
            {% if following %}
            <button class="follow-user following-user" data-id="{{ profile.id }}" type="button"></button>
            {% else %}
            <button class="follow-user not-following-user selected" data-id="{{ profile.id }}" type="button"></button>
            {% endif %}
          </div>
          {% endif %}

          {% if auth.loggedIn() and auth.getUserId() == profile.id %}
          <div class="profile__hero__info__edit">
            <button onclick="window.location.href='/settings/personal';">Edit</button>
          </div>
          {% endif %}
          <div class="profile__hero__info__social">
            <ul>
              {% for connection in connections %}
              <li><a href="{{ connection['link'] }}"><img src="/assets/icons/{{ connection['name'] }}.svg" /></a></li>
              {% endfor %}
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="profile__content">
    <div class="profile__content__wrapper">
      <div class="profile__content__tables">
        <div class="profile__content__tables__cards">
          {% if tables OR users %}

          {{ partial('user/profile/tables') }}
          {{ partial('user/profile/users') }}

          {% else %}
          <div class="container__content center" style="width:100%;padding: 40px;">
            <div class="center" style="width:100%;">
              <img src="/assets/images/desktop.png" alt="" />
              <p>&nbsp;</p>
              <p>There are no items available for your filter "<strong>{{ currentPage }}</strong>".</p>
            </div>
          </div>
          {% endif %}
        </div>
      </div>
      <aside class="profile__content__aside">
        <div class="profile__content__aside__box">
          <a href="/user/{{ profile.handle }}/upvoted">
            <div class="{% if currentPage == 'upvoted' %}sign-box-selected{% endif %}">Upvoted</div>
          </a>
          <a href="/user/{{ profile.handle }}/subscribed">
            <div class="{% if currentPage == 'subscribed' %}sign-box-selected{% endif %}">Subscribed</div>
          </a>
          <a href="/user/{{ profile.handle }}/owned">
            <div class="{% if currentPage == 'owned' %}sign-box-selected{% endif %}">Owned</div>
          </a>
          {% if auth.loggedIn() and auth.getUserId() == profile.id %}
          <a href="/user/{{ profile.handle }}/contributed">
            <div class="{% if currentPage == 'contributed' %}sign-box-selected{% endif %}">Contributed</div>
          </a>
          <a href="/user/{{ profile.handle }}/history">
            <div class="{% if currentPage == 'history' %}sign-box-selected{% endif %}">History</div>
          </a>
          {% endif %}
        </div>
        <div class="profile__content__aside__box">
          <a href="/user/{{ profile.handle }}/followers">
            <div class="{% if currentPage == 'followers' %}sign-box-selected{% endif %}">Followers</div>
          </a>
          <a href="/user/{{ profile.handle }}/following">
            <div class="{% if currentPage == 'following' %}sign-box-selected{% endif %}">Following</div>
          </a>
        </div>
      </aside>
    </div>
  </div>
</div>
{% endblock %}
