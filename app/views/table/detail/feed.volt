{% extends 'layouts/main.volt' %}

{% block content %}
{{ partial('table/detail/header') }}

<div class="container container--tableFeed">
  <div class="container__content">
    {% for log in logs %}
      <div class="tableFeed__item">
        <div class="tableFeed__item__avatar">
          <a href="/user/{{ notification['userHandle'] }}">
            <img src="{{ log['userImage'] }}" />
          </a>
        </div>
        <div class="tableFeed__item__info">
          <div class="tableFeed__item__info__text">
            <span class="tableFeed__item__info__text__author">
              {{ log['userName'] }}
            </span>
            <span class="tableFeed__item__info__text__message">
              {{ log['text'] }}
            </span>
          </div>
          <div class="tableFeed__item__info__time">
            <span>{{ formatTimestamp(log['createdAt']) }}</span>
          </div>
        </div>
      </div>
    {% endfor %}
  </div>
  <aside class="aside">
    <a href="#">
      <div class="aside__item item-selected">
        <p>All</p>
      </div>
    </a>
    <a href="#">
      <div class="aside__item">
        <p>New adds</p>
      </div>
    </a>
    <a href="#">
      <div class="aside__item">
        <p>Edits & Deletes</p>
      </div>
    </a>
    <a href="#">
      <div class="aside__item">
        <p>Upvotes</p>
      </div>
    </a>
    <a href="#">
      <div class="aside__item">
        <p>Subscribers</p>
      </div>
    </a>
    <a href="#">
      <div class="aside__item">
        <p>Comments</p>
      </div>
    </a>
  </aside>
</div>
{% endblock %}
