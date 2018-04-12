{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
<div class="re-page">
  <h1 class="re-heading">Activity</h1>
  <h2 class="re-subheading">You will be notified if people interact with you or your content</h2>
  <div class="activity-box">
    {% for notification in notifications %}
      <div class="activity-box__notification u-flex u-flexAlignItemsCenter">
        <a href="/user/{{ notification['userHandle'] }}">
          <img class="activity-box__notification__image" src="{{ notification['userImage'] }}" />
        </a>
        <div style="width:100%;">
          <div class="u-flex u-flexJustifyBetween">
            <a href="/user/{{ notification['userHandle'] }}">
              <span class="activity-box__notification__name">{{ notification['userName'] }}</span>
            </a>
            <a href="/user/follow/{{ notification['targetUserId'] }}" class="activity-box__notification__follow">Follow</a>
            <div class="activity-box__notification__date"><img src="/assets/images/comment-clock.svg" />{{ formatTimestamp(notification['createdAt']) }}</div>
          </div>
          <p class="activity-box__notification__text">{{ notification['text'] }}</p>
        </div>
      </div>
    {% endfor %}
  </div>
</div>
{% endblock %}

{% block scripts %}
  <script type="text/javascript">
    $(document).ready(function () {

    });
  </script>
{% endblock %}
