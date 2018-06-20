{% extends 'layouts/main.volt' %}

{# page title #}
{% block title %}SpreadShare - Data that matters.{% endblock %}

{# page header #}
{% block header %}{% endblock %}

{# main section #}
{% block content %}
{# {{ dump(tables) }} #}
<div class="re-page re-page--large">
  <div class="homepage-space">
    <h1 class="re-heading">Explore</h1>
    <h2 class="re-subheading re-subheading--button-below">We hand-curate the best lists for you every day</h2>
  </div>
  {# <div class="home-heading u-flex">
    <div class="home-heading__text home-heading-button clickable l-button" data-dropdown-placement="bottom-start" data-dropdown-target=".home-heading-dropdown">
      {{ selectionName }}<img src="/assets/images/home-arrow-down.svg" />
    </div>
    <div class="home-heading__line u-flexGrow1">
      {% if selection === 'san-francisco' or selection === 'new-york' or selection === 'london' or selection === 'berlin' %}
        <div class="home-secondary-filters-desktop">
          <a href="/explore/{{ selection }}/recommended" class="{% if secondSelection is 'recommended' %}active{% endif %}">Recommended</a>
          <a href="/explore/{{ selection }}/trending" class="{% if secondSelection is 'trending' %}active{% endif %}">Trending</a>
          <a href="/explore/{{ selection }}/newest" class="{% if secondSelection is 'newest' %}active{% endif %}">Newest</a>
        </div>
        <div class="home-secondary-filters-mobile">
          <div class="l-button button">{{ secondSelectionName }} <img src="/assets/images/home-arrow-down.svg" /></div>
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
      <a href="/" class="{% if selection is 'recommended' %}active{% endif %}"><div><img src="/assets/images/diamond{% if selection is 'recommended' %}-green{% endif %}.svg" /></div>Recommended</a>
      <a href="/explore/trending" class="{% if selection is 'trending' %}active{% endif %}"><div><img src="/assets/images/lightning{% if selection is 'trending' %}-green{% endif %}.svg" /></div>Trending</a>
      <a href="/explore/recently-added" class="{% if selection is 'recently-added' %}active{% endif %}"><div><img src="/assets/images/clock{% if selection is 'recently-added' %}-green{% endif %}.svg" /></div>Recently Added</a>
      <a href="/explore/most-viewed" class="space-below {% if selection is 'most-viewed' %}active{% endif %}"><div><img src="/assets/images/eye{% if selection is 'most-viewed' %}-green{% endif %}.svg" class="icon-eye" /></div>Most Viewed</a>

      <a href="/explore/san-francisco" class="{% if selection is 'san-francisco' %}active{% endif %}"><div><img src="/assets/images/waypoint{% if selection is 'san-francisco' %}-green{% endif %}.svg" /></div>San Francisco</a>
      <a href="/explore/new-york" class="{% if selection is 'new-york' %}active{% endif %}"><div><img src="/assets/images/waypoint{% if selection is 'new-york' %}-green{% endif %}.svg" /></div>New York</a>
      <a href="/explore/london" class="{% if selection is 'london' %}active{% endif %}"><div><img src="/assets/images/waypoint{% if selection is 'london' %}-green{% endif %}.svg" /></div>London</a>
      <a href="/explore/berlin" class="{% if selection is 'berlin' %}active{% endif %}"><div><img src="/assets/images/waypoint{% if selection is 'berlin' %}-green{% endif %}.svg" /></div>Berlin</a>
      <a href="#" class="greyed-out"><div><img src="/assets/images/waypoint.svg" /></div>City missing?</a>
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

  <div class="u-flex u-flexWrap homepage-gutter home-top-margin-bottom">
    {% if tables[0] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[0]['id'],
        'slug': tables[0]['slug'],
        'image': tables[0]['image'],
        'name': tables[0]['title'],
        'description': tables[0]['tagline'],
        'subscriberCount': tables[0]['subscriberCount'],
        'listingCount': tables[0]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[0]['creatorHandle'],
        'curatorAvatar': tables[0]['creatorImage'],
        'curatorName': tables[0]['creator'],
        'curatorBio': tables[0]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}
    {% if tables[1] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[1]['id'],
        'slug': tables[1]['slug'],
        'image': tables[1]['image'],
        'name': tables[1]['title'],
        'description': tables[1]['tagline'],
        'subscriberCount': tables[1]['subscriberCount'],
        'listingCount': tables[1]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[1]['creatorHandle'],
        'curatorAvatar': tables[1]['creatorImage'],
        'curatorName': tables[1]['creator'],
        'curatorBio': tables[1]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}
    {% if tables[2] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[2]['id'],
        'slug': tables[2]['slug'],
        'image': tables[2]['image'],
        'name': tables[2]['title'],
        'description': tables[2]['tagline'],
        'subscriberCount': tables[2]['subscriberCount'],
        'listingCount': tables[2]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[2]['creatorHandle'],
        'curatorAvatar': tables[2]['creatorImage'],
        'curatorName': tables[2]['creator'],
        'curatorBio': tables[2]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}
  </div>
  <div class="u-flex u-flexWrap homepage-gutter">
    {{ partial('partials/action-card', [
      'color': 'orange-bird',
      'heading': 'Subscribe',
      'text': 'Subscribe to your favorite topics and collections.<br /><br />Because you want to keep track of relevant updates',
      'action': '/subscriptions',
      'buttonText': 'Manage Subscriptions'
    ]) }}
    {% if tables[3] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[3]['id'],
        'slug': tables[3]['slug'],
        'image': tables[3]['image'],
        'name': tables[3]['title'],
        'description': tables[3]['tagline'],
        'subscriberCount': tables[3]['subscriberCount'],
        'listingCount': tables[3]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[3]['creatorHandle'],
        'curatorAvatar': tables[3]['creatorImage'],
        'curatorName': tables[3]['creator'],
        'curatorBio': tables[3]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}
    {% if tables[4] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[4]['id'],
        'slug': tables[4]['slug'],
        'image': tables[4]['image'],
        'name': tables[4]['title'],
        'description': tables[4]['tagline'],
        'subscriberCount': tables[4]['subscriberCount'],
        'listingCount': tables[4]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[4]['creatorHandle'],
        'curatorAvatar': tables[4]['creatorImage'],
        'curatorName': tables[4]['creator'],
        'curatorBio': tables[4]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}
  </div>
</div>
<div class="trending-topics">
  <div class="trending-topics__inner">
    <h3>Trending Topics</h3>
    <div class="trending-topics__items">
      <div>UX Design</div>
      <div>Crypto</div>
      <div>Token Curated Registries</div>
      <div>YCombinator</div>
      <div>Venture Capital</div>
      <div>Remote Jobs</div>
      <div>Nomads</div>
      <div>Book Recommendations</div>
      <div>Freebies</div>
      <div>Product Builders</div>
      <div>Decentralisation</div>
      <div>C-Level</div>
      <div>Future of Work</div>
      <div>Silicon Valley</div>
      <div>Prototyping</div>
      <div>Frameworks</div>
      <div>Something Else</div>
      <div>Religion</div>
    </div>
  </div>
</div>
<div class="re-page re-page--large">
  <div class="u-flex u-flexWrap homepage-gutter">
    {{ partial('partials/action-card', [
      'color': 'purple-whale',
      'heading': 'Curate',
      'text': 'Curate collections and publications.<br /><br />Because you want your curation to spread.',
      'action': '/subscriptions',
      'buttonText': 'Manage Subscriptions'
    ]) }}
    {{ partial('partials/action-card', [
      'color': 'blue-octopus',
      'heading': 'Collaborate',
      'text': 'Collaborate with your favorite curators.<br /><br />Because you want to get endorsed by trusted experts.',
      'action': '/subscriptions',
      'buttonText': 'Manage Subscriptions'
    ]) }}
    {{ partial('partials/action-card', [
      'color': 'green-lightning',
      'heading': 'Spread',
      'text': 'Spread the best content with your followers.<br /><br />Because you want your peers to be as informed as you are.',
      'action': '/subscriptions',
      'buttonText': 'Manage Subscriptions'
    ]) }}
    {% if tables[5] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[5]['id'],
        'slug': tables[5]['slug'],
        'image': tables[5]['image'],
        'name': tables[5]['title'],
        'description': tables[5]['tagline'],
        'subscriberCount': tables[5]['subscriberCount'],
        'listingCount': tables[5]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[5]['creatorHandle'],
        'curatorAvatar': tables[5]['creatorImage'],
        'curatorName': tables[5]['creator'],
        'curatorBio': tables[5]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}
    {% if tables[6] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[6]['id'],
        'slug': tables[6]['slug'],
        'image': tables[6]['image'],
        'name': tables[6]['title'],
        'description': tables[6]['tagline'],
        'subscriberCount': tables[6]['subscriberCount'],
        'listingCount': tables[6]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[6]['creatorHandle'],
        'curatorAvatar': tables[6]['creatorImage'],
        'curatorName': tables[6]['creator'],
        'curatorBio': tables[6]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}
    {% if tables[7] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[7]['id'],
        'slug': tables[7]['slug'],
        'image': tables[7]['image'],
        'name': tables[7]['title'],
        'description': tables[7]['tagline'],
        'subscriberCount': tables[7]['subscriberCount'],
        'listingCount': tables[7]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[7]['creatorHandle'],
        'curatorAvatar': tables[7]['creatorImage'],
        'curatorName': tables[7]['creator'],
        'curatorBio': tables[7]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}

    {% if tables[8] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[8]['id'],
        'slug': tables[8]['slug'],
        'image': tables[8]['image'],
        'name': tables[8]['title'],
        'description': tables[8]['tagline'],
        'subscriberCount': tables[8]['subscriberCount'],
        'listingCount': tables[8]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[8]['creatorHandle'],
        'curatorAvatar': tables[8]['creatorImage'],
        'curatorName': tables[8]['creator'],
        'curatorBio': tables[8]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}
    {% if tables[9] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[9]['id'],
        'slug': tables[9]['slug'],
        'image': tables[9]['image'],
        'name': tables[9]['title'],
        'description': tables[9]['tagline'],
        'subscriberCount': tables[9]['subscriberCount'],
        'listingCount': tables[9]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[9]['creatorHandle'],
        'curatorAvatar': tables[9]['creatorImage'],
        'curatorName': tables[9]['creator'],
        'curatorBio': tables[9]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}
    {% if tables[10] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[10]['id'],
        'slug': tables[10]['slug'],
        'image': tables[10]['image'],
        'name': tables[10]['title'],
        'description': tables[10]['tagline'],
        'subscriberCount': tables[10]['subscriberCount'],
        'listingCount': tables[10]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[10]['creatorHandle'],
        'curatorAvatar': tables[10]['creatorImage'],
        'curatorName': tables[10]['creator'],
        'curatorBio': tables[10]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}

    {% if tables[11] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[11]['id'],
        'slug': tables[11]['slug'],
        'image': tables[11]['image'],
        'name': tables[11]['title'],
        'description': tables[11]['tagline'],
        'subscriberCount': tables[11]['subscriberCount'],
        'listingCount': tables[11]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[11]['creatorHandle'],
        'curatorAvatar': tables[11]['creatorImage'],
        'curatorName': tables[11]['creator'],
        'curatorBio': tables[11]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}
    {% if tables[12] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[12]['id'],
        'slug': tables[12]['slug'],
        'image': tables[12]['image'],
        'name': tables[12]['title'],
        'description': tables[12]['tagline'],
        'subscriberCount': tables[12]['subscriberCount'],
        'listingCount': tables[12]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[12]['creatorHandle'],
        'curatorAvatar': tables[12]['creatorImage'],
        'curatorName': tables[12]['creator'],
        'curatorBio': tables[12]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}
    {% if tables[13] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[13]['id'],
        'slug': tables[13]['slug'],
        'image': tables[13]['image'],
        'name': tables[13]['title'],
        'description': tables[13]['tagline'],
        'subscriberCount': tables[13]['subscriberCount'],
        'listingCount': tables[13]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[13]['creatorHandle'],
        'curatorAvatar': tables[13]['creatorImage'],
        'curatorName': tables[13]['creator'],
        'curatorBio': tables[13]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}

    {% if tables[5] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[14]['id'],
        'slug': tables[14]['slug'],
        'image': tables[14]['image'],
        'name': tables[14]['title'],
        'description': tables[14]['tagline'],
        'subscriberCount': tables[14]['subscriberCount'],
        'listingCount': tables[14]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[14]['creatorHandle'],
        'curatorAvatar': tables[14]['creatorImage'],
        'curatorName': tables[14]['creator'],
        'curatorBio': tables[14]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}
    {% if tables[15] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[15]['id'],
        'slug': tables[15]['slug'],
        'image': tables[15]['image'],
        'name': tables[15]['title'],
        'description': tables[15]['tagline'],
        'subscriberCount': tables[15]['subscriberCount'],
        'listingCount': tables[15]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[15]['creatorHandle'],
        'curatorAvatar': tables[15]['creatorImage'],
        'curatorName': tables[15]['creator'],
        'curatorBio': tables[15]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}
    {% if tables[16] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[16]['id'],
        'slug': tables[16]['slug'],
        'image': tables[16]['image'],
        'name': tables[16]['title'],
        'description': tables[16]['tagline'],
        'subscriberCount': tables[16]['subscriberCount'],
        'listingCount': tables[16]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[16]['creatorHandle'],
        'curatorAvatar': tables[16]['creatorImage'],
        'curatorName': tables[16]['creator'],
        'curatorBio': tables[16]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}
  </div>
</div>
<div class="featured-curators">
  <div class="featured-curators__inner">
    <h3>Featured Curators</h3>
    <div class="u-flex">
      {{ partial('partials/profile-card', [
        'id': 1,
        'username': 'andewcoyle',
        'avatar': 'https://cdn-images-1.medium.com/fit/c/100/100/1*iRHlXdQhKPpyNJ0w6f7ijw.jpeg',
        'name': 'Andrew Coyle',
        'bio': 'Designing the future of global trade @Flexport. Curating lists at Spreadshare.',
        'type': 4
      ]) }}
      {{ partial('partials/profile-card', [
        'id': 1,
        'username': 'andewcoyle',
        'avatar': 'https://cdn-images-1.medium.com/fit/c/100/100/1*iRHlXdQhKPpyNJ0w6f7ijw.jpeg',
        'name': 'Andrew Coyle',
        'bio': 'Designing the future of global trade @Flexport. Curating lists at Spreadshare.',
        'type': 4
      ]) }}
      {{ partial('partials/profile-card', [
        'id': 1,
        'username': 'andewcoyle',
        'avatar': 'https://cdn-images-1.medium.com/fit/c/100/100/1*iRHlXdQhKPpyNJ0w6f7ijw.jpeg',
        'name': 'Andrew Coyle',
        'bio': 'Designing the future of global trade @Flexport. Curating lists at Spreadshare.',
        'type': 4
      ]) }}
    </div>
    <div class="u-flex">
      {{ partial('partials/profile-card', [
        'id': 1,
        'username': 'andewcoyle',
        'avatar': 'https://cdn-images-1.medium.com/fit/c/100/100/1*iRHlXdQhKPpyNJ0w6f7ijw.jpeg',
        'name': 'Andrew Coyle',
        'bio': 'Designing the future of global trade @Flexport. Curating lists at Spreadshare.',
        'type': 4
      ]) }}
      {{ partial('partials/profile-card', [
        'id': 1,
        'username': 'andewcoyle',
        'avatar': 'https://cdn-images-1.medium.com/fit/c/100/100/1*iRHlXdQhKPpyNJ0w6f7ijw.jpeg',
        'name': 'Andrew Coyle',
        'bio': 'Designing the future of global trade @Flexport. Curating lists at Spreadshare.',
        'type': 4
      ]) }}
      {{ partial('partials/profile-card', [
        'id': 1,
        'username': 'andewcoyle',
        'avatar': 'https://cdn-images-1.medium.com/fit/c/100/100/1*iRHlXdQhKPpyNJ0w6f7ijw.jpeg',
        'name': 'Andrew Coyle',
        'bio': 'Designing the future of global trade @Flexport. Curating lists at Spreadshare.',
        'type': 4
      ]) }}
    </div>
  </div>
</div>
<div class="re-page re-page--large">
  <div class="u-flex u-flexWrap homepage-gutter">
    {% if tables[17] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[17]['id'],
        'slug': tables[17]['slug'],
        'image': tables[17]['image'],
        'name': tables[17]['title'],
        'description': tables[17]['tagline'],
        'subscriberCount': tables[17]['subscriberCount'],
        'listingCount': tables[17]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[17]['creatorHandle'],
        'curatorAvatar': tables[17]['creatorImage'],
        'curatorName': tables[17]['creator'],
        'curatorBio': tables[17]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}
    {% if tables[18] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[18]['id'],
        'slug': tables[18]['slug'],
        'image': tables[18]['image'],
        'name': tables[18]['title'],
        'description': tables[18]['tagline'],
        'subscriberCount': tables[18]['subscriberCount'],
        'listingCount': tables[18]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[18]['creatorHandle'],
        'curatorAvatar': tables[18]['creatorImage'],
        'curatorName': tables[18]['creator'],
        'curatorBio': tables[18]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}
    {% if tables[19] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[19]['id'],
        'slug': tables[19]['slug'],
        'image': tables[19]['image'],
        'name': tables[19]['title'],
        'description': tables[19]['tagline'],
        'subscriberCount': tables[19]['subscriberCount'],
        'listingCount': tables[19]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[19]['creatorHandle'],
        'curatorAvatar': tables[19]['creatorImage'],
        'curatorName': tables[19]['creator'],
        'curatorBio': tables[19]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}
    {% if tables[20] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[20]['id'],
        'slug': tables[20]['slug'],
        'image': tables[20]['image'],
        'name': tables[20]['title'],
        'description': tables[20]['tagline'],
        'subscriberCount': tables[20]['subscriberCount'],
        'listingCount': tables[20]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[20]['creatorHandle'],
        'curatorAvatar': tables[20]['creatorImage'],
        'curatorName': tables[20]['creator'],
        'curatorBio': tables[20]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}
    {% if tables[21] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[21]['id'],
        'slug': tables[21]['slug'],
        'image': tables[21]['image'],
        'name': tables[21]['title'],
        'description': tables[21]['tagline'],
        'subscriberCount': tables[21]['subscriberCount'],
        'listingCount': tables[21]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[21]['creatorHandle'],
        'curatorAvatar': tables[21]['creatorImage'],
        'curatorName': tables[21]['creator'],
        'curatorBio': tables[21]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}
    {% if tables[22] is defined %}
      {{ partial('partials/list-card', [
        'id': tables[22]['id'],
        'slug': tables[22]['slug'],
        'image': tables[22]['image'],
        'name': tables[22]['title'],
        'description': tables[22]['tagline'],
        'subscriberCount': tables[22]['subscriberCount'],
        'listingCount': tables[22]['listingCount'],
        'showCurator': true,
        'curatorHandle': tables[22]['creatorHandle'],
        'curatorAvatar': tables[22]['creatorImage'],
        'curatorName': tables[22]['creator'],
        'curatorBio': tables[22]['creatorBio'],
        'half': false,
        'large': false
      ]) }}
    {% endif %}
  </div>
  <div class="u-flex u-flexWrap homepage-gutter load-more-container"></div>
  <div class="u-flex u-flexJustifyCenter">
    <a href="#" class="re-button re-button--load-more" {{ moreToLoad ? '' : 'style="display:none;"' }}>Load More</a>
  </div>
</div>

{# <form method="GET" id="sidebarForm"> #}
  {# content #}
  {# <div class="container container--home"> #}

      {# tables content #}
      {# <div class="container__content"> #}
          {# filters #}

          {# {{ partial('homepage/tables') }}
          <div class="infinite-scroll-container"></div>

          <div class="page-load-status">
              <div class="loading"></div>
          </div>

      </div> #}


      {# sidebar wrapper #}
    {# <div class="aside__wrapper"> #}
      {# sidebar 1 #}
      {# <aside class="aside aside--home" id="filterByTopic">
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
      </aside> #}

      {# sidebar 2 #}
      {# <aside class="aside aside--home" id="filterByType">
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
      </aside> #}

      {# sidebar 3 #}
      {# <aside class="aside aside--home" id="filterByTags">
        <div class="main__content__sidebar__option" id="tagFilter">
          <span>Filter by Tags</span>
        </div>
        <div id="TagsSelect" data-name="tags[]" data-value="{{ reactArray(filteredTags) }}" data-submit-form-on-change="sidebarForm" data-placeholder="" class="react-component"></div>
      </aside> #}

      {# sidebar 4 #}
      {# <aside class="aside aside--home" id="filterByLocation">
        <div class="main__content__sidebar__option" id="locationFilter">
          <span>Filter by location</span>
        </div>
        <div id="LocationSelect" data-name="locations[]" data-value="{{ reactArray(filteredLocations) }}" data-submit-form-on-change="sidebarForm" data-placeholder=""
           class="react-component"></div>
      </aside>
    </div>
  </div>
</form> #}
{% endblock %}

{% block scripts %}
<script type="text/javascript">
  $(document).ready(function () {
    {#/* $('.main__hero a.button').click(function (ev) {
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
    }); */#}

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
