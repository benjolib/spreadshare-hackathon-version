{% extends 'layouts/main.volt' %}

{# page title #}
{% block title %}SpreadShare - Data that matters.{% endblock %}

{# page header #}
{% block header %}{% endblock %}

{# main section #}
{% block content %}

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
              <li class="{% if activeDateFilter == 'today' %}link-active{% endif %}"><a href="/tables/{{ order }}/today">Today</a></li>
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
            {{ partial('tables/tables') }}
        </div>

        <div class="page-load-status">
            <p class="loading infinite-scroll-request"></p>
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
    if ($referenceElement.length) {
      var $onPopper = $('.dropdown--filters');

      var createPopper = function (ref, pop, place) {
          if (!ref) {
              ref = $referenceElement;
          }
          if (!pop) {
              pop = $onPopper;
          }
          if (!place) {
              place = 'bottom';
          }
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
    }

    // Load cards for infinite scrolls
    var $container = $('.tables__content__main__cards').infiniteScroll({
      path: function () {
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
              button.find('.chevronUp').find('svg').find('.fillColor').removeClass('white');
              span.text(parseInt(parseInt(span.text()) - 1));
            }
          },
        });

        return document.location.href + '?page=' + pageNumber;
      },
      responseType: 'document',
      append: '.tableCard',
      status: '.page-load-status',
      history: 'push',
      debug: true,
      scrollThreshold: 400
    });

    // stop load on scroll if no results are found
    $container.on('load.infiniteScroll', function (event, response) {
      //disable loadOnScroll
      if (response.getElementById("no-results")) {
        $container.infiniteScroll('option', { loadOnScroll: false })
      }
    });
  });
</script>
{% endblock %}
