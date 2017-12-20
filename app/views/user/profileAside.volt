<div class="asides">
  <aside class="aside aside--profile">
    <a href="/user/{{ profile.handle }}/upvoted">
      <div class="aside__item {% if currentPage == 'upvoted' %}item-selected{% endif %}"><p>Upvoted</p></div>
    </a>
    <a href="/user/{{ profile.handle }}/subscribed">
      <div class="aside__item {% if currentPage == 'subscribed' %}item-selected{% endif %}"><p>Subscribed</p></div>
    </a>
    <a href="/user/{{ profile.handle }}/created">
      <div class="aside__item {% if currentPage == 'created' %}item-selected{% endif %}"><p>Created</p></div>
    </a>
    <a href="/user/{{ profile.handle }}/contributed">
      <div class="aside__item {% if currentPage == 'contributed' %}item-selected{% endif %}"><p>Contributed</p></div>
    </a>
    {% if auth.loggedIn() and auth.getUserId() == profile.id %}
    <a href="/user/{{ profile.handle }}/history">
      <div class="aside__item {% if currentPage == 'history' %}item-selected{% endif %}"><p>History</p></div>
    </a>
    {% endif %}
  </aside>
  <aside class="aside aside--profile">
    <a href="/user/{{ profile.handle }}/followers">
      <div class="aside__item {% if currentPage == 'followers' %}item-selected{% endif %}"><p>Followers</p></div>
    </a>
    <a href="/user/{{ profile.handle }}/following">
      <div class="aside__item {% if currentPage == 'following' %}item-selected{% endif %}"><p>Following</p></div>
    </a>
  </aside>
</div>
