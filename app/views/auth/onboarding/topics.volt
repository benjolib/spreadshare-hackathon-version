{% extends 'layouts/main.volt' %}

{% block header %}

{% endblock %}

{% block content %}
<div class="topics">
  <div class="topics__content">
    <form id="onboardingForm" method="post" action="/signup/follow">
      <div class="topics__content__wrapper">
        <p class="topics__content__title">Choose the <span>topics</span> you're interested in</p>
        <p class="topics__content__subtitle">Tell us which categories you’re most interested in. <span>Pick at least 3</span> or <span id="selectAll">Select all</span></p>
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
      <aside class="aside aside--onboarding">
        <a href="/signup/topics">
          <div class="aside__item item-selected"><p>Topics</p></div>
        </a>
        <a href="/signup/follow">
          <div class="aside__item"><p>People</p></div>
        </a>
        <a href="/signup/location">
          <div class="aside__item"><p>Regions</p></div>
        </a>
        <a href="/signup/tables">
          <div class="aside__item"><p>Tables</p></div>
        </a>
      </aside>
      <div class="signup__content__form__buttons">
        <button id="continueOnboard">Continue</button>
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

    // select all
    var $topicsCards = $('.topics__content__main__cards__item');
    $('#selectAll').on('click', function() {
      if ($(this).text() === 'Select all') {
        for (var i = 0; i < $topicsCards.length; i++) {
          $($topicsCards[i]).addClass('selected');
          $($topicsCards[i]).find('p').find('input').prop('checked', true);
        }
        $(this).text('Unselect all');
      } else {
        for (var i = 0; i < $topicsCards.length; i++) {
          $($topicsCards[i]).removeClass('selected');
          $($topicsCards[i]).find('p').find('input').prop('checked', false);
        }
        $(this).text('Select all');
      }
    });
  });
</script>
{% endblock %}
