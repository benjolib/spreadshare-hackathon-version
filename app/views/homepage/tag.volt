{% extends 'layouts/main.volt' %} {# page title #} {% block title %}SpreadShare - Data that matters.{% endblock %} {# page
header #} {% block header %}{% endblock %} {# main section #} {% block content %}
<div class="re-page re-page--large">
  <div class="homepage-space">
    <h1 class="re-heading">Explore!</h1>
    <h2 class="re-subheading re-subheading--button-below">We curate the best Streams for you every day</h2>
  </div>

  <div class="home-heading u-flex">
        <div class="selected-topics__items">
        <a href="javascript:history.back()">
        
        {% for featuredTag in featuredTags %} 
        {% if featuredTag['id'] == tag %}
        <div>{{ featuredTag['title'] }} x</div>
        {% endif %} {% endfor %}
        </a>
      </div>
  </div>



  {#
  <div class="home-heading u-flex">
    <div class="home-heading__text home-heading-button clickable l-button" data-dropdown-placement="bottom-start" data-dropdown-target=".home-heading-dropdown">
      {{ selectionName }}
      <img src="/assets/images/home-arrow-down.svg" />
    </div>
    <div class="home-heading__line u-flexGrow1">
      {% if selection === 'san-francisco' or selection === 'new-york' or selection === 'london' or selection === 'berlin' %}
      <div class="home-secondary-filters-desktop">
        <a href="/explore/{{ selection }}/recommended" class="{% if secondSelection is 'recommended' %}active{% endif %}">Recommended</a>
        <a href="/explore/{{ selection }}/trending" class="{% if secondSelection is 'trending' %}active{% endif %}">Trending</a>
        <a href="/explore/{{ selection }}/newest" class="{% if secondSelection is 'newest' %}active{% endif %}">Newest</a>
      </div>
      <div class="home-secondary-filters-mobile">
        <div class="l-button button">{{ secondSelectionName }}
          <img src="/assets/images/home-arrow-down.svg" />
        </div>
        <div class="l-dropdown dropdown secondary-filter-dropdown">
          <a href="/explore/{{ selection }}/recommended" class="{% if secondSelection is 'recommended' %}active{% endif %}">Recommended</a>
          <a href="/explore/{{ selection }}/trending" class="{% if secondSelection is 'trending' %}active{% endif %}">Trending</a>
          <a href="/explore/{{ selection }}/newest" class="{% if secondSelection is 'newest' %}active{% endif %}">Newest</a>
        </div>
      </div>
      {% endif %}
    </div>
  </div>
  <div class="l-dropdown dropdown u-flex home-heading-dropdown">
    <div class="u-flex u-flexCol home-heading-dropdown__col1">
      <a href="/" class="{% if selection is 'recommended' %}active{% endif %}">
        <div>
          <img src="/assets/images/diamond{% if selection is 'recommended' %}-green{% endif %}.svg" />
        </div>Recommended</a>
      <a href="/explore/trending" class="{% if selection is 'trending' %}active{% endif %}">
        <div>
          <img src="/assets/images/lightning{% if selection is 'trending' %}-green{% endif %}.svg" />
        </div>Trending</a>
      <a href="/explore/recently-added" class="{% if selection is 'recently-added' %}active{% endif %}">
        <div>
          <img src="/assets/images/clock{% if selection is 'recently-added' %}-green{% endif %}.svg" />
        </div>Recently Added</a>
      <a href="/explore/most-viewed" class="space-below {% if selection is 'most-viewed' %}active{% endif %}">
        <div>
          <img src="/assets/images/eye{% if selection is 'most-viewed' %}-green{% endif %}.svg" class="icon-eye" />
        </div>Most Viewed</a>

      <a href="/explore/san-francisco" class="{% if selection is 'san-francisco' %}active{% endif %}">
        <div>
          <img src="/assets/images/waypoint{% if selection is 'san-francisco' %}-green{% endif %}.svg" />
        </div>San Francisco</a>
      <a href="/explore/new-york" class="{% if selection is 'new-york' %}active{% endif %}">
        <div>
          <img src="/assets/images/waypoint{% if selection is 'new-york' %}-green{% endif %}.svg" />
        </div>New York</a>
      <a href="/explore/london" class="{% if selection is 'london' %}active{% endif %}">
        <div>
          <img src="/assets/images/waypoint{% if selection is 'london' %}-green{% endif %}.svg" />
        </div>London</a>
      <a href="/explore/berlin" class="{% if selection is 'berlin' %}active{% endif %}">
        <div>
          <img src="/assets/images/waypoint{% if selection is 'berlin' %}-green{% endif %}.svg" />
        </div>Berlin</a>
      <a href="#" class="greyed-out">
        <div>
          <img src="/assets/images/waypoint.svg" />
        </div>City missing?</a>
    </div>
    <div class="u-flex u-flexCol u-md-flexRow">
      <div class="u-flex u-flexCol home-heading-dropdown__col2">
        <a href="/explore/ai" class="{% if selection is 'ai' %}active{% endif %}">AI</a>
        <a href="/explore/blockchain" class="{% if selection is 'blockchain' %}active{% endif %}">Blockchain</a>
        <a href="/explore/bots" class="{% if selection is 'bots' %}active{% endif %}">Bots</a>
        <a href="/explore/business" class="{% if selection is 'business' %}active{% endif %}">Business</a>
        <a href="/explore/crypto" class="{% if selection is 'crypto' %}active{% endif %}">Crypto</a>
        <a href="/explore/culture" class="{% if selection is 'culture' %}active{% endif %}">Culture</a>
        <a href="/explore/design" class="{% if selection is 'design' %}active{% endif %}">Design</a>
        <a href="/explore/engineering" class="{% if selection is 'engineering' %}active{% endif %}">Engineering</a>
        <a href="/explore/finance" class="{% if selection is 'finance' %}active{% endif %}">Finance</a>
        <a href="/explore/fundraising" class="{% if selection is 'fundraising' %}active{% endif %}">Fundraising</a>
        <a href="/explore/growth" class="{% if selection is 'growth' %}active{% endif %}">Growth</a>
      </div>
      <div class="u-flex u-flexCol home-heading-dropdown__col3">
        <a href="/explore/hiring" class="{% if selection is 'hiring' %}active{% endif %}">Hiring</a>
        <a href="/explore/marketing" class="{% if selection is 'marketing' %}active{% endif %}">Marketing</a>
        <a href="/explore/media" class="{% if selection is 'media' %}active{% endif %}">Media</a>
        <a href="/explore/operations" class="{% if selection is 'operations' %}active{% endif %}">Operations</a>
        <a href="/explore/people" class="{% if selection is 'people' %}active{% endif %}">People</a>
        <a href="/explore/press" class="{% if selection is 'press' %}active{% endif %}">Press</a>
        <a href="/explore/product" class="{% if selection is 'product' %}active{% endif %}">Product</a>
        <a href="/explore/research" class="{% if selection is 'research' %}active{% endif %}">Research</a>
        <a href="/explore/tech" class="{% if selection is 'tech' %}active{% endif %}">Tech</a>
        <a href="/explore/everything-else" class="{% if selection is 'everything-else' %}active{% endif %}">Everything else</a>
      </div>
    </div>
  </div> #}

    </div>
  <div class="u-flex u-flexWrap homepage-gutter home-top-margin-bottom"></div>
    {% set qty = 0 %}
 {% set partialindex=0 %}
    {% for index, table in tables %}
    {% if qty < 5 %}
    {% if tables[index] is defined %}



{% set qty= qty+1 %}
{% set partialindex=index %}
{{ partial( 'partials/list-card', [ 'id': tables[index][ 'id'], 'slug': tables[index][ 'slug'],
  'image': tables[index][
      'image'], 'name': tables[index][ 'title'], 'description': tables[index][ 'tagline'], 'subscriberCount': tables[index][
      'subscriberCount'], 'listingCount': tables[index][ 'listingCount'], 'showCurator': true, 'curatorHandle': tables[index][
      'creatorHandle'], 'curatorAvatar': tables[index][ 'creatorImage'], 'curatorName': tables[index][ 'creator'], 'curatorBio': tables[index][
      'creatorBio'], 'half': false, 'large': false ]) }}



      {% endif %}

      {% if subcribedbox is not defined %}
      {% if qty == 3 %}
      {% set subcribedbox=1 %}
    <div class="u-flex u-flexWrap homepage-gutter">
        {{ partial('partials/action-card', [ 'color': 'orange-bird', 'heading': 'Subscribe', 'text': 'Subscribe to your favorite
        topics and collections.
        <br />
        <br />Because you want to keep track of relevant updates', 'action': '/subscriptions', 'buttonText': 'Manage Subscriptions'
        ]) }}
        {% endif %}
         {% endif %}
      {% endif %}

      {% endfor %}


    </div>
      </div>
  </div>

  <div class="trending-topics">
    <div class="trending-topics__inner">
      <h3>Trending Tags</h3>
      <div class="trending-topics__items">
        {% for featuredTag in featuredTags %}
<a href="/tag/{{ featuredTag['id'] }}">
  <div>
  {{ featuredTag['title'] }}
</div>
</a>
        {% endfor %}

      </div>
    </div>
  </div>
  <div class="re-page re-page--large">
    <div class="u-flex u-flexWrap homepage-gutter">
      {{ partial('partials/action-card', [ 'color': 'purple-whale', 'heading': 'Curate', 'text': 'Curate collections and publications.
      <br />
      <br />Because you want your curation to spread.', 'action': '/subscriptions', 'buttonText': 'Manage Subscriptions' ]) }}
      {{ partial('partials/action-card', [ 'color': 'blue-octopus', 'heading': 'Collaborate', 'text': 'Collaborate with your
      favorite curators.
      <br />
      <br />Because you want to get endorsed by trusted experts.', 'action': '/subscriptions', 'buttonText': 'Manage Subscriptions'
      ]) }} {{ partial('partials/action-card', [ 'color': 'green-lightning', 'heading': 'Spread', 'text': 'Spread the best
      content with your followers.
      <br />
      <br />Because you want your peers to be as informed as you are.', 'action': '/subscriptions', 'buttonText': 'Manage Subscriptions'
      ]) }}


    {% set qty = 0 %}
    {% for index, table in tables %}
    {% if index > partialindex %}
    {% if tables[index] is defined %}


    {% set qty= qty+1 %}
    {% if qty <= 12 %}
    {% set partialindex=index %}
      {{ partial( 'partials/list-card', [ 'id': tables[index][ 'id'], 'slug': tables[index][ 'slug'],
      'image': tables[index][
      'image'], 'name': tables[index][ 'title'], 'description': tables[index][ 'tagline'], 'subscriberCount': tables[index][
      'subscriberCount'], 'listingCount': tables[index][ 'listingCount'], 'showCurator': true, 'curatorHandle': tables[index][
      'creatorHandle'], 'curatorAvatar': tables[index][ 'creatorImage'], 'curatorName': tables[index][ 'creator'], 'curatorBio': tables[index][
      'creatorBio'], 'half': false, 'large': false ]) }}


      {% endif %}
      {% endif %}
      {% endif %}

      {% endfor %}


    </div>
  </div>
  <div class="featured-curators">
    <div class="featured-curators__inner">


      <h3>Featured Curators</h3>

<div class="u-flex u-sm-flexWrap">
 {% for index, featuredCurator in featuredCurators %}
{% set index= index+1 %}

 {{ partial('partials/profile-card', [ 'id': featuredCurator['id'], 'username': featuredCurator['name'], 'avatar': featuredCurator["image"]
, 'name': featuredCurator["name"] , 'bio': featuredCurator["tagline"] ,'type': 4 ]) }}




{% if index % 4 == 0 %}


</div>
<div class="u-flex">


  {% endif %}


{% endfor %}


      </div>
    </div>
  </div>



  <div class="re-page re-page--large">
    <div class="u-flex u-flexWrap homepage-gutter">
      {% set qty = 0 %}
    {% for index, table in tables %}
    {% if index > partialindex %}
    {% if tables[index] is defined %}


    {% set qty= qty+1 %}
    {% if qty <= 12 %}
    {% set partialindex=index %}
      {{ partial( 'partials/list-card', [ 'id': tables[index][ 'id'], 'slug': tables[index][ 'slug'],
      'image': tables[index][
      'image'], 'name': tables[index][ 'title'], 'description': tables[index][ 'tagline'], 'subscriberCount': tables[index][
      'subscriberCount'], 'listingCount': tables[index][ 'listingCount'], 'showCurator': true, 'curatorHandle': tables[index][
      'creatorHandle'], 'curatorAvatar': tables[index][ 'creatorImage'], 'curatorName': tables[index][ 'creator'], 'curatorBio': tables[index][
      'creatorBio'], 'half': false, 'large': false ]) }}


      {% endif %}
      {% endif %}
      {% endif %}

      {% endfor %}
    </div>
    <div class="u-flex u-flexWrap homepage-gutter load-more-container"></div>
    <div class="u-flex u-flexJustifyCenter">
      <a href="#" class="re-button re-button--load-more" {{ moreToLoad ? '' : 'style="display:none;"' }}>Load More</a>
    </div>
  </div>

  {#
  <form method="GET" id="sidebarForm"> #} {# content #} {#
    <div class="container container--home"> #} {# tables content #} {#
      <div class="container__content"> #} {# filters #} {# {{ partial('homepage/tables') }}
        <div class="infinite-scroll-container"></div>

        <div class="page-load-status">
          <div class="loading"></div>
        </div>

      </div> #} {# sidebar wrapper #} {#
      <div class="aside__wrapper"> #} {# sidebar 1 #} {#
        <aside class="aside aside--home" id="filterByTopic">
          <div class="main__content__sidebar__option" id="topicFilter">
            <span>Filter by Topic</span>
          </div>
          <ul class="filter open filter--topic {% if sidebarFilter.topic %}open{% endif %}">
            <li>
              <label {% if sidebarFilter.topic=="" %}class="selected" {% endif %}>
                <input type="radio" name="topic" {% if sidebarFilter.topic=="" %}checked="checked" {% endif %} value="" /> All
              </label>
            </li>
            {% for topic in topics %}
            <li>
              <label {% if sidebarFilter.topic==t opic.id %}class="selected" {% endif %} title="{{ topic.title|e }}">
                <input type="radio" name="topic" {% if sidebarFilter.topic==t opic.id %}checked="checked" {% endif %} value="{{ topic.id }}"
                /> {{ topic.title|e }}
              </label>
            </li>
            {% endfor %}
          </ul>
        </aside> #} {# sidebar 2 #} {#
        <aside class="aside aside--home" id="filterByType">
          <div class="main__content__sidebar__option" id="typeFilter">
            <span>Filter by Table Type</span>
          </div>
          <ul class="filter open filter--type {% if sidebarFilter.type %}open{% endif %}">
            <li>
              <label {% if sidebarFilter.type=="" %}class="selected" {% endif %}>
                <input type="radio" name="type" {% if sidebarFilter.type=="" %}checked="checked" {% endif %} value="" />All</label>
            </li>
            {% for type in types %}
            <li>
              <label {% if sidebarFilter.type==t ype.id %}class="selected" {% endif %} title="{{ type.title|e }}">
                <input type="radio" name="type" {% if sidebarFilter.type==t ype.id %}checked="checked" {% endif %} value="{{ type.id }}"
                /> {{ type.title|e }}
              </label>
            </li>
            {% endfor %}
          </ul>
        </aside> #} {# sidebar 3 #} {#
        <aside class="aside aside--home" id="filterByTags">
          <div class="main__content__sidebar__option" id="tagFilter">
            <span>Filter by Tags</span>
          </div>
          <div id="TagsSelect" data-name="tags[]" data-value="{{ reactArray(filteredTags) }}" data-submit-form-on-change="sidebarForm"
            data-placeholder="" class="react-component"></div>
        </aside> #} {# sidebar 4 #} {#
        <aside class="aside aside--home" id="filterByLocation">
          <div class="main__content__sidebar__option" id="locationFilter">
            <span>Filter by location</span>
          </div>
          <div id="LocationSelect" data-name="locations[]" data-value="{{ reactArray(filteredLocations) }}" data-submit-form-on-change="sidebarForm"
            data-placeholder="" class="react-component"></div>
        </aside>
      </div>
    </div>
  </form> #} {% endblock %} {% block scripts %}
  <script type="text/javascript">
    $(document).ready(function () {
      {#
        /* $('.main__hero a.button').click(function (ev) {
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
            }); */

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

        /* $('#closeHero').on('click', function () {
          $('.main__hero').css('display', 'none');
          createPopper();
          createPopper($('.navbar__search__filter'), $('.sh-dropdown--notifications'));
        }); */

        // Load cards for infinite scrolls
        /* var $container = $('.tables__content__main__cards').infiniteScroll({
          path: function () {
            var pageNumber = (this.pageIndex + 1);

            return '/?page=' + pageNumber;
          },
          append: false,
          status: '.page-load-status',
          request: '.loading',
          history: false,
          debug: false,
          scrollThreshold: 400
        }); */

        /* $('.tables__content__main__cards').data('infiniteScroll').pageIndex = parseInt('{{ loadedUntilPage }}'); */

        // stop load on scroll if no results are found
        /* $container.on('load.infiniteScroll', function (event, response) {
          if (response) {
            $container.infiniteScroll('appendItems', $(response).find('.tables'));
          }
          else {
            // Load more
            console.log('Loading more...')
            $container.infiniteScroll('loadNextPage')
          }

          //disable loadOnScroll
          if (response.getElementById("no-results")) {
            //$container.infiniteScroll('option', { loadOnScroll: false })
          }
        }); */
        #}

      /* new Popper($('.home-heading-button'), $('.home-heading-dropdown'), {
        placement: 'bottom-start'
      });

      $('.home-heading-button').click(function () {
        $('.home-heading-dropdown').toggleClass('show');
      }); */

      var pageNumber = 1;

      $('.re-button--load-more').on('click', function (e) {
        e.preventDefault();
        $.ajax(window.location.pathname + '?page=' + pageNumber)
          .done(function (response) {
            console.log(response);
            if (response) {
              $('.load-more-container').append(response);
              pageNumber += 1;
              if (!$('<div>' + response + '</div>').find('.moreToLoad').val()) {
                $('.re-button--load-more').hide();
              }
            }
          });
      });
    });
  </script>
  {% endblock %}
