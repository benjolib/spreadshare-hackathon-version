{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - Feed for table {{ table['title'] }}{% endblock %}

{% block content %}
{{ partial('table/detail/header') }}

<div class="container container--tableFeed">
    <div class="container__content">
        <div></div>
        {% for log in logs %}
        <div class="tableFeed__item">
            <div class="tableFeed__item__avatar">
                <a href="/user/{{ log['userHandle'] }}">
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
        <a href="/table/{{ table['id'] }}/feed">
            <div class="aside__item {% if selectedTab == '' %}item-selected{% endif %}">
                <p>All</p>
            </div>
        </a>
        <a href="/table/{{ table['id'] }}/feed/edits">
            <div class="aside__item {% if selectedTab == 'edits' %}item-selected{% endif %}">
                <p>Edits & Deletes</p>
            </div>
        </a>
        <a href="/table/{{ table['id'] }}/feed/upvotes">
            <div class="aside__item {% if selectedTab == 'upvotes' %}item-selected{% endif %}">
                <p>Upvotes</p>
            </div>
        </a>
        <a href="/table/{{ table['id'] }}/feed/subscriptions">
            <div class="aside__item {% if selectedTab == 'subscriptions' %}item-selected{% endif %}">
                <p>Subscribers</p>
            </div>
        </a>
        <a href="/table/{{ table['id'] }}/feed/comments">
            <div class="aside__item {% if selectedTab == 'comments' %}item-selected{% endif %}">
                <p>Comments</p>
            </div>
        </a>
    </aside>
</div>
{% endblock %}

{% block scripts %}
{{ partial('table/detail/flag') }}
{% endblock %}
