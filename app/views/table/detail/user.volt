{% extends 'layouts/main.volt' %}

{% block content %}
{{ partial('table/detail/header') }}

<div class="container container--tableUsers">
  <div class="container__content">
    <div class="tableUsers">
      {% for user in tableUsers%}
        <div class="tableUsers__item">
          <div class="tableUsers__item__avatar">
            <img src="{{ user['image'] }}" />
          </div>
          <div class="tableUsers__item__info">
            <div class="tableUsers__item__info__title">
              <h5>{{ user['name'] }}</h5>
            </div>
            <div class="tableUsers__item__info__subtitle">
              <p>{{ user['location'] }}</p>
              <p>{{ user['tagline'] }}</p>
            </div>
          </div>
          <div class="tableUsers__item__follow">
            <button class="follow-user {% if user['following'] %}following-user selected {% else %}not-following-user {% endif %}" data-id="{{ user['id'] }}" type="button"></button>
          </div>
        </div>
      {% endfor %}
    </div>
  </div>
  <aside class="aside">
    <a href="#">
      <div class="aside__item item-selected">
        <p>All</p>
      </div>
    </a>
    <a href="#">
      <div class="aside__item">
        <p>Upvoters</p>
      </div>
    </a>
    <a href="#">
      <div class="aside__item">
        <p>Subscribers</p>
      </div>
    </a>
    <a href="#">
      <div class="aside__item">
        <p>Contributors</p>
      </div>
    </a>
    <a href="#">
      <div class="aside__item">
        <p>Admin & Owner</p>
      </div>
    </a>
  </aside>
</div>
{% endblock %}

{% block scripts %}
<script type="text/javascript">
  $(document).ready(function () {
    $followButton = $('.follow-user');
    $followButton.on('click', function() {
      $(this).toggleClass('not-following-user');
      $(this).toggleClass('following-user');
    });
  });
</script>
{% endblock %}
