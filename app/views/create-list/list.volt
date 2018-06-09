<div class="table-scroll">
  <table class="re-table re-table--list">
    <thead>
      <tr>
        <th>

        </th>
        <th class="shadowcontainth"></th>
        <th>{# image #}</th>
        {% for column in tableColumns %}
          <th>{{ column }}</th>
        {% endfor %}
      </tr>
    </thead>
    <tbody>
      {% if tableContent is not empty and tableContent %}
        {% for row in tableContent.items %}
          <tr class="list-row-tr">
            <td>
            </td>
            <td class="shadowcontaintd">
              <div class="shadowcontain">
                <div class="l-button" style="position: absolute;top: 0;right: 6px;pointer-events: all;cursor: pointer;"><img src="/assets/images/dotdotdot.svg" /></div>
                <div class="dropdown list-row-remove-dropdown u-flex u-flexCol u-flexJustifyCenter l-dropdown">
                  <a href="#"><img src="/assets/images/bin.svg" /> Remove listing</a>
                </div>
              </div>
            </td>
            <td>
              <div class="re-table__list-image {{ row['image'] ? '' : 're-table__list-image--empty' }}" style="background: #f5f5f5 url({{ row['image'] }}) center / cover;">
                <div class="re-table__list-image__upload-button"></div>
                <div class="re-table__list-image__delete-button"></div>
              </div>
              <input type="file" name="image" class="re-table__list-image-fileUpload" style="display: none;" />
            </td>
            {% for cell in row['content']|json_decode %}
              {% set len = filterTableRowsContent(cell.content)|striptags|length %}
                 {% if len > 160  %}
                 {% set length = 480 %}
                 {% elseif len > 80 %}
                 {% set length = 300 %}
                 {% elseif len > 40 %}
                 {% set length = 175 %}
                 {% elseif len > 20 %}
                 {% set length = 150 %}
                 {% else %}
                 {% set length = 0 %}
                 {% endif %}
              <td style="min-width: {{ length }}px;"><div>{{ filterTableRowsContent(cell.content) }}</div></td>
            {% endfor %}
          </tr>
          <tr class="re-table-space"></tr>
        {% endfor %}
      {% else %}
        <tr><td>No listings yet</td></tr>
      {% endif %}
    </tbody>
  </table>
</div>
