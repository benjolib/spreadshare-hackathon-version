{% extends 'layouts/main.volt' %}


{% block header %}
{% endblock %}

{% block content %}
{{ flash.output() }}

<div class="re-page">
  <div class="submissions-page-space">
    <h1 class="re-heading">Submissions</h1>
    <h2 class="re-subheading">A history of all your submitted listings.</h2>
  </div>

  {% if submissions is defined AND submissions %}
    {% for submission in submissions %}
      <div class="u-flex">
        {% if submission['status'] === '0' %}
          <div class="submission-status submission-status--pending">PENDING</div>
        {% elseif submission['status'] === '1' %}
          <div class="submission-status submission-status--confirmed">CONFIRMED</div>
        {% elseif submission['status'] === '2' %}
          <div class="submission-status submission-status--rejected">REJECTED</div>
        {% endif %}
        <div class="submission-comment">{{ submission['comment'] }}</div>
        <div class="submission-clock"><img src="/assets/images/comment-clock.svg" />{{ formatTimestamp(submission['createdAt']) }}</div>
      </div>
      <div class="table-scroll table-scroll--submissions">
        <table class="re-table re-table--list">
          <thead>
            <tr>
              <th>
                VOTES
              </th>
              <th class="shadowcontainth"></th>
              <th>{# image #}</th>
              {% for column in submission['columns'] %}
                <th>{{ column }}</th>
              {% endfor %}
            </tr>
          </thead>
          <tbody>
            <tr>
              <tr data-id="{{ submission['id'] }}" class="list-row-tr">
                <td>
                  <a href="#" class="vote-link">
                    <img class="vote-link__image" src="/assets/images/vote-lightning.svg" />
                    <div>0</div>
                  </a>
                </td>
                <td class="shadowcontaintd">
                  <div class="shadowcontain">
                    <div class="l-button" style="position: absolute;top: 0;right: 6px;pointer-events: all;cursor: pointer;"><img src="/assets/images/dotdotdot.svg" /></div>
                    <div class="dropdown list-row-remove-dropdown u-flex u-flexCol u-flexJustifyCenter l-dropdown">
                      {% if (submission['kind'] == 'add')%}
                        <a href="submissions/add/revoke/{{submission['id']}}"><img src="/assets/images/bin.svg"> Revoke submission</a>
                      {%endif%}
                      {% if (submission['kind'] == 'delete')%}
                        <a href="submissions/delete/revoke/{{submission['id']}}"><img src="/assets/images/bin.svg"> Revoke submission</a>
                      {%endif%}
                    </div>
                  </div>
                </td>
                <td>
                  <div class="re-table__list-image" style="background: #f5f5f5 url(/assets/images/rows/{{ submission['image'] }}) center / cover;"></div>
                </td>


                {% if (submission['content']) %}
                {% for cell in submission['content']|json_decode %}
                    {% set len = filterTableRowsContent(cell)|striptags|length %}
                      {% if len > 160  %}
                      {% set length = 500 %}
                      {% elseif len > 80 %}
                      {% set length = 200 %}
                      {% elseif len > 40 %}
                      {% set length = 175 %}
                      {% elseif len > 20 %}
                      {% set length = 150 %}
                      {% else %}
                      {% set length = 0 %}
                      {% endif %}
                    <td style="min-width: {{ length }}px;">
                      {{ filterTableRowsContent(cell) }}
                    </td>
                  {% endfor %}
                {% endif %}
            </tr>
            <tr class="re-table-space"></tr>
          </tbody>
        </table>
      </div>
    {% endfor %}
  {% endif %}
</div>
{% endblock %}

{% block scripts %}
<script type="text/javascript">
  $(document).ready(function () {

  });
</script>
{% endblock %}
