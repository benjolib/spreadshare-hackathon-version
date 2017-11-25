{% extends 'layouts/main.volt' %}

{# page title #}
{% block title %}SpreadShare - Community curated Tables{% endblock %}

{# page header #}
{% block header %}{% endblock %}

{# main section #}
{% block content %}
{# hero #}
<div class="main__hero">
  <p>Collaborate with and get rewarded by the community</p>
  <h2>A marketplace for community-curated tables in the blockchain</h2>
</div>
{# content #}
<div class="main__content">
  {# tables content #}
  <div class="main__content__tables">
    {# filters #}
    <div class="main__content__tables__filters">
      <div class="main__content__tables__filters__left">
        <li>Today</li>
        <img src="/assets/icons/chevron-down.svg" />
      </div>
      <div class="main__content__tables__filters__right">
        <img src="/assets/icons/clock.svg" />
        <li class="{% if order is 'newly-added' %}selected{% endif %}"><a href="/tables/newly-added">Newly Added</a></li>
        <img src="/assets/icons/upvote.svg" />
        <li class="{% if order is 'most-upvoted' %}selected{% endif %}"><a href="/tables/most-upvoted">Most Upvoted</a></li>
        <img src="/assets/icons/eye.svg" />
        <li class="{% if order is 'most-viewed' %}selected{% endif %}"><a href="/tables/most-viewed">Most Viewed</a></li>
        <img src="/assets/icons/comment.svg" />
        <li class="{% if order is 'most-contributed' %}selected{% endif %}"><a href="/tables/most-contributed">Most Contributed</a></li>
      </div>
    </div>

    {# cards #}
    <div class="tables__content__main__cards">
      {% for table in tables %}
      {{ partial('partials/table') }}
      {% endfor %}
    </div>

  </div>
  {# sidebar #}
  <form method="GET" id="sidebarForm">
    <div class="main__content__sidebar">
      <div class="main__content__sidebar__option">
        <span>Filter by topic</span><img src="/assets/icons/chevron-down.svg" />
      </div>
      <ul class="filter">
        <li>
          <label {% if filter['topic'] == "" %}class="selected"{% endif %}>
          <input type="radio" name="topic" checked="checked" value="" /> All
          </label>
        </li>
        {% for topic in topics %}
        <li>
          <label {% if filter['topic'] == topic.id %}class="selected"{% endif %} title="{{ topic.title|e }}">
          <input type="radio" name="topic" checked="checked" value="{{ topic.id }}" /> {{ topic.title|e }}
          </label>
        </li>
        {% endfor %}
      </ul>

      <div class="main__content__sidebar__option">
        <span>Filter by Table Type</span><img src="/assets/icons/chevron-down.svg" />
      </div>
      <ul class="filter">
        <li>
          <label {% if filter['type'] == "" %}class="selected"{% endif %}>
          <input type="radio" name="type" checked="checked" value="" /> All
          </label>
        </li>
        {% for type in types %}
        <li>
          <label {% if filter['type'] == type.id %}class="selected"{% endif %} title="{{ type.title|e }}">
          <input type="radio" name="type" checked="checked" value="{{ type.id }}" /> {{ type.title|e }}
          </label>
        </li>
        {% endfor %}
      </ul>
    </div>
    <div class="main__content__sidebar__option">
      <span>Filter by Tags</span><img src="/assets/icons/chevron-down.svg" />
    </div>
    <div class="main__content__sidebar__option">
      <span>Filter by location</span><img src="/assets/icons/chevron-down.svg" />

      <div id="LocationSelect" data-name="locations[]" data-value="{{ filter.locations }}" data-placeholder="" class="react-component"></div>
    </div>
  </form>
</div>
{% endblock %}

{% block scripts %}
<script type="text/javascript">
  $(document).ready(function () {
    $('#sidebarForm > div > ul > li > label').on('change', function (ev) {
      document.getElementById('sidebarForm').submit();
    });
  });
</script>
{% endblock %}
