{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
<div class="re-page">
  <div class="page-top-margin-bottom">
    <div>
      <h1 class="re-heading">Wallet</h1>
      <h2 class="re-subheading">Your token storage.</h2>
      <h3 class="re-subtext">Soon we’ll introduce ways to spend and withdraw tokens.</h3>
    </div>
  </div>

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
        {% for tokens in tableTokens %}
          <tr>
            <td>
              <div class="re-table-green">{{ tokens['listingCount'] }} LISTINGS</div>
              <a href="/table/{{ tokens['tableId']}}"><h3>{{ tokens['tableTitle'] }}</h3></a>
              <p>{{ tokens['tableTagline'] }}</p>
            </td>
            <td class="hide-on-small">{% if tokens['ownerUserId'] == auth.getUserId() %}OWNER{% else %}COLLABORATOR{% endif %}</td>
            <td class="hide-on-small">{{ tokens['tokensEarned'] }}</td>
            <td class="hide-on-small">{{ ((tokens['yourListingCount'] / tokens['listingCount']) * 100)|round(2) }}%</td>
          </tr>
          <tr class="re-table-space"></tr>
        {% endfor %}
      </tbody>
    </table>
  {% endif %}
</div>
{% endblock %}
