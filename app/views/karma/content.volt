{% for tokens in tableTokens %}
  <tr>
    <td>
      {% if isAjax %}<input class="moreToLoad" type="hidden" value="{{ moreToLoad }}" />{% endif %}
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
