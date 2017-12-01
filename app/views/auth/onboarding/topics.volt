{% extends 'layouts/main.volt' %}

{% block header %}

{% endblock %}

{% block content %}
<div class="topics">
  <div class="topics__content">
    <form id="onboardingForm" method="post" action="/signup/follow">
      <div class="topics__content__wrapper">
        <p class="topics__content__title">Choose the <span>topics</span> you're interested in</p>
        <p class="topics__content__subtitle">Tell us which categories you’re most interested in. <span>Pick at least 3</span></p>
        <div class="topics__content__main">
          <div class="topics__content__main__cards">
            {% for topic in topics %}
            <div class="topics__content__main__cards__item">
              <p>
                {{ topic.title|e }}
                <input type="checkbox" name="topic[{{ topic.id }}]" value="{{ topic.id }}" style="width:0; opacity:0;" />
              </p>
            </div>
            {% endfor %}
          </div>
        </div>
      </div>
      <aside class="topics__content__aside">
        <div class="topics__content__aside__box">
          <a href="/signup/topics">
            <div class="sign-box-selected">Topics</div>
          </a>
          <a href="/signup/follow">
            <div>People</div>
          </a>
          <a href="/signup/location">
            <div>Regions</div>
          </a>
          <a href="/signup/tables">
            <div>Tables</div>
          </a>
        </div>
      </aside>
      <div class="signup__content__form__buttons">
        <button class="button">Continue</button>
      </div>
    </form>

  </div>
</div>
{% endblock %}

{% block scripts %}
<script type="text/javascript">
  $(document).ready(function () {
    $('.topics__content__main__cards__item').on('click', function (ev) {
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
