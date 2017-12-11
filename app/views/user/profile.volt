{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - {{ profile.name }} - {{ profile.handle }} - {{ profile.location }}{% endblock %}

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
        <div class="profile__hero__info__name"><h3>{{ profile.name }}{% if settings.showTokensOnProfilePage %} <span class="profile__hero__info__tokens">{{ userWallet.getTokens() }} Tokens</span>{% endif %}</h3></div>
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
                <li><a href="{{ connection['link'] }}"><img src="/assets/icons/social/{{ connection['name'] }}.svg" /></a></li>
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
              <li><a href="{{ connection['link'] }}"><img src="/assets/icons/social/{{ connection['name'] }}.svg" /></a></li>
              {% endfor %}
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container container--usersAndTables">
    {% if tables is defined AND tables %}
      {{ partial('user/profile/tables') }}
    {% elseif users is defined AND users %}
      {{ partial('user/profile/users') }}
    {% else %}
      <div class="container__content" style="margin-right:40px;">
        <div class="container__content center" style="width:100%;padding: 40px;">
          <div class="center" style="width:100%;">
            <img src="/assets/images/desktop.png" alt="" />
            <p>&nbsp;</p>
            <p>There are no items available for your filter "<strong>{{ currentPage }}</strong>".</p>
          </div>
        </div>
      </div>
    {% endif %}
    {{ partial('user/profileAside') }}
  </div>
</div>
{% endblock %}
