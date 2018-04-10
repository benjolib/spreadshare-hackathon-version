<header class="re-header">
  <div class="re-header__inner">
    <a class="re-header__logo" href="/"><img src="/assets/images/logo.png" /></a>
    <a class="re-header__item {{ exploreActive is not empty and exploreActive ? 'active': '' }}" href="/">Explore</a>
    <a class="re-header__item {{ forYouActive is not empty and forYouActive ? 'active': '' }}" href="/for-you">For You</a>
    <a class="re-header__search" href="#"><img class="re-header__search__img" src="/assets/images/search.svg" /><img class="re-header__search__img-green" src="/assets/images/search-green.svg" /></a>
    <div class="re-header__search-open" style="{% if query is not defined %}display:none;{% endif %}">
      <img src="/assets/images/search-green.svg" />
      <input type="text" placeholder="Search" class="navbar__search__field" value="{% if query is defined %}{{ query }}{% endif %}" />
      <img class="search-close" src="/assets/images/search-cross.svg" />
    </div>
    <div class="search-autocomplete search__dropdown">
      <div class="u-flex">
        <div class="description">
          LISTS
        </div>
        <div class="result-count">
        </div>
      </div>
      <div id="search-items"></div>
      <a href="#" class="all-results">More Results</a>
    </div>
    {% if auth.loggedIn() %}
      <a class="re-header__add" href="/table/add"><img src="/assets/images/header-add.svg" /></a>
      <a class="re-header__paperPencil" href="/collaborations"><img src="/assets/images/header-paper-pencil.svg" /></a>

      <a class="re-header__bell l-button" data-dropdown-placement="bottom-end" data-dropdown-offset="114" href="javascript:;">
        {% if auth.getUser().getStats().getUnreadNotificationsCount() > 0 %}<span>{{ auth.getUser().getStats().getUnreadNotificationsCount() }}</span>{% endif %}
        <img src="/assets/images/header-bell.svg" />
      </a>
      <div class="l-dropdown dropdown notification-dropdown u-flex u-flexCol">
        {% set numbers = [1, 2, 3, 4, 5, 6] %}

        {% for number in numbers %}
          <div class="notification-dropdown__notification u-flex u-flexAlignItemsCenter">
            <a href="/user/andrewcoyle">
              <img class="notification-dropdown__notification__image" src="https://cdn-images-1.medium.com/fit/c/100/100/1*iRHlXdQhKPpyNJ0w6f7ijw.jpeg" />
            </a>
            <div style="width:100%;">
              <div class="u-flex u-flexJustifyBetween">
                <a href="/user/andrewcoyle">
                  <span class="notification-dropdown__notification__name">Andrew Coyle</span>
                </a>
                <div class="notification-dropdown__notification__date"><img src="/assets/images/comment-clock.svg" />TODAY</div>
              </div>
              <p class="notification-dropdown__notification__text">Created a new list <a href="#">Design Tools</a></p>
            </div>
          </div>
        {% endfor %}

        <a href="/activity" class="notification-dropdown__notification__see-all">See All</a>
      </div>

      <a class="re-header__user l-button" data-dropdown-placement="bottom-end" data-dropdown-offset="48" href="javascript:;"><img src="{{ auth.getUser().getImage() }}" /></a>
      <div class="l-dropdown dropdown re-header__user-dropdown user-dropdown u-flex">
        <div class="user-dropdown__column">
          <a href="/profile/{{ auth.getUser().handle }}" class="user-dropdown__item">
            <div class="user-dropdown__item__image user-dropdown__item__image--profile"><img src="{{ auth.getUser().getImage() }}" /></div>
            <div class="user-dropdown__item__text">
              <h3>You</h3>
              <span>Your public profile</span>
            </div>
          </a>
          <a href="/lists" class="user-dropdown__item">
            <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-lists.svg" /></div>
            <div class="user-dropdown__item__text">
              <h3>Your Lists</h3>
              <span>All lists created by you</span>
            </div>
          </a>
          <a href="/subscriptions" class="user-dropdown__item">
            <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-subscriptions.svg" /></div>
            <div class="user-dropdown__item__text">
              <h3>Subscriptions</h3>
              <span>Lists you are subscribed</span>
            </div>
          </a>
          <a href="/submissions" class="user-dropdown__item">
            <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-submissions.svg" /></div>
            <div class="user-dropdown__item__text">
              <h3>Submissions</h3>
              <span>All listings you submitted</span>
            </div>
          </a>
          <a href="/collaborations" class="user-dropdown__item">
            <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-collaborations.svg" /></div>
            <div class="user-dropdown__item__text">
              <h3>Collaborations</h3>
              <span>Community requests to you</span>
            </div>
          </a>
        </div>
        <div class="user-dropdown__column">
          <a href="/table/add" class="user-dropdown__item">
            <div class="user-dropdown__item__image user-dropdown__item__image--fill-highlight"><img src="/assets/images/user-menu-create.svg" /></div>
            <div class="user-dropdown__item__text">
              <h3>Create List</h3>
              <span>Here you can create a list</span>
            </div>
          </a>
          <a href="/karma" class="user-dropdown__item">
            <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-karma.svg" /></div>
            <div class="user-dropdown__item__text">
              <h3>Karma</h3>
              <span>Your Karma points</span>
            </div>
          </a>
          <a href="/history" class="user-dropdown__item">
            <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-history.svg" /></div>
            <div class="user-dropdown__item__text">
              <h3>History</h3>
              <span>All lists you have seen</span>
            </div>
          </a>
          <a href="/settings" class="user-dropdown__item">
            <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-settings.svg" /></div>
            <div class="user-dropdown__item__text">
              <h3>Settings</h3>
              <span>Manage your account</span>
            </div>
          </a>
          <a href="/logout" class="user-dropdown__item">
            <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-logout.svg" /></div>
            <div class="user-dropdown__item__text user-dropdown__item__text--logout">
              <h3>Logout</h3>
              <span>See you soon</span>
            </div>
          </a>
        </div>
      </div>

      <a class="re-header__dotdotdot l-button" data-dropdown-placement="bottom-end" data-dropdown-offset="20" href="javascript:;"><img src="/assets/images/header-dotdotdot.svg" /></a>
      <div class="l-dropdown dropdown re-header__dotdotdot-dropdown user-dropdown u-flex" style="margin-top: 29px;">
        <div class="user-dropdown__column">
          <a href="/karma-challenge" class="user-dropdown__item">
            <div class="user-dropdown__item__image user-dropdown__item__image--fill-highlight"><img src="/assets/images/user-menu-karma-challenge.svg" /></div>
            <div class="user-dropdown__item__text">
              <h3>Karma Challenge</h3>
              <span>Earn money for contributing</span>
            </div>
          </a>
          <a href="/about" class="user-dropdown__item">
            <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-about.svg" /></div>
            <div class="user-dropdown__item__text">
              <h3>About</h3>
              <span>Who we are, what we do</span>
            </div>
          </a>
          <a href="/jobs" class="user-dropdown__item">
            <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-jobs.svg" /></div>
            <div class="user-dropdown__item__text">
              <h3>Jobs</h3>
              <span>Want to join our team?</span>
            </div>
          </a>
        </div>
        <div class="user-dropdown__column">
          <a href="/faq" class="user-dropdown__item">
            <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-faq.svg" /></div>
            <div class="user-dropdown__item__text">
              <h3>Frequently Asked</h3>
              <span>How Spreadshare works</span>
            </div>
          </a>
          <a href="/blog" class="user-dropdown__item">
            <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-blog.svg" /></div>
            <div class="user-dropdown__item__text">
              <h3>Blog</h3>
              <span>What inspires us to write</span>
            </div>
          </a>
          <a href="/terms" class="user-dropdown__item">
            <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-terms.svg" /></div>
            <div class="user-dropdown__item__text">
              <h3>Terms</h3>
              <span>Terms, conditions & privacy</span>
            </div>
          </a>
        </div>
      </div>

      <a class="re-header__hamburger l-button" data-dropdown-placement="bottom-end" href="javascript:;"><img src="/assets/images/hamburger.svg" /></a>
      <div class="l-dropdown dropdown user-dropdown u-flex u-flexCol user-dropdown--no-margin">
        <div class="u-flex user-dropdown__white-section">
          <div class="user-dropdown__column">
            <a href="/profile/{{ auth.getUser().handle }}" class="user-dropdown__item">
              <div class="user-dropdown__item__image user-dropdown__item__image--profile"><img src="{{ auth.getUser().getImage() }}" /></div>
              <div class="user-dropdown__item__text">
                <h3>You</h3>
                <span>Your public profile</span>
              </div>
            </a>
            <a href="/lists" class="user-dropdown__item">
              <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-lists.svg" /></div>
              <div class="user-dropdown__item__text">
                <h3>Your Lists</h3>
                <span>All lists created by you</span>
              </div>
            </a>
            <a href="/subscriptions" class="user-dropdown__item">
              <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-subscriptions.svg" /></div>
              <div class="user-dropdown__item__text">
                <h3>Subscriptions</h3>
                <span>Lists you are subscribed</span>
              </div>
            </a>
            <a href="/submissions" class="user-dropdown__item">
              <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-submissions.svg" /></div>
              <div class="user-dropdown__item__text">
                <h3>Submissions</h3>
                <span>All listings you submitted</span>
              </div>
            </a>
            <a href="/collaborations" class="user-dropdown__item">
              <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-collaborations.svg" /></div>
              <div class="user-dropdown__item__text">
                <h3>Collaborations</h3>
                <span>Community requests to you</span>
              </div>
            </a>
          </div>
          <div class="user-dropdown__column">
            <a href="/table/add" class="user-dropdown__item">
              <div class="user-dropdown__item__image user-dropdown__item__image--fill-highlight"><img src="/assets/images/user-menu-create.svg" /></div>
              <div class="user-dropdown__item__text">
                <h3>Create List</h3>
                <span>Here you can create a list</span>
              </div>
            </a>
            <a href="/karma" class="user-dropdown__item">
              <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-karma.svg" /></div>
              <div class="user-dropdown__item__text">
                <h3>Karma</h3>
                <span>Your Karma points</span>
              </div>
            </a>
            <a href="/history" class="user-dropdown__item">
              <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-history.svg" /></div>
              <div class="user-dropdown__item__text">
                <h3>History</h3>
                <span>All lists you have seen</span>
              </div>
            </a>
            <a href="/settings" class="user-dropdown__item">
              <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-settings.svg" /></div>
              <div class="user-dropdown__item__text">
                <h3>Settings</h3>
                <span>Manage your account</span>
              </div>
            </a>
            <a href="/logout" class="user-dropdown__item">
              <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-logout.svg" /></div>
              <div class="user-dropdown__item__text user-dropdown__item__text--logout">
                <h3>Logout</h3>
                <span>See you soon</span>
              </div>
            </a>
          </div>
        </div>
        <div class="u-flex user-dropdown__grey-section">
          <div class="user-dropdown__column">
            <a href="/karma-challenge" class="user-dropdown__item">
              <div class="user-dropdown__item__image user-dropdown__item__image--fill-highlight"><img src="/assets/images/user-menu-karma-challenge.svg" /></div>
              <div class="user-dropdown__item__text">
                <h3>Karma Challenge</h3>
                <span>Earn money for contributing</span>
              </div>
            </a>
            <a href="/about" class="user-dropdown__item">
              <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-about.svg" /></div>
              <div class="user-dropdown__item__text">
                <h3>About</h3>
                <span>Who we are, what we do</span>
              </div>
            </a>
            <a href="/jobs" class="user-dropdown__item">
              <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-jobs.svg" /></div>
              <div class="user-dropdown__item__text">
                <h3>Jobs</h3>
                <span>Want to join our team?</span>
              </div>
            </a>
          </div>
          <div class="user-dropdown__column">
            <a href="/faq" class="user-dropdown__item">
              <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-faq.svg" /></div>
              <div class="user-dropdown__item__text">
                <h3>Frequently Asked</h3>
                <span>How Spreadshare works</span>
              </div>
            </a>
            <a href="/blog" class="user-dropdown__item">
              <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-blog.svg" /></div>
              <div class="user-dropdown__item__text">
                <h3>Blog</h3>
                <span>What inspires us to write</span>
              </div>
            </a>
            <a href="/terms" class="user-dropdown__item">
              <div class="user-dropdown__item__image"><img src="/assets/images/user-menu-terms.svg" /></div>
              <div class="user-dropdown__item__text">
                <h3>Terms</h3>
                <span>Terms, conditions & privacy</span>
              </div>
            </a>
          </div>
        </div>
      </div>
    {% else %}
      <a class="re-button re-button--header" href="/login">
        <span>Join with</span>
        <img src="/assets/images/join-button-facebook.svg" />
        <img src="/assets/images/join-button-twitter.svg" />
        <img src="/assets/images/join-button-google.svg" />
      </a>
    {% endif %}
  </div>
</header>
{# {% if auth.loggedIn() %}
<nav class="navbar">
{% else %}
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
</nav> #}
