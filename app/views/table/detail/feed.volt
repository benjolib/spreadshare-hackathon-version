{% extends 'layouts/main.volt' %}

{% block content %}

{{ partial('table/detail/header') }}


<div class="tableAbout">
  <div class="tableAbout__info">
    <div class="tableAbout__info__content tableAbout__info__content--left">
      <div class="tableAbout__comments">
        {% for log in logs %}
        <div class="tableAbout__comments__container">
          <span>{{ log['userName'] }}</span>
          <img src="{{ log['userImage'] }}" />
          <span>{{ formatTimestamp(log['createdAt']) }}</span>
          <span>{{ log['text'] }}</span>
        </div>
        {% endfor %}
      </div>
    </div>
  </div>
</div>


{% endblock %}