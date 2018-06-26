{% extends 'layouts/main.volt' %} {# page title #} {% block title %}SpreadShare - Feed - Data that matters.{% endblock %}
{% block content %}

<div class="re-page">
    <div class="collaborations-page-space">
        <h1 class="re-heading">Activity</h1>
        <h2 class="re-subheading">You will be notified if people interact with you or your content</h2>
    </div>
    <div class="u-flex u-flexJustifyCenter u-flexCol">
        {% if notifications %}
        <div class="elements container__content activity-box u-flex u-flexJustifyCenter u-flexCol">

            {% for notification in notifications %}

            <div class="notification-dropdown__notification u-flex u-flexAlignItemsCenter >
            <a href=" /user/{{ notification[ 'userHandle'] }} ">
<img class="notification-dropdown__notification__image " src="{{ notification[ 'userImage'] ? notification[ 'userImage']
                : "/assets/images/9-0/logo.png"}} "
/>
            </a>

            <div style="width:100%; ">
            <div class="u-flex u-flexJustifyBetween ">
            <a href="{{ linkHelper.getLink(notification) }} ">
                <span class="notification-dropdown__notification__name ">{{ notification['userName'] }}</span>
            </a>
            <div class="notification-dropdown__notification__date "><img src="/assets/images/comment-clock.svg " />{{ formatTimestamp(notification['createdAt']) }}</div>
            </div>
        <p class="notification-dropdown__notification__text ">
        {{ notification['text'] }}</p>
        </div>
      </div>
            {% endfor %}
        </div>
        {% else %}
        <div class="container__content center ">
            <div>
                <img src="/assets/images/desktop.png " alt=" " />
            </div>
            <p>&nbsp;</p>
            <p>There are no notifications available for you, yet..</p>
        </div>
        {% endif%}
       
    </div>
</div>

{% endblock %}

{% block scripts %}

{% endblock %}