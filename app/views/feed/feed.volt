{% extends 'layouts/main.volt' %}

{# page title #}
{% block title %}SpreadShare - Feed - Community curated Tables{% endblock %}

{% block content %}
<h3>Recent activity</h3>
<div class="container container--tableFeed">
  <div class="container__content">
    {% for notification in notifications %}
    <div class="tableFeed__item">
      <div class="tableFeed__item__avatar">
        <a href="/user/{{ notification['userHandle'] }}">
          <img src="{{ notification['userImage'] }}" />
        </a>
      </div>
      <div class="tableFeed__item__info">
        <div class="tableFeed__item__info__text">
            <span class="tableFeed__item__info__text__author">
              {{ notification['userName'] }}
            </span>
          <span class="tableFeed__item__info__text__message">
              {{ notification['text'] }}
            </span>
        </div>
        <div class="tableFeed__item__info__time">
          <span>{{ formatTimestamp(notification['createdAt']) }}</span>
        </div>
      </div>
    </div>
    {% endfor %}
  </div>
  <aside class="aside">
    <a href="/feed">
      <div class="aside__item item-selected">
        <p>All</p>
      </div>
    </a>
    <a href="/feed/changes">
      <div class="aside__item">
        <p>Changes</p>
      </div>
    </a>
    <a href="/feed/comments">
      <div class="aside__item">
        <p>Comments</p>
      </div>
    </a>
    <a href="/feed/followers">
      <div class="aside__item">
        <p>Followers</p>
      </div>
    </a>
    <a href="/feed/subscribers">
      <div class="aside__item">
        <p>Subscribers</p>
      </div>
    </a>
    <a href="/feed/upvotes">
      <div class="aside__item">
        <p>Upvotes</p>
      </div>
    </a>
  </aside>
</div>

{% endblock %}

{% block scripts %}

{% endblock %}
