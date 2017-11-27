<div class="table__header">
  <div class="table__header__up">
    <div class="table__header__up__details">
      {% if auth.getUserId() == table['ownerUserId'] %}
        <span class="table__header__up__details__owner">You are the creator of this table</span>
      {% endif %}
      <h1>{{ table['title'] }}</h1>
      <div class="table__header__up__details__info">
        <h3 class="table__header__up__details__info__tagline">{{ table['tagline'] }}</h3>
        <span class="table__header__up__details__info__tokens">{{ table['tokensCount'] }} Tokens</span>
      </div>
    </div>
    <div class="table__header__up__buttons">
      {% if auth.loggedIn() %}
      <button class="subscribe" data-action="subscribe" data-id="{{ table['id'] }}"></button>
      <button class="upvote {% if table['userHasVoted'] %}selected{% endif %}" data-action="upvote" data-id="{{ table['id'] }}" onclick="var event = arguments[0] || window.event; event.stopPropagation();">
        <div class="upvote-icon small"></div>
        <span>{{ table['votesCount'] +0 }}</span>
      </button>
      <button class="flag">
        <div class="flag-icon"></div>
      </button>
      <div class="table-menu navbar__controls__dropdown" style="margin-top:80px;">
        <ul>
          <li><a data-flag="duplicate" href="javascript:;">Duplicate</a></li>
          <li><a data-flag="spam" href="javascript:;">Spam</a></li>
          <li><a data-flag="copyright" href="javascript:;">Copyright</a></li>
          <li><a data-flag="inappropriate" href="javascript:;">Inappropriate</a></li>
          <li><a data-flag="other" href="javascript:;">Other</a></li>
        </ul>
      </div>
      {% else %}
      <button class="subscribe" type="button" onclick="document.location.href='/login';"></button>
      <button class="upvote" type="button" onclick="document.location.href='/login';">
        <div class="upvote-icon small"></div>
        <span>{{ table['votesCount'] +0 }}</span>
      </button>
      {% endif %}
    </div>
  </div>
  <div class="table__header__menu">
    <a href="/table/{{table['id']}}" class="table__header__menu__item{% if selectedPage == 'table' %} selected{% endif %}">
      <div class="table-icon"></div>
      Table
    </a>
    <a href="/table/{{table['id']}}/about" class="table__header__menu__item{% if selectedPage == 'about' %} selected{% endif %}">
      <div class="info-icon"></div>
      About
    </a>
    <a href="/table/{{table['id']}}/feed" class="table__header__menu__item{% if selectedPage == 'feed' %} selected{% endif %}">
      <div class="feed-icon"></div>
      Feed
    </a>

    {# OWNER TABS #}
    {% if auth.getUserId() == table['ownerUserId'] %}
    <a href="/table/{{table['id']}}/stats" class="table__header__menu__item{% if selectedPage == 'stats' %} selected{% endif %}">
      <div class="feed-icon"></div>
      Stats
    </a>
    <a href="/table/{{table['id']}}/changelog" class="table__header__menu__item{% if selectedPage == 'commits' %} selected{% endif %}">
      <div class="feed-icon"></div>
      Commits
    </a>
    <a href="/table/{{table['id']}}/users" class="table__header__menu__item{% if selectedPage == 'users' %} selected{% endif %}">
      <div class="feed-icon"></div>
      Users
    </a>
    <a href="/table/{{table['id']}}/settings" class="table__header__menu__item{% if selectedPage == 'settings' %} selected{% endif %}">
      <div class="people-icon"></div>
      Settings
    </a>
    {%endif%}
  </div>
</div>
