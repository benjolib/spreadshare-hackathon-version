<nav class="navbar">
  <div class="navbar__logo">
    <a href="/"><h1>SpreadShare</h1></a>
    <h2>Community curated Tables</h2>
  </div>
  <div class="navbar__search">
    <div class="navbar__search__icon">
      <img src="/assets/icons/search.svg" />
    </div>
    <input type="text" class="navbar__search__field" placeholder="Find anything" />
    <div class="navbar__search__filter">
      <img class="navbar__search__filter__icon" src="/assets/icons/filter.svg" />
    </div>
    <!-- Begin Search Auto Complete Component !-->
    <div class="search-autocomplete search__dropdown">
        <div class="title-block">
            <div class="description">
                TABLE TITLE
            </div>
            <div class="result-count">
            </div>
            <div id="search-items"></div>
            <hr class="divider">
            <div class="all-results">All Results</div>
        </div>
    </div>

    <!-- End Search Auto Complete Component !-->

  </div>
  {% if auth.loggedIn() %}
  <div class="navbar__controls">
    <img src="/assets/icons/add.svg" class="navbar__controls__add navbar__controls__add--notification" />
    <img src="/assets/icons/add.svg" class="navbar__controls__add navbar__controls__add--menu" />
    <a id="notificationButton" href="javascript:;"><img src="/assets/icons/bell.svg" class="navbar__controls__notification" /></a>
    <div class="dropdown dropdown--notifications">
      {% if notifications is defined %}
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
        <div class="center">
          <a href="/feed"><p>All Notifications ⚡</p></a>
        </div>
      {% else %}
        <div class="center">
          <p>There are no notifications available for you 😢</p>
        </div>
      {% endif%}
    </div>
    <a id="profileImage" href="javascript:;"><img src="{{ auth.getUser().getImage() }}" class="navbar__controls__profile" /></a>
    <div class="profile-menu navbar__controls__dropdown">
      <ul>
        <li><a href="/table/add">Create a Table</a></li>
        <li><a href="/">Rankings</a></li>
        <li><a href="/user/{{ auth.getUser().handle }}">Profile</a></li>
        <li><a href="/settings/wallet">Wallet</a></li>
        <li><a href="/settings/invite">Get Token</a></li>
        <li><a href="/settings/account">Settings</a></li>
        <li><a href="/logout">Sign out</a></li>
      </ul>
    </div>
  </div>

  {% else %}
  <span class="navbar__login">
      <a href="/login" class="navbar__login__login">Login</a>
      <span>or</span>
      <a href="/signup" class="navbar__login__signup">Sign up</a>
    </span>
  {% endif %}
</nav>
