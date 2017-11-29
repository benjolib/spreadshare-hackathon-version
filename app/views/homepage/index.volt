{% extends 'layouts/main.volt' %}

{# page title #}
{% block title %}SpreadShare - Community curated Tables{% endblock %}

{# page header #}
{% block header %}{% endblock %}

{# main section #}
{% block content %}
{# hero #}
<div class="main__hero">
  <img src="/assets/icons/close-hero.svg" id="closeHero" />
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
        <img src="/assets/icons/chevron-down-dark.svg" />
        <div class="dropdown dropdown--filters">
          <ul>
            <li class="link-active"><a href="#">Today</a></li>
            <li><a href="#">Yesterday</a></li>
            <li><a href="#">Last week</a></li>
            <li><a href="#">Last 30 Days</a></li>
            <li><a href="#">Last 90 Days</a></li>
            <li><a href="#">Last Year</a></li>
            <li><a href="#">All Time</a></li>
          </ul>
        </div>
      </div>
      <div class="main__content__tables__filters__right">
        <li class="{% if order is 'newly-added' %}link-active{% endif %}"><a href="/tables/newly-added">Newest</a></li>
        <li class="{% if order is 'most-upvoted' %}link-active{% endif %}"><a href="/tables/most-upvoted">Upvotes</a></li>
        <li class="{% if order is 'most-viewed' %}link-active{% endif %}"><a href="/tables/most-viewed">Views</a></li>
        <li class="{% if order is 'most-contributed' %}link-active{% endif %}"><a href="/tables/most-contributed">Contributions</a></li>
      </div>
    </div>

    {# cards #}
    <div class="tables__content__main__cards">
      {% if tables %}
        {% for table in tables %}
        {{ partial('partials/table') }}
        {% endfor %}
      {% else %}
        <div class="tables__content__main__cards__item center" style="padding:40px;">
          <div>
            <img src="/assets/images/desktop.png" alt="" />
            <p>&nbsp;</p>
            <p>We couldn't find any tables matching your search.</p>
            <p>&nbsp;</p>
            <p><a class="button bold" href="/table/add">Create Table</a></p>
          </div>
        </div>
      {% endif %}
    </div>

  </div>
  {# sidebar #}
  <form method="GET" id="sidebarForm">
    <div class="main__content__sidebar" id="filters">
      <div class="main__content__sidebar__option" id="topicFilter">
        <span>Filter by topic</span><img src="/assets/icons/chevron-down.svg" />
      </div>
      <ul class="filter filter--topic {% if sidebarFilter.topic %}open{% endif %}">
        <li>
          <label {% if sidebarFilter.topic == "" %}class="selected"{% endif %}>
          <input type="radio" name="topic" {% if sidebarFilter.topic == "" %}checked="checked"{% endif %} value="" /> All
          </label>
        </li>
        {% for topic in topics %}
        <li>
          <label {% if sidebarFilter.topic == topic.id %}class="selected"{% endif %} title="{{ topic.title|e }}">
          <input type="radio" name="topic" {% if sidebarFilter.topic == topic.id %}checked="checked"{% endif %} value="{{ topic.id }}" /> {{ topic.title|e }}
          </label>
        </li>
        {% endfor %}
      </ul>

      <div class="main__content__sidebar__option" id="typeFilter">
        <span>Filter by Table Type</span><img src="/assets/icons/chevron-down.svg" />
      </div>
      <ul class="filter filter--type {% if sidebarFilter.type %}open{% endif %}">
        <li>
          <label {% if sidebarFilter.type == "" %}class="selected"{% endif %}>
          <input type="radio" name="type" {% if sidebarFilter.type == "" %}checked="checked"{% endif %} value="" /> All
          </label>
        </li>
        {% for type in types %}
        <li>
          <label {% if sidebarFilter.type == type.id %}class="selected"{% endif %} title="{{ type.title|e }}">
          <input type="radio" name="type" {% if sidebarFilter.type == type.id %}checked="checked"{% endif %} value="{{ type.id }}" /> {{ type.title|e }}
          </label>
        </li>
        {% endfor %}
      </ul>

      <div class="main__content__sidebar__option" id="tagFilter">
        <span>Filter by Tags</span><img src="/assets/icons/chevron-down.svg" />
      </div>
      <div id="TagsSelect" data-name="tags[]" data-value="{{ reactArray(filteredTags) }}" data-submit-form-on-change="sidebarForm" data-placeholder="" class="react-component"></div>

      <div class="main__content__sidebar__option" id="locationFilter">
        <span>Filter by location</span><img src="/assets/icons/chevron-down.svg" />
      </div>
      <div id="LocationSelect" data-name="locations[]" data-value="{{ reactArray(filteredLocations) }}" data-submit-form-on-change="sidebarForm" data-placeholder="" class="react-component"></div>
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

  $('.navbar__search__filter').on('click', function() {
    $('.filter').toggleClass('open');
    window.location.hash = "#filters";
  });

  $('#topicFilter').on('click', function() {
    $('.filter--topic').toggleClass('open');
  });

  $('#typeFilter').on('click', function() {
    $('.filter--type').toggleClass('open');
  });

  $('#closeHero').on('click', function() {
    $('.main__hero').css('display', 'none');
    createPopper();
    createPopper($('.navbar__search__filter'), $('.dropdown--notifications'));
  });

  /* Popper */
  var $referenceElement = $('.main__content__tables__filters__left');
  var $onPopper = $('.dropdown--filters');

  var createPopper = function(ref=$referenceElement, pop=$onPopper, place='bottom') {
    new Popper(ref, pop, {
      placement: place,
    });
  };

  new Popper($referenceElement, $onPopper, {
    placement: 'bottom',
  });

  $referenceElement.click(function() {
    $onPopper.toggleClass('show');
  });
</script>
{% endblock %}
