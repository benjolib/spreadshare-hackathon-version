<div class="tableCard">
    <div class="tableCard__info">
        <div class="tableCard__info__title">
            <h3><a href="/table/{{ table['id'] }}" }>{{ table['title'] }}</a></h3>
            <p>{{ table['tagline'] }}</p>
        </div>
        {% if auth.loggedIn() %}
            {% if table['ownerUserId'] != auth().getUserId() %}
            <div class="tableCard__info__upvote upvote {% if table['userHasVoted'] %}selected{% endif %}" data-action="upvote" data-id="{{ table['id'] }}"
                 onclick="var event = arguments[0] || window.event; event.stopPropagation();">
                <div class="chevronUp">
                    {{ partial('partials/icons/chevron-up') }}
                </div>
                <span>{{ table['votesCount'] +0 }}</span>
            </div>
            {% endif %}
        {% else %}
        <div class="tableCard__info__upvote upvote" onclick="document.location.href='/login';">
            <div class="chevronUp">
                {{ partial('partials/icons/chevron-up') }}
            </div>
            <span>{{ table['votesCount'] +0 }}</span>
        </div>
        {% endif %}
    </div>
    <div class="tableCard__stats">
        {# table type #}
        <a class="tableCard__stats__item tableCard__stats__item--type" href="/?topic=&type={{ table['typeId'] }}">
            {% if table['typeTitle'] %}
            <span>{{ table['typeTitle'] }}</span>
            {% else %}
            <span>Uncategorized</span>
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
