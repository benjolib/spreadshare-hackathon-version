{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
<form id="onboardingForm" method="post" action="/signup/location">
  <div class="follow">
    <div class="follow__content">
      <div class="follow__content__wrapper">
        <p class="follow__content__title">Awesome <span>people</span> you should follow</p>
        <p class="follow__content__subtitle">We’ll add tables created or collaborated on by people you follow. <span>Pick at least 3</span></p>
        <div class="follow__content__main">
          <div class="follow__content__main__cards">

            {% for user in users %}
            <div class="follow__content__main__cards__item">
              <img src="{{ user.getImage() }}" />
              <div class="follow__content__main__cards__item__text">
                <p>{{ user.getName() }}</p>
                <p>{{ user.getTagline() }}</p>
              </div>
              <div class="follow__content__main__cards__item__button">
                <span>Follow</span>
                <input type="checkbox" name="user[{{ user.getId() }}]" value="{{ user.getId() }}" style="width:0; opacity:0;" />
              </div>
            </div>
            {% endfor %}

          </div>
        </div>
        <div class="signup__content__form__buttons">
          <button class="button">Continue</button>
        </div>
      </div>
      <aside class="follow__content__aside">
        <div class="follow__content__aside__box">
          <a href="/signup/topics">
            <div>Topics</div>
          </a>
          <a href="/signup/follow">
            <div class="sign-box-selected">People</div>
          </a>
          <a href="/signup/location">
            <div>Regions</div>
          </a>
          <a href="/signup/tables">
            <div>Tables</div>
          </a>
        </div>
      </aside>
    </div>
  </div>
</form>
{% endblock %}

{% block scripts %}
<script type="text/javascript">
  $(document).ready(function () {
    $('.follow__content__main__cards').on('click', '.follow__content__main__cards__item__button', function (ev) {
      ev.stopPropagation();
      var target = $(ev.currentTarget);
      var input = target.find('input')[0];
      if (input.checked) {
        input.checked = false;
        target.removeClass('selected');
      } else {
        input.checked = true;
        target.addClass('selected');
      }
    });
  });
</script>
{% endblock %}
