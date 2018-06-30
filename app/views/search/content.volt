 {% for table in tables %}
<tr>
  <td>
    {# {% if isAjax %}
    <input class="moreToLoad" type="hidden" value="{{ moreToLoad }}" />{% endif %} #}
  
<a class="" href="/stream/{{ table['id'] }}">
      <h3>{{ table['title'] }} &nbsp;&nbsp;
<img src="/assets/images/9-0/list-card-subscriber-bird.svg">
<span class="list-card__subscriberCount">{{ table['subscriberCount'] }}</span>
</h3>



      <p>{{ table['tagline'] }}</p>
  </td>
</tr>
<tr class="re-table-space"></tr>
{% endfor %}