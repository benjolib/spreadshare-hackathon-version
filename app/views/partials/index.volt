{% extends 'layouts/main.volt' %}

{# page title #}
{% block title %}
  <title>SpreadShare</title>
{% endblock %}

{# page header #}
{% block header %}{% endblock %}

{# main section #}
{% block main %}
  <section class="main">
    <div class="main__hero">
      <p>Collaborate with and get rewarded by the community</p>
      <h2>A marketplace for community-curated tables in the blockchain</h2>
    </div>
    <div class="main__content">
      {{ flash.output() }}
      <div class="main__content__tables">
        <div class="main__content__tables__filters">
          <div class="main__content__tables__filters__left">
            <li>Today</li><img src="/assets/icons/chevron-down.svg" />
          </div>
          <div class="main__content__tables__filters__right">
            <img src="/assets/icons/clock.svg" /><li>Newly Added</li>
            <img src="/assets/icons/upvote.svg" /><li>Most Upvoted</li>
            <img src="/assets/icons/eye.svg" /><li>Most Viewed</li>
            <img src="/assets/icons/comment.svg" /><li>Most Contributed</li>
          </div>
        </div>
        <div class="main__content__tables__cards">
        </div>
      </div>
      <div class="main__content__sidebar">
        <div class="main__content__sidebar__option">
          <a>Categories</a><img src="/assets/icons/chevron-down.svg" />
        </div>
        <div class="main__content__sidebar__option">
          <a>Table Type</a><img src="/assets/icons/chevron-down.svg" />
        </div>
        <div class="main__content__sidebar__option">
          <a>Tags</a><img src="/assets/icons/chevron-down.svg" />
        </div>
        <div class="main__content__sidebar__option">
          <a>Geography</a><img src="/assets/icons/chevron-down.svg" />
        </div>
      </div>
    </div>
  </section>
{% endblock %}
