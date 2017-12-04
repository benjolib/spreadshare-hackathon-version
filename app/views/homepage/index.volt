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
  <h1>Collective Research</h1>
  <h2>Crowd-sourced data creation on the blockchain.</h2>
  <p><a data-show="main__hero__tables" class="button" href="javascript:;">🔮 Learn more</a></p>
  <div class="pages main__hero__tables hidden">
    <div>
      <h3>Tables</h3>
      <h4>We believe in public tables as a format for collecting and distributing information</h4>
      <p><a data-show="main__hero__collaboration" class="button blue" href="javascript:;">Next</a></p>
      <p class="page">1 | 7</p>
    </div>
    <span class="circle"></span>
  </div>
  <div class="pages main__hero__collaboration hidden">
    <div>
      <h3>Collaboration</h3>
      <h4>Collective research through crowd-sourced data creation</h4>
      <p>
        <a data-show="main__hero__open_data" class="button blue" href="javascript:;">Next</a>
      </p>
      <p class="page">2 | 7</p>
    </div>
    <span class="circle"></span>
  </div>
  <div class="pages main__hero__open_data hidden">
    <div>
      <h3>Open Data</h3>
      <h4>Access to our data is and will always be free</h4>
      <p>
        <a data-show="main__hero__disciplines" class="button blue" href="javascript:;">Next</a>
      </p>
      <p class="page">3 | 7</p>
    </div>
    <span class="circle"></span>
  </div>
  <div class="pages main__hero__disciplines hidden">
    <div>
      <h3>Disciplines</h3>
      <h4>All from Business over Code to Design and Finance</h4>
      <p>
        <a data-show="main__hero__ownership" class="button blue" href="javascript:;">Next</a>
      </p>
      <p class="page">4 | 7</p>
    </div>
    <span class="circle"></span>
  </div>
  <div class="pages main__hero__ownership hidden">
    <div>
      <h3>Ownership</h3>
      <h4>We want SpreadShare to be owned by our contributors</h4>
      <p>
        <a data-show="main__hero__token" class="button blue" href="javascript:;">Next</a>
      </p>
      <p class="page">5 | 7</p>
    </div>
    <span class="circle"></span>
  </div>
  <div class="pages main__hero__token hidden">
    <div>
      <h3>Tokens</h3>
      <h4>Tokens can be earned by creating content users appreciate</h4>
      <p>
        <a data-show="main__hero__autonomy" class="button blue" href="javascript:;">Next</a>
      </p>
      <p class="page">6 | 7</p>
    </div>
    <span class="circle"></span>
  </div>
  <div class="pages main__hero__autonomy hidden">
    <div>
      <h3>Autonomy</h3>
      <h4>We are building a structure which allows our platform to work autonomously</h4>
      <p><a data-show="" class="button blue" href="javascript:;">🙏</a></p>
      <p class="page">7 | 7</p>
    </div>
    <span class="circle"></span>
  </div>
</div>

<form method="GET" id="sidebarForm">
  {# content #}
  <div class="container container--home">
    {# tables content #}
    <div class="container__content">
      {# filters #}
      <div class="main__content__tables__filters">
        <div class="main__content__tables__filters__left">
          <li>{{ activeDateRangeString }}</li>
          <img src="/assets/icons/chevron-down-dark.svg" />
          <div class="dropdown dropdown--filters">
            <ul>
              <li class="{% if activeDateFilter == 'today' %}link-active{% endif %}"><a href="/tables/{{ order }}/">Today</a></li>
              <li class="{% if activeDateFilter == 'yesterday' %}link-active{% endif %}"><a href="/tables/{{ order }}/yesterday">Yesterday</a></li>
              <li class="{% if activeDateFilter == 'last-week' %}link-active{% endif %}"><a href="/tables/{{ order }}/last-week">Last week</a></li>
              <li class="{% if activeDateFilter == 'last-30-days' %}link-active{% endif %}"><a href="/tables/{{ order }}/last-30-days">Last 30 Days</a></li>
              <li class="{% if activeDateFilter == 'last-90-days' %}link-active{% endif %}"><a href="/tables/{{ order }}/last-90-days">Last 90 Days</a></li>
              <li class="{% if activeDateFilter == 'last-year' %}link-active{% endif %}"><a href="/tables/{{ order }}/last-year">Last Year</a></li>
              <li class="{% if activeDateFilter == 'all-time' %}link-active{% endif %}"><a href="/tables/{{ order }}/all-time">All Time</a></li>
            </ul>
          </div>
        </div>
        <div class="main__content__tables__filters__right">
          <li class="{% if order is 'newest' %}link-active{% endif %}"><a href="/tables/newest/{{ activeDateFilter }}">Newest</a></li>
          <li class="{% if order is 'most-upvoted' %}link-active{% endif %}"><a href="/tables/most-upvoted/{{ activeDateFilter }}">Upvotes</a></li>
          <li class="{% if order is 'most-viewed' %}link-active{% endif %}"><a href="/tables/most-viewed/{{ activeDateFilter }}">Views</a></li>
          <li class="{% if order is 'most-contributed' %}link-active{% endif %}"><a href="/tables/most-contributed/{{ activeDateFilter }}">Contributions</a></li>
        </div>
      </div>

      {# cards #}
      <div class="tables__content__main__cards">
        {{ partial('homepage/tables') }}
      </div>

      <div class="page-load-status">
       <div class="loading"></div>
      </div>

    </div>


    {# sidebar wrapper #}
    <div class="aside__wrapper">
      {# sidebar 1 #}
      <aside class="aside aside--home" id="filterByTopic">
        <div class="main__content__sidebar__option" id="topicFilter">
          <span>Filter by Topic</span>
        </div>
        <ul class="filter open filter--topic {% if sidebarFilter.topic %}open{% endif %}">
          <li>
            <label {% if sidebarFilter.topic== "" %}class="selected"{% endif %}>
            <input type="radio" name="topic" {% if sidebarFilter.topic== "" %}checked="checked"{% endif %} value="" /> All
            </label>
          </li>
          {% for topic in topics %}
          <li>
            <label {% if sidebarFilter.topic== topic.id %}class="selected" {% endif %} title="{{ topic.title|e }}">
              <input type="radio" name="topic" {% if sidebarFilter.topic== topic.id %}checked="checked" {% endif %} value="{{ topic.id }}" /> {{ topic.title|e }}
            </label>
          </li>
          {% endfor %}
        </ul>
      </aside>

      {# sidebar 2 #}
      <aside class="aside aside--home" id="filterByType">
        <div class="main__content__sidebar__option" id="typeFilter">
          <span>Filter by Table Type</span>
        </div>
        <ul class="filter open filter--type {% if sidebarFilter.type %}open{% endif %}">
          <li>
            <label {% if sidebarFilter.type== "" %}class="selected"{% endif %}>
            <input type="radio" name="type" {% if sidebarFilter.type== "" %}checked="checked"{% endif %} value="" />All</label>
          </li>
          {% for type in types %}
          <li>
            <label {% if sidebarFilter.type== type.id %}class="selected" {% endif %} title="{{ type.title|e }}">
              <input type="radio" name="type" {% if sidebarFilter.type== type.id %}checked="checked" {% endif %} value="{{ type.id }}" /> {{ type.title|e }}
            </label>
          </li>
          {% endfor %}
        </ul>
      </aside>

      {# sidebar 3 #}
      <aside class="aside aside--home" id="filterByTags">
        <div class="main__content__sidebar__option" id="tagFilter">
          <span>Filter by Tags</span>
        </div>
        <div id="TagsSelect" data-name="tags[]" data-value="{{ reactArray(filteredTags) }}" data-submit-form-on-change="sidebarForm" data-placeholder="" class="react-component"></div>
      </aside>

      {# sidebar 4 #}
      <aside class="aside aside--home" id="filterByLocation">
        <div class="main__content__sidebar__option" id="locationFilter">
          <span>Filter by location</span>
        </div>
        <div id="LocationSelect" data-name="locations[]" data-value="{{ reactArray(filteredLocations) }}" data-submit-form-on-change="sidebarForm" data-placeholder=""
           class="react-component"></div>
      </aside>
    </div>
  </div>
</form>
{% endblock %}

{% block scripts %}
<script type="text/javascript">
  $(document).ready(function () {
  $('.main__hero a.button').click(function (ev) {
    var show = ev.target.getAttribute('data-show');

    $('.pages').addClass('hidden');

    if (show) {
    $('.white-overlay').show();
    $('.' + show).removeClass('hidden');
    } else {
    $('.white-overlay').hide();
    }
  });

  $('#sidebarForm ul.filter > li > label').on('change', function (ev) {
    document.getElementById('sidebarForm').submit();
  });

  $('.upvote').on('click', function () {
    $svg = $(this).find('.chevronUp').find('svg').find('path');
    $svg.attr('fill', '#B1BBC7');
    $svg.toggleClass('white');
  });
  });

  // $('.navbar__search__filter').on('click', function () {
  // 	$('.filter').toggleClass('open');
  // 	window.location.hash = "#filters";
  // });

  // $('#topicFilter').on('click', function () {
  // 	$('.filter--topic').toggleClass('open');
  // });

  // $('#typeFilter').on('click', function () {
  // 	$('.filter--type').toggleClass('open');
  // });

  $('#closeHero').on('click', function () {
  $('.main__hero').css('display', 'none');
  createPopper();
  createPopper($('.navbar__search__filter'), $('.dropdown--notifications'));
  });

  /* Popper */
  var $referenceElement = $('.main__content__tables__filters__left');
  var $onPopper = $('.dropdown--filters');

  var createPopper = function (ref = $referenceElement, pop = $onPopper, place = 'bottom') {
  new Popper(ref, pop, {
    placement: place,
  });
  };

  new Popper($referenceElement, $onPopper, {
  placement: 'bottom',
  });

  $referenceElement.click(function () {
  $onPopper.toggleClass('show');
  });

  // Load cards for infinite scrolls
  var $container = $('.tables__content__main__cards').infiniteScroll({
    path: function() {
      var pageNumber = (this.loadCount + 1);

      $('.upvote').on('click', function () {
        $svg = $(this).find('.chevronUp').find('svg').find('path');
        $svg.attr('fill', '#B1BBC7');
        $svg.toggleClass('white');
      });

      $('div.upvote, button.upvote').api({
        method: 'POST',
        onSuccess: function (response, button) {
          var span = button.find('span');
          if (response.data.voted) {
            button.addClass('selected');
            button.find('.chevronUp').find('svg').find('.fillColor').addClass('white');
            span.text(parseInt(parseInt(span.text()) + 1));
          } else {
            button.removeClass('selected');
            span.text(parseInt(parseInt(span.text()) - 1));
          }
        },
      });

      return window.location.href + '?page=' + pageNumber;
    },
    responseType: 'document',
    append: '.tableCard',
    status: '.page-load-status',
    request: '.loading',
    history: false,
    debug: false,
    scrollThreshold: 300
  });

 // stop load on scroll if no results are found
 $container.on( 'load.infiniteScroll', function( event, response ) {
   //disable loadOnScroll
   if (response.getElementById("no-results")) {
    $container.infiniteScroll('option', { loadOnScroll: false })
   }
 });
</script>
{% endblock %}
