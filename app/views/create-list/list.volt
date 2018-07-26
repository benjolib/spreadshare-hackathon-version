<div class="table-scroll">
    <div class="shadowcontain">
        <div class="l-button" style="position: absolute;top: 0;right: 6px;pointer-events: all;cursor: pointer;">
            <img src="/assets/images/dotdotdot.svg" />
        </div>
        <div class="sh-dropdown list-row-remove-dropdown u-flex u-flexCol u-flexJustifyCenter l-dropdown">
            <a href="#"><img src="/assets/images/bin.svg" /> Remove listing</a>
        </div>
    </div>
    <div class="scroll-wrapper">
      <table class="re-table re-table--list">
        <thead>
          <tr>
            <th>

            </th>
            <th class="shadowcontainth"></th>
            <th>{# image #}</th>
            {% for column in tableColumns %}
              <th>{{ column }}</th><td></td>
            {% endfor %}
          </tr>
        </thead>
        <tbody>



      {% if tableContent is not empty and tableContent %}
        {% for i, row in tableContent %}
          <tr class="list-row-tr" id="{{ row['id'] }}">
            <td>
            </td>
            <td class="shadowcontaintd">
              <div class="shadowcontain"></div>
            </td>
            <td>
            <div class="re-table__list-image" style="background: #f5f5f5 center / cover;">
            {% if row['image'] is not empty %}

              {% else %}
              <img data-name="{{ row['content'][0] }}" class="empty"/>
              {% endif %}
              {% if row['image'] is not empty %}
              <div class="re-table__list-image " style="z-index:99;background: #f5f5f5 url({{ row['image'] }}) center / cover;">

              {% else %}


              <div class="re-table__list-image__upload-button"></div>
              {% endif %}

              <div class="re-table__list-image__upload-button"></div>
                <!-- <div class="re-table__list-image__delete-button"></div> -->
              </div>

              <input type="file" name="listing-image-{{ i }}" class="re-table__list-image-fileUpload" style="display: none;" />
            </td>
            {% for index,cell in row['content'] %}

              {% set len = filterTableRowsContent(cell)|striptags|length %}
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
              <td style="min-width: {{ length }}px; cursor: pointer;" >
<div onmouseover="javascript:$('.e{{i}}{{index}}').css('visibility','visible');" ; onmouseout="javascript:$('.e{{i}}{{index}}').css('visibility', 'hidden');"
  id="{{i}}" class="edit icon" style="outline: 0px solid transparent;border:0;display:flex;d{{i}}{{index}};">{{cell}}</div>
              </td>
              <td>
<i id="{{i}}" class="edit icon green e{{i}}{{index}}" style="cursor: pointer;visibility: hidden;" onclick="console.log($(this).prev().prev());javascript:$('.d{{i}}{{index}}').focus();"></i>
              </td>
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
</div>
