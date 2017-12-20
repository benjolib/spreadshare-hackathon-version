{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - {{ profile.name }} - Your Tables{% endblock %}

{% block header %}
{% endblock %}

{% block content %}
<div class="submenu">
    <ul>
        <li {% if filter == 'published' %}class="active"{% endif %}><a href="/user/{{ profile.handle }}/tables?filter=published">Published Tables</a></li>
        <li {% if filter == 'drafts' %}class="active"{% endif %}><a href="/user/{{ profile.handle }}/tables?filter=drafts">Drafts</a></li>
    </ul>
</div>

<div class="profile" style="margin-top:50px;">
    {{ flash.output() }}
    <div class="container container--usersAndTables">
        {% if tables is defined AND tables %}
        {% if tables %}
        <div class="container__content container__content--tables" style="width:100%;">
            {% for table in tables %}
            <div class="tableCard">
                <div class="tableCard__info">
                    <div class="tableCard__info__title">
                        <h3><a href="/table/{{ table['id'] }}" }>{{ table['title'] }}</a>{% if table['staffPick'] %}<span class="staff-pick">Staff Pick 👏</span>{% endif %}</h3>
                        <p>{{ table['tagline'] }}</p>
                    </div>
                    {% if auth.loggedIn() %}
                    {% if table['ownerUserId'] == auth().getUserId() %}
                    <div class="tableCard__info__right_buttons">
                        <div class="tableCard__info__button">
                            <a href="/table/{{ table['id'] }}/settings">Manage</a>
                        </div>
                        {% if showPublishButton %}
                            <div class="tableCard__info__button green">
                                <a href="/table/add/confirm?tableId={{ table['id'] }}&redirectToTable">Publish</a>
                            </div>
                        {% endif %}
                    </div>
                    {% endif %}
                    {% endif %}
                </div>
                <div class="tableCard__stats">
                    {# table type #}
                    <a class="tableCard__stats__item tableCard__stats__item--type" href="/?topic=&type={{ table['typeId'] }}">
                        {% if table['topic1'] %}
                        <span>{{ table['topic1'] }}</span>
                        {% else %}
                        <span></span>
                        {% endif %}
                    </a>
                    {# tokens #}
                    <a class="tableCard__stats__item tableCard__stats__item--token" href="/table/{{ table['id'] }}">
                        {% if table['tokensCount'] > 0 %}
                        <span>{{ table['tokensCount'] +0 }} Tokens</span>
                        {% else %}
                        <span>0 Token</span>
                        {% endif %}
                    </a>
                    {# views #}
                    <a class="tableCard__stats__item tableCard__stats__item--views" href="/table/{{ table['id'] }}/about">
                        <span><i>{{ table['viewsCount'] +0 }}</i> Views</span>
                    </a>
                    {# comments #}
                    <a class="tableCard__stats__item tableCard__stats__item--comments" href="/table/{{ table['id'] }}/about#comments">
                        <span><i>{{ table['commentsCount'] +0 }}</i> Comments</span>
                    </a>
                    {# contributions #}
                    <a class="tableCard__stats__item tableCard__stats__item--contributions" href="/table/{{ table['id'] }}/users/contributors">
                        <span><i>{{ table['contributionCount'] }}</i> Contributions</span>
                    </a>
                </div>
            </div>

            {% endfor %}
        </div>
        {% endif %}

        {% else %}
        <div class="container__content" style="margin-right:40px;">
            <div class="container__content center" style="width:100%;padding: 40px;">
                <div class="center" style="width:100%;">
                    <img src="/assets/images/desktop.png" alt="" />
                    <p>&nbsp;</p>
                    <p>You haven't created any tables, yet.</p>
                </div>
            </div>
        </div>
        {% endif %}
    </div>
</div>
{% endblock %}
