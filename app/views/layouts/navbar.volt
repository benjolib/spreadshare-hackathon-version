{% if auth.loggedIn() %}
<nav class="navbar">
{% else %}
<div style="height:40px;background:#252541;border-bottom:1px solid #484871;color:#fff;"><p style="text-align: center;line-height:40px;"><svg style="border-radius:50%;border:1px solid #fff;margin-right:5px;" width="25" height="25" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><path d="M40 20c0 11.046-8.954 20-20 20S0 31.046 0 20 8.954 0 20 0s20 8.954 20 20" fill="#DA552F"></path><path d="M22.667 20H17v-6h5.667c1.656 0 3 1.343 3 3s-1.344 3-3 3m0-10H13v20h4v-6h5.667c3.866 0 7-3.134 7-7s-3.134-7-7-7" fill="#FFF"></path></g></svg> SpreadShare has been nominated for a Golden Kitty Award on Product Hunt. Check it out <a style="color:#fff;text-decoration:underline;" target="_new" href="https://www.producthunt.com/posts/spreadshare-2">meow</a>! 😸</p></div>
<nav class="navbar navbar--loggedOut">
{% endif %}
  <div class="navbar__wrapper navbar__wrapper--left">
    <div class="navbar__logo desktop-only desktop-only--flex">
      <a href="/"><img src="/assets/images/icon_1024.png" /></a>
    </div>
    <div class="navbar__search desktop-only desktop-only--flex">
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
  <div class="navbar__controls desktop-only">
    <div class="navbar__wrapper navbar__wrapper--left">
      <div class="navbar__logo mobile-and-tablet">
        <a href="/"><img src="/assets/images/icon_1024.png" /></a>
      </div>
      <div class="navbar__search mobile-and-tablet mobile-and-tablet--flex">
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
    <div class="navbar__wrapper navbar__wrappper--right">
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
          <li><a href="/leaderboard">Leaderboard</a></li>
          <li class="separator"></li>
          <li><a href="/user/{{ auth.getUser().handle }}">Profile</a></li>
          <li><a href="/user/{{ auth.getUser().handle }}/tables">Your Tables</a></li>
          <li><a href="/settings/wallet">Wallet</a></li>
          <li><a href="/settings/invite">Get Token</a></li>
          <li><a href="/settings/personal">Settings</a></li>
          <li><a href="/logout">Sign out</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="navbar__controls mobile-and-tablet mobile-and-tablet--flex">
    <div class="navbar__wrapper navbar__wrapper__mobile--left">
      <div class="navbar__logo mobile-and-tablet">
        <a href="/"><img src="/assets/images/icon_1024.png" /></a>
      </div>
      <div class="navbar__search mobile-and-tablet mobile-and-tablet--flex">
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
    <div class="navbar__wrapper navbar__wrapper__mobile--right">
      <span class="navbar__controls__add navbar__controls__add--notification"></span>
      <a class="navbar__controls__add__create" href="/table/add">
        <img src="/assets/icons/add-green.svg" class="navbar__controls__add" title="Create a New Table" />
        <span>Create a Table</span>
      </a>
      <a id="notificationButton" href="javascript:;">
        {% if auth.getUser().getStats().getUnreadNotificationsCount() >0 %}<span>{{ auth.getUser().getStats().getUnreadNotificationsCount() }}</span>{% endif %}
        <img src="/assets/icons/bell.svg" class="navbar__controls__notification" />
      </a>
      <div class="dropdown dropdown--notifications">
        <br />
        <div class="loading"></div>
        <br />
      </div>
      <a id="profileImage" href="javascript:;">
        <img src="{{ auth.getUser().getImage() }}" class="navbar__controls__profile" />
      </a>
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
  </div>
  {% else %}
  <div class="navbar__logo mobile-and-tablet mobile-and-tablet--flex">
    <a href="/"><img src="/assets/images/icon_1024.png" /></a>
  </div>
  <div class="navbar__search mobile-and-tablet mobile-and-tablet--flex">
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

  <div class="navbar__wrapper navbar__wrappper--right">
    <div class="navbar__controls">
      <a class="navbar__controls__add__create" href="/table/add">
        <img src="/assets/icons/add-green.svg" class="navbar__controls__add" title="Create a New Table" />
        <span>Create a Table</span>
      </a>
    </div>
    <span class="navbar__login">
      <a href="/login" class="navbar__login__login"></a>
      <span>or</span>
      <a href="/signup" class="navbar__login__signup">Sign up</a>
    </span>
  </div>
  {% endif %}
</nav>
