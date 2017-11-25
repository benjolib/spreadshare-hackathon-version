<div class="table__header">
  <div class="table__header__up">
    <div class="table__header__up__details">
      <span>2,745 Token</span>
      <h1>{{ table['title'] }}</h1>
      <h3>{{ table['tagline'] }}</h3>
    </div>
    <div class="table__header__up__buttons">
      <button class="subscribe" data-action="subscribe" data-id="{{ table['id'] }}"></button>
      <button class="upvote {% if table['userHasVoted'] %}selected{% endif %}" data-action="upvote" data-id="{{ table['id'] }}" onclick="var event = arguments[0] || window.event; event.stopPropagation();">
        <div class="upvote-icon small"></div>
        <span>{{ table['votesCount'] +0 }}</span>
      </button>
      <button class="flag"><div class="flag-icon"></div></button>
    </div>
  </div>
  <div class="table__header__menu">
    <a href="/table/{{table['id']}}">
      <div class="table__header__menu__item">
        <div class="table-icon"></div>
        Table
      </div>
    </a>
    <a href="/table/{{table['id']}}/about">
      <div class="table__header__menu__item">
        <div class="info-icon"></div>
        About
      </div>
    </a>
    <a href="/table/{{table['id']}}/feed">
      <div class="table__header__menu__item">
        <div class="feed-icon"></div>
        Feed
      </div>
    </a>
    <a href="/table/{{table['id']}}/user">
      <div class="table__header__menu__item">
        <div class="people-icon"></div>
        User
      </div>
    </a>
  </div>
</div>
