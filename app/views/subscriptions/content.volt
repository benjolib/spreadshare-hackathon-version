{% for table in [1, 2, 3, 4, 5] %}
  <tr>
    <td>
      {# {% if isAjax %}<input class="moreToLoad" type="hidden" value="{{ moreToLoad }}" />{% endif %} #}
      <div class="re-table-green">239 SUBSCRIBERS</div>
      <a href="/list/{{ table['id'] }}"><h3>Design Tools</h3></a>
      <p>These are my favorite tools to craft UI & UX work</p>
    </td>
    <td>
      <div class="u-flex u-flexJustifyCenter u-flexAlignItemsCenter card-actions-button l-button">
        <span class="card-actions-button__text">Daily</span><img src="/assets/images/arrow-down.svg" />
      </div>
      <div class="dropdown card-actions-dropdown card-actions-dropdown--tall u-flex u-flexCol u-flexJustifyCenter l-dropdown">
        <a href="#">Daily</a>
        <a href="#">Weekly</a>
        <a href="#">Monthly</a>
        <a href="#" class="warning-color">Unsubscribe</a>
      </div>
    </td>
  </tr>
  <tr class="re-table-space"></tr>
{% endfor %}
