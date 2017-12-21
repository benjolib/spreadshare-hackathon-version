<div class="tableCard">
    <div class="tableCard__info">
        <div class="tableCard__info__title">
            <h3><a href="/table/{{ table['id'] }}" }>{{ table['title'] }}</a>{% if table['staffPick'] %}<span class="staff-pick">Staff Pick 👏</span>{% endif %}</h3>
            <p>{{ table['tagline'] }}</p>
        </div>
        <div class="tableCard__info__right_buttons">
        {% if auth.loggedIn() %}
            {% if table['ownerUserId'] != auth().getUserId() %}
                <div class="tableCard__info__button upvote {% if table['userHasVoted'] %}selected{% endif %}" data-action="upvote" data-id="{{ table['id'] }}"
                     onclick="var event = arguments[0] || window.event; event.stopPropagation();">
                    <a class="chevronUp">
                        {{ partial('partials/icons/upvote') }}
                        <span>{{ table['votesCount'] +0 }}</span>
                    </a>
                </div>
            {% endif %}
        {% else %}
            <div class="tableCard__info__button upvote" onclick="document.location.href='/login';">
                <a class="chevronUp">
                    {{ partial('partials/icons/upvote') }}
                    <span>{{ table['votesCount'] +0 }}</span>
                </a>
            </div>
        {% endif %}
        </div>
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
