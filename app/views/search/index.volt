{% extends 'layouts/main.volt' %}

{# page title #}
{% block title %}SpreadShare - Community curated Tables{% endblock %}

{# page header #}
{% block header %}{% endblock %}

{# main section #}
{% block content %}
<div class="re-page re-page--search">
  {# <div class="search-filter ">
    <div class="search-filter__label">FILTER BY</div>
    <div class="search-filter__dropdowns">
      <div class="search-filter__dropdown-button l-button"  data-dropdown-placement="bottom-start" data-dropdown-active-class="search-filter__dropdown-button--active">
        Topics<img src="/assets/images/dropdown-arrow-up.svg" />
      </div>
      <div class="search-filter__dropdown dropdown l-dropdown">
        <div class="search-filter__dropdown-inner">Topics<img src="/assets/images/dropdown-arrow-down.svg" /></div>
        <div class="search-filter__dropdown-menu u-flex">
          <div class="u-flex u-flexCol search-filter__dropdown-menu__col1">
            <a href="/explore/ai" class="{% if '' is 'ai' %}active{% endif %}">AI</a>
            <a href="/explore/blockchain" class="{% if '' is 'blockchain' %}active{% endif %}">Blockchain</a>
            <a href="/explore/bots" class="{% if '' is 'bots' %}active{% endif %}">Bots</a>
            <a href="/explore/business" class="{% if '' is 'business' %}active{% endif %}">Business</a>
            <a href="/explore/crypto" class="{% if '' is 'crypto' %}active{% endif %}">Crypto</a>
            <a href="/explore/culture" class="{% if '' is 'culture' %}active{% endif %}">Culture</a>
            <a href="/explore/design" class="{% if '' is 'design' %}active{% endif %}">Design</a>
            <a href="/explore/engineering" class="{% if '' is 'engineering' %}active{% endif %}">Engineering</a>
            <a href="/explore/finance" class="{% if '' is 'finance' %}active{% endif %}">Finance</a>
            <a href="/explore/fundraising" class="{% if '' is 'fundraising' %}active{% endif %}">Fundraising</a>
            <a href="/explore/growth" class="{% if '' is 'growth' %}active{% endif %}">Growth</a>
          </div>
          <div class="u-flex u-flexCol search-filter__dropdown-menu__col2">
            <a href="/explore/hiring" class="{% if '' is 'hiring' %}active{% endif %}">Hiring</a>
            <a href="/explore/marketing" class="{% if '' is 'marketing' %}active{% endif %}">Marketing</a>
            <a href="/explore/media" class="{% if '' is 'media' %}active{% endif %}">Media</a>
            <a href="/explore/operations" class="{% if '' is 'operations' %}active{% endif %}">Operations</a>
            <a href="/explore/people" class="{% if '' is 'people' %}active{% endif %}">People</a>
            <a href="/explore/press" class="{% if '' is 'press' %}active{% endif %}">Press</a>
            <a href="/explore/product" class="{% if '' is 'product' %}active{% endif %}">Product</a>
            <a href="/explore/research" class="{% if '' is 'research' %}active{% endif %}">Research</a>
            <a href="/explore/tech" class="{% if '' is 'tech' %}active{% endif %}">Tech</a>
            <a href="/explore/everything-else" class="{% if '' is 'everything-else' %}active{% endif %}">Everything else</a>
          </div>
        </div>
      </div>

      <div class="search-filter__dropdown-button l-button" data-dropdown-placement="bottom" data-dropdown-active-class="search-filter__dropdown-button--active">
        Tags<img src="/assets/images/dropdown-arrow-up.svg" />
      </div>
      <div class="search-filter__dropdown dropdown l-dropdown">
        <div class="search-filter__dropdown-inner">Tags<img src="/assets/images/dropdown-arrow-down.svg" /></div>
        <div class="search-filter__dropdown-menu"></div>
      </div>
    </div>
  </div> #}

  {% if tables is defined AND tables %}
    <table class="re-table">
      <tbody>
        {{ partial('search/content') }}
      </tbody>
    </table>
  {% endif %}
  {# <div class="u-flex u-flexJustifyCenter">
    <a href="#" class="re-button re-button--load-more" {{ moreToLoad ? '' : 'style="display:none;"' }}>Load More</a>
  </div> #}
</div>
{% endblock %}

{% block scripts %}
<script type="text/javascript">
  $(document).ready(function () {
    var pageNumber = 1;

    $('.re-button--load-more').on('click', function (e) {
      e.preventDefault();
      $.ajax(window.location.pathname + '?page=' + pageNumber)
        .done(function (response) {
          if (response) {
            $('.re-table tbody').append(response);
            pageNumber += 1;
            if (!$('<div>' + response + '</div>').find('.moreToLoad').val()) {
              $('.re-button--load-more').hide();
            }
            window.bindPops();
          }
        });
    });
  });
</script>
{% endblock %}
