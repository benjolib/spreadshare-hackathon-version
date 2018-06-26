{% extends 'layouts/main.volt' %}


{% block header %}
{% endblock %}

{% block content %}
<div class="re-page">
  <div class="collaborations-page-space">
    <h1 class="re-heading">Collaborations</h1>
    <h2 class="re-subheading">Manage all collaborations in one place.</h2>
  </div>

  <div class="collaborations-tabs">
    <div class="collaborations-tabs__inner">
      <div class="collaborations-tabs-buttons">
        <a href="#" class="collaborations-tabs-button collaborations-tabs-button-submitted active">Submitted</a>
        <a href="#" class="collaborations-tabs-button collaborations-tabs-button-received">Received</a>
      </div>

      <div class="collaborations-tab-content collaborations-tab-content-submitted">
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
                      <!--VOTES-->
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
                      <td><!--
                        <a href="#" class="vote-link">
                          <img class="vote-link__image" src="/assets/images/vote-lightning.svg" />
                          <div>0</div>
                        </a>-->
                      </td>
                      <td class="shadowcontaintd">
                        <div class="shadowcontain">
                          <div class="l-button" style="position: absolute;top: 0;right: 6px;pointer-events: all;cursor: pointer;"><img src="/assets/images/dotdotdot.svg" /></div>
                          <div class="sh-dropdown list-row-remove-dropdown u-flex u-flexCol u-flexJustifyCenter l-dropdown">
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
                <div class="re-table__list-image {{ submission['image'] ? '' : 're-table__list-image--empty' }}" style="background: #f5f5f5 url({{ submission['image'] }}) center / cover;">
                  <img data-name="{{ submission['content']|json_decode[0] }}" class="{{ submission['image'] ? '' : 'empty' }}"/> 
                  <div class="re-table__list-image__upload-button"></div>
                  <!--<div class="re-table__list-image__delete-button"></div>-->
                </div>
                <input type="file" name="image" class="re-table__list-image-fileUpload" style="display: none;" />
              </td>
 

                      {% if (submission['content']) %}
                      {% for cell in submission['content']|json_decode %}
                          {% set len = filterTableRowsContent(cell)|striptags|length %}
                            {% if len > 160  %}
                            {% set length = 500 %}
                            {% elseif len > 80 %}
                            {% set length = 300 %}
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

      <div class="collaborations-tab-content collaborations-tab-content-received" style="display: none;">
        {% for collab in collaborations %}


          {% if collab['kind'] == 'add' %}
            {% set approve_link = "/collaborations/add/approve/" ~ collab['id'] %}
            {% set deny_link = "/collaborations/add/deny/" ~ collab['id'] %}
            {% set action = 'submitted a listing to' %}
          {% else %}
            {%  set approve_link = "/collaborations/delete/approve/" ~ collab['id'] %}
            {%  set deny_link = "/collaborations/delete/deny/" ~  collab['id'] %}
            {% set action = 'requested to delete a listing on' %}
          {% endif %}




          <div class="u-flex u-sm-flexCol u-md-flexRow">
            <div class="collaboration-info u-flex">
                <img class="collaboration-info__image" src={{ collab['user_image'] }}>
              <div>
                <a class="collaboration-info__user-name" href="#">{{ collab['user_name'] }}</a>
                <span class="collaboration-info__text">{{ action }}</span>
                <a class="collaboration-info__table-name" href="#">{{ collab['title'] }}</a>
              </div>
            </div>
            <div class="collaboration-clock"><img src="/assets/images/comment-clock.svg" />{{ formatTimestamp(collab['createdAt']) }}</div>
          </div>
          <div class="table-scroll table-scroll--collaborations">
            <table class="re-table re-table--list">
              <thead>
                <tr>
                  <th>
                   <!-- VOTES -->
                  </th>
                  <th class="shadowcontainth"></th>
                  <th>
                    {#image#}
                  </th>
                  {% for column in collab['columns']%}
                    <th>{{column}}</th>
                  {% endfor %}
                </tr>
              </thead>
              <tbody>
                <tr>
                  <tr data-id="1" class="list-row-tr">
                    <td>
                     <!-- <a href="#" class="vote-link">
                        <img class="vote-link__image" src="/assets/images/vote-lightning.svg" />
                        <div>0</div>
                      </a>-->
                    </td>




                    <td class="shadowcontaintd">
                      <div class="shadowcontain">
                        <div class="u-flex u-flexCol" style="position: absolute;top: 0;right: 0px;pointer-events: all;cursor: pointer;">
                          <a class="collaboration-accept" href={{approve_link}}>
                            <img src="/assets/images/check.svg">
                          </a>
                          <a class="l-button collaboration-reject" href="javascript:;" data-dropdown-placement="left-end">
                            <img src="/assets/images/cross.svg">
                          </a>
                          <div class="sh-dropdown collaboration-reject-dropdown u-flex u-flexCol u-flexJustifyCenter l-dropdown">
                            <form class="u-flex collaboration-reject-dropdown__form" action={{deny_link}} method="POST">
                              <label class="collaboration-reject-dropdown__reason" >
                                <div>REASON FOR REJECTION</div>
                                <input type="text" name="reason" placeholder="Reason here..." />
                              </label>
                              <button class="collaboration-reject-dropdown__send-button">Send</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </td>

                    <td>
                      <div class="re-table__list-image {{ collab['image'] ? '' : 're-table__list-image--empty' }}" style="background: #f5f5f5 url({{ collab['image'] ?  collab['image'] : '' }}) center / cover;"></div>
                    <img data-name="a" class="{{ collab['image'] ? '' : 'empty' }}"/> 
                    </td>

                 

                    {% for cont in collab['content'] %}
                      <td style="min-width: 0px;">{{ filterTableRowsContent( cont ) }}</td>
                    {% endfor %}
                </tr>
                <tr class="re-table-space"></tr>
              </tbody>
            </table>
          </div>
        {% endfor %}
      </div>
    </div>
  </div>
</div>
{% endblock %}

{% block scripts %}
<script type="text/javascript">
  $(document).ready(function () {
     $('.empty ').initial({height:82, width:82 });
    $('.empty ').css('border-radius', "6px")  
    $('.collaborations-tabs-button-submitted').on('click', function (e) {
      e.preventDefault();
      $('.collaborations-tabs-button').removeClass('active');
      $('.collaborations-tabs-button-submitted').addClass('active');
      $('.collaborations-tab-content').hide();
      $('.collaborations-tab-content-submitted').show();
    });

    $('.collaborations-tabs-button-received').on('click', function (e) {
      e.preventDefault();
      $('.collaborations-tabs-button').removeClass('active');
      $('.collaborations-tabs-button-received').addClass('active');
      $('.collaborations-tab-content').hide();
      $('.collaborations-tab-content-received').show();
    });
  });
</script>
{% endblock %}
