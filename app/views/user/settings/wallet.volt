{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
<div class="re-page">
  <h1 class="re-heading">Wallet</h1>
  <h2 class="re-subheading">Your token storage.</h2>
  <h3 class="re-subtext">Soon we’ll introduce ways to spend and withdraw tokens.</h3>

  <div class="wallet-stats u-flex">
    <div class="u-flex u-flexCol col1">
      <div class="wallet-stats-label">EARNED TOKEN</div>
      <div class="wallet-stats-stat green">{{ wallet.tokens }}</div>
    </div>
    <div class="u-flex u-flexCol col2">
      <div class="wallet-stats-label">LISTS</div>
      <div class="wallet-stats-stat">{{ tableCount }}</div>
    </div>
    <div class="u-flex u-flexCol col3">
      <div class="wallet-stats-label">SUBMISSIONS</div>
      <div class="wallet-stats-stat">{{ submissionsCount }}</div>
    </div>
  </div>

  {% if tableTokens is defined AND tableTokens %}
    <table class="re-table">
      <thead>
        <tr>
          <th class="hide-on-small">LISTS</th>
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
