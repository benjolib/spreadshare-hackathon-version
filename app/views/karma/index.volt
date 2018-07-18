{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
<div class="re-page">
  <h1 class="re-heading">Equity</h1>
  <h2 class="re-subheading">Curators earn stake of our equity for creating and managing Streams. 
  What counts is the number of suscribers, every week. <a href="#">Learn more</a></h2>

  <div class="wallet-stats u-flex">
    <div class="u-flex u-flexCol col1">
      <div class="wallet-stats-label">TOTAL SUBSCRIBERS</div>
      {% set subscribers = userSubscribers(auth.getUserId()) %}
      <div class="wallet-stats-stat green">{{ subscribers }}</div>
    </div>
    <div class="u-flex u-flexCol col2">
      <div class="wallet-stats-label">PLATFORM SHARE</div>
      {% set subsriberspercentage = (userSubscribers(auth.getUserId()) / totalSubscriptions() ) * 100 %}
      {% set rounded = round(subsriberspercentage) %}
      <div class="wallet-stats-stat">{{rounded}} %* </div>
    </div>
    <div class="u-flex u-flexCol col3">
      <div class="wallet-stats-label">PLATFORM VALUE</div>
      <div class="wallet-stats-stat">$1.2MN {# totalSubscriptions() #}</div>
    </div>
    <div class="u-flex u-flexCol col4">
      <div class="wallet-stats-label">YOUR VALUE</div>
      <div class="wallet-stats-stat">{{ round(( 1200000 * rounded )/ 100  ) }} €</div>
    </div>
  </div>

  <div class="simpletext">
  <h2>Definition</h2>
  <p>
  <b>Total subscribers </b> are calculated summing up all subscribers of all Streams you're curating.
  <b><br>Platform share </b>is your total number of subscribers divided by the number of total subscribers on the whole platform.
 <b><br>Platform value </b> is the current valuation of our company which is done together with investors.
  </p>

  <h2>Rules</h2>
  <p>
  To make it as simple. You're a shareholder. If the other shareholders earn something for their stake, you will, too.
  A pay out is only possible if the company equity liqidates. We are open and transparent with the terms and promise we will stick to market standards.
  You will be involved if we decide to take more funding or plan to liquidate shares.
  </p>
  
  </div>
  


  {% if tableTokens is defined AND tableTokens %}
    <table class="re-table">
      <thead>
        <tr>
          <th class="hide-on-small">STREAMS</th>
          <th class="hide-on-small" style="width:110px;">ROLE</th>
          <th class="hide-on-small" style="width:148px;">EARNED TOKEN</th>
          <th class="hide-on-small" style="width:90px;">YOUR STAKE</th>
        </tr>
      </thead>
      <tbody>
        {{ partial('user/settings/wallet-loadmore') }}
      </tbody>
    </table>
  {% endif %}
  <div class="u-flex u-flexJustifyCenter">
    <a href="#" class="re-button re-button--load-more" {{ moreToLoad ? '' : 'style="display:none;"' }}>Load More</a>
  </div>
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
            }
          });
      });
    });
  </script>
{% endblock %}
