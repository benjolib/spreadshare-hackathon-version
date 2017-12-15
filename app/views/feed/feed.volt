{% extends 'layouts/main.volt' %}

{# page title #}
{% block title %}SpreadShare - Feed - Data that matters.{% endblock %}

{% block content %}

<div class="tableFeed">
    <div class="tableFeed__title">
        <p>Your Notifications</p>
    </div>
    <div class="container container--tableFeed">
        {% if notifications %}
        <div class="container__content">
            {% for notification in notifications %}
            <div class="tableFeed__item">
                <div class="tableFeed__item__avatar">
                    <a href="/user/{{ notification['userHandle'] }}">
                        <img src="{{ notification['userImage'] }}" />
                    </a>
                </div>
                <a href="{{ linkHelper.getLink(notification) }}">
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
                </a>
            </div>
            {% endfor %}
        </div>
        {% else %}
        <div class="container__content center">
            <div>
                <img src="/assets/images/desktop.png" alt="" />
            </div>
            <p>&nbsp;</p>
            <p>There are no notifications available for you, yet..</p>
        </div>
        {% endif%}
        <aside class="aside">
            <a href="/feed">
                <div class="aside__item {% if type == '' %}item-selected{% endif %}">
                    <p>All</p>
                </div>
            </a>
            <a href="/feed/changes">
                <div class="aside__item {% if type == 'changes' %}item-selected{% endif %}">
                    <p>Changes</p>
                </div>
            </a>
            <a href="/feed/comments">
                <div class="aside__item {% if type == 'comments' %}item-selected{% endif %}">
                    <p>Comments</p>
                </div>
            </a>
            <a href="/feed/followers">
                <div class="aside__item {% if type == 'followers' %}item-selected{% endif %}">
                    <p>Followers</p>
                </div>
            </a>
            <a href="/feed/subscribers">
                <div class="aside__item {% if type == 'subscribers' %}item-selected{% endif %}">
                    <p>Subscribers</p>
                </div>
            </a>
            <a href="/feed/upvotes">
                <div class="aside__item {% if type == 'upvotes' %}item-selected{% endif %}">
                    <p>Upvotes</p>
                </div>
            </a>
        </aside>
    </div>
</div>

{% endblock %}

{% block scripts %}

{% endblock %}
