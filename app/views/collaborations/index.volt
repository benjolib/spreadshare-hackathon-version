{% extends 'layouts/main.volt' %}


{% block header %}
{% endblock %}

{% block content %}
{{ flash.output() }}

<div class="re-page">
  <div class="collaborations-page-space">
    <h1 class="re-heading">Collaborations</h1>
    <h2 class="re-subheading">Manage submissions to your lists.</h2>
    <h3 class="re-subtext hide-on-small">Looking for a listing you submitted? Go to your <a href="/submissions">submitted listings.</a></h3>
  </div>

  {% set numbers = [1, 2, 3] %}

  {% for number in numbers %}
    <div class="u-flex u-sm-flexCol u-md-flexRow">
      <div class="collaboration-info u-flex">
        <img class="collaboration-info__image" src="https://cdn-images-1.medium.com/fit/c/100/100/1*iRHlXdQhKPpyNJ0w6f7ijw.jpeg" />
        <div>
          <a class="collaboration-info__user-name" href="#">Andrew Coyle</a>
          <span class="collaboration-info__text">submitted a listing to</span>
          <a class="collaboration-info__table-name" href="#">Design Tools</a>
        </div>
      </div>
      <div class="collaboration-clock"><img src="/assets/images/comment-clock.svg" />TODAY</div>
    </div>
    <div class="table-scroll table-scroll--collaborations">
      <table class="re-table re-table--list">
        <thead>
          <tr>
            <th>
              VOTES
            </th>
            <th class="shadowcontainth"></th>
            <th>{# image #}</th>
            <th>TOOL NAME</th>
            <th>WHAT IT DOES</th>
            <th>WEBSITE</th>
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
                    <a class="collaboration-accept" href="#">
                      <img src="/assets/images/check.svg">
                    </a>
                    <a class="l-button collaboration-reject" href="javascript:;" data-dropdown-placement="left-end">
                      <img src="/assets/images/cross.svg">
                    </a>
                    <div class="dropdown collaboration-reject-dropdown u-flex u-flexCol u-flexJustifyCenter l-dropdown">
                      <form class="u-flex collaboration-reject-dropdown__form">
                        <label class="collaboration-reject-dropdown__reason">
                          <div>REASON FOR REJECTION</div>
                          <input type="text" placeholder="Reason here..." />
                        </label>
                        <button class="collaboration-reject-dropdown__send-button">Send</button>
                      </form>
                    </div>
                  </div>
                </div>
              </td>
              <td>
                <div class="re-table__list-image" style="background: #f5f5f5 url(https://abduzeedo.com//sites/default/files/originals/abdz_marvelapp_logodesignprocess.jpg) center / cover;"></div>
              </td>
              <td style="min-width: 0px;">{{ filterTableRowsContent('Marvel') }}</td>
              <td style="min-width: 200px;">{{ filterTableRowsContent('The all-in-one enterprise design platform. From built-in wireframing to developer handoff, Marvel gives every team the tools they need to bring ideas to life.') }}</td>
              <td style="min-width: 0px;">{{ filterTableRowsContent('https://marvelapp.com/') }}</td>
              <td style="width:55px;min-width:55px"></td>
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
