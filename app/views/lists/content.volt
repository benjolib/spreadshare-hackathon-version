{% for table in tables %}
  <tr>
    <td>
      {% if isAjax %}<input class="moreToLoad" type="hidden" value="{{ moreToLoad }}" />{% endif %}
      <div class="{{ table['flags'] === '2' ? 're-table-green' : '' }}">{{ table['flags'] === '2' ? 'PUBLISHED' : 'DRAFT' }}</div>
      <a href="/list/{{ table['id'] }}"><h3>{{ table['title'] }}</h3></a>
      <p>{{ table['tagline'] }}</p>
    </td>
    <td>
      <div class="u-flex u-flexJustifyCenter u-flexAlignItemsCenter card-actions-button l-button">
        <img src="/assets/images/arrow-down.svg" />
      </div>
      <div class="dropdown card-actions-dropdown u-flex u-flexCol u-flexJustifyCenter l-dropdown">
        <a href="/table/{{ table['id'] }}/settings"><img src="/assets/images/pencil2.svg" /> Edit List</a>

        <a href="/table/{{ table['id'] }}/delete" class="warning-color"><img src="/assets/images/bin2.svg" /> Delete List</a>
      </div>
    </td>
  </tr>
  <tr class="re-table-space"></tr>
{% endfor %}
