<nav class="navbar">
  <div class="navbar__wrapper navbar__wrapper--left">
    <div class="navbar__logo">
      <a href="/"><img src="/assets/images/icon_1024.png" /></a>
    </div>
    <div class="navbar__search">
      {% if searchDisabled is empty %}

      <div class="navbar__search__icon">
        <img src="/assets/icons/search-green.svg" />
      </div>

      {% if query is defined %}
      <input type="text" class="navbar__search__field" placeholder="Search" value="{{ query }}" />
      {% else %}
      <input type="text" class="navbar__search__field" placeholder="Search" />
      {% endif %}

      {% endif %}

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
    </div>
  </div>
  {% if auth.loggedIn() %}
  <div class="navbar__controls">
    <span class="navbar__controls__add navbar__controls__add--notification"></span>
    <a class="navbar__controls__add__create" href="/table/add">
      <img src="/assets/icons/add-green.svg" class="navbar__controls__add" title="Create a New Table" />
      <span>Create a Table</span>
    </a>
    <a id="notificationButton" href="javascript:;">
      {% if auth.getUser().getStats().getUnreadNotificationsCount() >0 %}<span>{{ auth.getUser().getStats().getUnreadNotificationsCount() }}</span>{% endif %}
      <img src="/assets/icons/bell.svg" class="navbar__controls__notification" />
    </a>
    <div class="dropdown dropdown--notifications"><br />
      <div class="loading"></div>
      <br /></div>
    <a id="profileImage" href="javascript:;"><img src="{{ auth.getUser().getImage() }}" class="navbar__controls__profile" /></a>
    <div class="profile-menu navbar__controls__dropdown">
      <ul>
        <li><a href="/table/add">Create a Table</a></li>
        <li><a href="/">Home</a></li>
        <li><a href="/user/{{ auth.getUser().handle }}">Profile</a></li>
        <li><a href="/settings/wallet">Wallet</a></li>
        <li><a href="/settings/invite">Get Token</a></li>
        <li><a href="/settings/personal">Settings</a></li>
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
