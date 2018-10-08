<header class="re-header {{ editing is not empty and editing ? 're-header--editing': '' }}">
    <div class="re-header__inner">
        <a class="re-header__logo" href="/"><img src="/assets/images/9-0/logo.svg" /></a>
        <a class="re-header__item feed {{ forYouActive is not empty and forYouActive ? 'active': '' }}" href="/for-you"><img src="/assets/images/9-0/header-feed-bird.svg" /> Community</a>
        <a class="re-header__item explore {{ exploreActive is not empty and exploreActive ? 'active': '' }}" href="/"><img src="/assets/images/9-0/header-explore-whale.svg" /> Streams</a>
        {% if auth.loggedIn() %}
            {% if pendingReceived(auth.getUser().id) > 0 %}
        <a class="re-header__item collabs {{ collabsActive is not empty and collabsActive ? 'active': '' }}" href="/collaborations#received">
            <img src="/assets/images/9-0/header-collabs-octopus.svg" /> Collabs
            <div class="blucircle">
                {{ pendingReceived(auth.getUser().id) }}
            </div>
        </a>
            {% else %}
        <a class="re-header__item collabs {{ collabsActive is not empty and collabsActive ? 'active': '' }}" href="/collaborations">
            <img src="/assets/images/9-0/header-collabs-octopus.svg" /> Collabs
        </a>
            {% endif %}
        {% else %}
        <a class="re-header__item collabs {{ collabsActive is not empty and collabsActive ? 'active': '' }}" href="/collaborations">
            <img src="/assets/images/9-0/header-collabs-octopus.svg" /> Collabs
        </a>
        {% endif %}

        <!-- search section start -->

        <!-- search icon -->
        <a class="re-header__search {% if query is defined %}hidden{% endif %}" href="javascript:;">
            <img class="re-header__search__img" src="/assets/images/9-0/header-search.svg" />
        </a>

        <!-- search input -->
        <div class="re-header__search-open" style="{% if query is not defined %}display:none;{% endif %}">
            <img src="/assets/images/search-green.svg" />
            <input type="text" placeholder="Search" class="navbar__search__field" value="{% if query is defined %}{{ query }}{% endif %}" />
            <img class="search-close" src="/assets/images/search-cross.svg" />
        </div>

        <!-- search popper -->
        <div class="search-autocomplete search__dropdown">
            <div class="u-flex streams-section">
                <div class="description">
                    STREAMS
                </div>
                <div class="streams-result-count">
                    <!-- here would be result count number -->
                </div>
            </div>

            <div id="streams-search-items">
                <!-- here would be result entries -->
            </div>
            <a href="#" class="all-results">More Results</a>

            <div class="u-flex users-section">
                <div class="description">
                    USERS
                </div>
                <div class="users-result-count">
                    <!-- here would be result count number -->
                </div>
            </div>
            <div id="users-search-items">
                <!-- here would be result entries -->
            </div>
        </div>

        <!-- search section end -->

        {% if auth.loggedIn() %}
        <a class="re-header__add" href="/create-list"><img src="/assets/images/9-0/header-add.svg" /></a>
        <a class="re-header__bell l-button" data-dropdown-placement="bottom-end" data-dropdown-offset="74" href="javascript:;">
            {% if auth.getUser().getStats().getUnreadNotificationsCount() > 0%}
            <div class="numberCircle">
                {{ auth.getUser().getStats().getUnreadNotificationsCount() }}
            </div>
            {% else %}
            <img src="/assets/images/9-0/header-notifications.svg" />
            {% endif %}
        </a>
        <div class="l-dropdown sh-dropdown notification-dropdown u-flex u-flexCol">
        </div>

        <!-- top-right dropdown settings menu -->

        <a class="re-header__user l-button" data-dropdown-placement="bottom-end" data-dropdown-offset="20"  href="javascript:;">
        <!-- <img src="{{ auth.getUser().getImage() }}" />  -->
            <div width="25px" height="25px" style="border-radius:9999px;width:30px;height:30px;background: url('{{ auth.getUser().getImage() }}') center / cover;">
                <div widht="9px" height="6px" class="down" style="background: url('/assets/images/9-0/user-down.svg') center;"></div>
            </div>
        </a>
        <div class="l-dropdown sh-dropdown re-header__user-dropdown2 user-dropdown2 u-flex" aria-haspopup="true" aria-expanded="false">
            <section>
                <div>YOU</div>
                <a href="/profile/{{ auth.getUser().handle }}">This is your <span>profile</span></a>
                <a href="/subscriptions">All Streams you've <span>subscribed</span> to</a>
                <a href="/history">All Streams you've <span>recently viewed</span></a>
            </section>
            <section>
                <div>SETTINGS</div>
                <a href="/settings#emails">Adjust your <span>email settings</span></a>
                <a href="/settings">Manage your <span>account</span></a>
            </section>
            <section>
                <div>FOR CURATORS</div>
                <a href="/streams">All <span>Streams</span> created by you</a>
                <a href="/stats"><span>Stats</span> for all your Streams</a>
            </section>
            <section>
                <div>ABOUT</div>
                <a href="/about">Blog, Jobs, <span>About</span> and more</a>
            </section>
            <a href="/logout" class="logout">Logout</a>
        </div>

        <a class="re-header__hamburger l-button" data-dropdown-placement="bottom-end" href="javascript:;"><img src="/assets/images/9-0/header-menu-hamburger.svg" /></a>

        <div class="l-dropdown sh-dropdown re-header__user-dropdown2 user-dropdown2 u-flex">
            <section>
                <div>YOU</div>
                <a href="/profile/{{ auth.getUser().handle }}">This is your <span>profile</span></a>
                <a href="/subscriptions">All Streams you've <span>subscribed</span> to</a>
                <a href="/history">All Streams you've <span>recently viewed</span></a>
            </section>
            <section>
                <div>SETTINGS</div>
                <a href="/settings#emails">Adjust your <span>email settings</span></a>
                <a href="/settings">Manage your <span>account</span></a>
            </section>
            <section>
                <div>FOR CURATORS</div>
                <a href="/streams">All <span>Streams</span> created by you</a>
                <a href="/stats"><span>Stats</span> for all your Streams</a>
            </section>
            <section>
                <div>ABOUT</div>
                <a href="/about">Blog, Jobs, <span>About</span> and more</a>
            </section>
            <a href="/logout" class="logout">Logout</a>
        </div>
        {% else %}
        <a class="re-button re-button--header" href="/login">
            <span>Join us<span> via</span></span>
            <img src="/assets/images/join-button-facebook.svg" />
            <img src="/assets/images/join-button-twitter.svg" />
            <img src="/assets/images/join-button-google.svg" />
        </a>
        {% endif %}
    </div>

    <div class="re-header__editing">
        <a href="/" class="re-button re-button--grey cancel-button">Cancel</a>
        <a href="#" class="re-button save-button">Publish</a>
        <img class="l-button re-header__editing__arrow" src="/assets/images/header-editing-arrow-down.svg" />
        <div class="sh-dropdown list-editing-draft-dropdown u-flex u-flexCol u-flexJustifyCenter l-dropdown">
            <a href="#"><img src="/assets/images/list-editing-draft-save.svg" /> Save as Draft</a>
        </div>
    </div>
</header>
