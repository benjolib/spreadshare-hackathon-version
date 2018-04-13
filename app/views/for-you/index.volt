{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
<div class="re-page">
  <div class="collaborations-page-space">
    <h1 class="re-heading">For You</h1>
    <h2 class="re-subheading">Activity of users you follow and lists you subscribe.</h2>
  </div>

  {% set numbers = [1, 2] %}

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
                </div>
              </td>
              <td>
                <div class="re-table__list-image" style="background: #f5f5f5 url(https://abduzeedo.com//sites/default/files/originals/abdz_marvelapp_logodesignprocess.jpg) center / cover;"></div>
              </td>
              <td style="min-width: 0px;">{{ filterTableRowsContent('Marvel') }}</td>
              <td style="min-width: 250px;">{{ filterTableRowsContent('The all-in-one enterprise design platform. From built-in wireframing to developer handoff, Marvel gives every team the tools they need to bring ideas to life.') }}</td>
              <td style="min-width: 0px;">{{ filterTableRowsContent('https://marvelapp.com/') }}</td>
          </tr>
          <tr class="re-table-space"></tr>
        </tbody>
      </table>
    </div>

    <div class="u-flex u-sm-flexCol u-md-flexRow">
      <div class="collaboration-info u-flex">
        <img class="collaboration-info__image" src="https://cdn-images-1.medium.com/fit/c/100/100/1*iRHlXdQhKPpyNJ0w6f7ijw.jpeg" />
        <div>
          <a class="collaboration-info__user-name" href="#">Andrew Coyle</a>
          <span class="collaboration-info__text">created a new list</span>
          <a class="collaboration-info__table-name" href="#">Design Tools</a>
        </div>
      </div>
      <div class="collaboration-clock"><img src="/assets/images/comment-clock.svg" />TODAY</div>
    </div>
    <div class="for-you-table u-flex u-flexCol">
      <div class="for-you-table__image" style="background: #f5f5f5 url(https://picsum.photos/894/258/?image=1) center / cover;">
        <div class="for-you-table__listingCount">52 LISTINGS</div>
      </div>
      <div class="for-you-table__bottom u-flex u-flexJustifyBetween u-flexAlignItemsCenter">
        <div class="u-flex u-flexCol">
          <h3 class="for-you-table__heading">Design Tools</h3>
          <p class="for-you-table__tagline">These are my favorite tools to craft UI & UX work</p>
        </div>
        <div class="for-you-table__subscriberCount"><img src="/assets/images/mail.svg" />239</div>
      </div>
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
