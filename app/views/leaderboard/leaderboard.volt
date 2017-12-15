{% extends 'layouts/main.volt' %}

{# page title #}
{% block title %}SpreadShare - Leaderboard{% endblock %}

{% block content %}

<div class="leaderBoard">
    <div class="leaderBoard__title">
        <p>Leaderboard</p>
    </div>
    <div class="container container--leaderBoard">
        {% if users is defined %}
        <div class="container__content">´
            {% for user in users %}
            <div class="leaderBoard__item">
                <div class="leaderBoard__item__index">
                    <span>{{ loop.index }}.</span>
                </div>
                <div class="leaderBoard__item__avatar">
                    <a href="/user/{{ user['handle'] }}">
                        <img src="{{ user['image'] }}" />
                    </a>
                </div>
                <div class="leaderBoard__item__info">
                    <p class="leaderBoard__item__info__text">
                        <a href="/user/{{ user['handle'] }}" class="leaderBoard__item__info__text__user">
                            {{ user['name']|escape }}
                        </a>
                    </p>
                    <p class="leaderBoard__item__info__text__message">
                        {{ user['location']|escape }} <span class="dot">&bull;</span> {{ user['tagline']|escape }}
                    </p>
                    <p class="leaderBoard__item__info__counter">
                        <span>{{ user['counter'] +0 }} {{ tab|capitalize }}</span>
                    </p>
                </div>
            </div>
            {% endfor %}
        </div>
        {% else %}
        <div class="container__content center">
            <div>
                <img src="/assets/images/desktop.png" alt="" />
            </div>
            <p>&nbsp;</p>
            <p>There is leaderboard available for {{ tab|capitalize }}, yet.</p>
        </div>
        {% endif%}

        <aside class="aside aside--addTable" style="margin-top:0;">
            <a href="/leaderboard/tokens">
                <div class="aside__item {% if tab == 'tokens' %}item-selected{% endif %}"><p>Tokens</p></div>
            </a>
            <a href="/leaderboard/contributions">
                <div class="aside__item {% if tab == 'contributions' %}item-selected{% endif %}"><p>Contributions</p></div>
            </a>
            <a href="/leaderboard/upvotes">
                <div class="aside__item {% if tab == 'upvotes' %}item-selected{% endif %}"><p>Upvotes</p></div>
            </a>
            <a href="/leaderboard/follower">
                <div class="aside__item {% if tab == 'follower' %}item-selected{% endif %}"><p>Follower</p></div>
            </a>
        </aside>
    </div>
</div>

{% endblock %}
