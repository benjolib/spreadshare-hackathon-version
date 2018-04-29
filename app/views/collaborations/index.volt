{% extends 'layouts/main.volt' %}


{% block header %}
{% endblock %}

{% block content %}
<div class="re-page">
  <div class="collaborations-page-space">
    <h1 class="re-heading">Collaborations</h1>
    <h2 class="re-subheading">Manage submissions to your lists.</h2>
    <h3 class="re-subtext hide-on-small">Looking for a listing you submitted? Go to your <a href="/submissions">submitted listings.</a></h3>
  </div>


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
              VOTES
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
                <a href="#" class="vote-link">
                  <img class="vote-link__image" src="/assets/images/vote-lightning.svg" />
                  <div>0</div>
                </a>
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
                    <div class="dropdown collaboration-reject-dropdown u-flex u-flexCol u-flexJustifyCenter l-dropdown">
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
                <div class="re-table__list-image" style="background: #f5f5f5 url({{ collab['image'] }}) center / cover;"></div>
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
{% endblock %}

{% block scripts %}
<script type="text/javascript">
  $(document).ready(function () {

  });
</script>
{% endblock %}
