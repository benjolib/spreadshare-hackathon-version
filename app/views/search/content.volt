{% for table in tables %}
  <tr>
    <td>
      {# {% if isAjax %}<input class="moreToLoad" type="hidden" value="{{ moreToLoad }}" />{% endif %} #}
      <div class="re-table-green">{{ table['subscriberCount'] }} SUBSCRIBERS</div>
      <a href="/list/{{ table['id'] }}"><h3>{{ table['title'] }}</h3></a>
      <p>{{ table['tagline'] }}</p>
    </td>
  </tr>
  <tr class="re-table-space"></tr>
{% endfor %}
