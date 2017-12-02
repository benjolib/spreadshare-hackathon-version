<aside class="profile__content__aside">
    <div class="profile__content__aside__box">
        <a href="/user/{{ profile.handle }}/upvoted">
            <div class="{% if currentPage == 'upvoted' %}sign-box-selected{% endif %}">Upvoted</div>
        </a>
        <a href="/user/{{ profile.handle }}/subscribed">
            <div class="{% if currentPage == 'subscribed' %}sign-box-selected{% endif %}">Subscribed</div>
        </a>
        <a href="/user/{{ profile.handle }}/owned">
            <div class="{% if currentPage == 'owned' %}sign-box-selected{% endif %}">Owned</div>
        </a>
        <a href="/user/{{ profile.handle }}/contributed">
            <div class="{% if currentPage == 'contributed' %}sign-box-selected{% endif %}">Contributed</div>
        </a>
        {% if auth.loggedIn() and auth.getUserId() == profile.id %}
        <a href="/user/{{ profile.handle }}/history">
            <div class="{% if currentPage == 'history' %}sign-box-selected{% endif %}">History</div>
        </a>
        {% endif %}
    </div>
    <div class="profile__content__aside__box">
        <a href="/user/{{ profile.handle }}/followers">
            <div class="{% if currentPage == 'followers' %}sign-box-selected{% endif %}">Followers</div>
        </a>
        <a href="/user/{{ profile.handle }}/following">
            <div class="{% if currentPage == 'following' %}sign-box-selected{% endif %}">Following</div>
        </a>
    </div>
</aside>
