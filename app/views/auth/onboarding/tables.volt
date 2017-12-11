{% extends 'layouts/main.volt' %}

{% block header %}{% endblock %}

{% block content %}
<form id="onboardingForm" method="post" action="/signup/finished">
  <div class="tables">
    <div class="tables__content">
      <div class="tables__content__wrapper">
        <div class="signup__content__form__buttons">
          <button id="continueOnboard">Finish</button>
        </div>
        <p class="tables__content__title">Here are some <span>tables</span> you might like</p>
        <p class="tables__content__subtitle">Tell us which tables you’re most interested in. <span>Pick at least 3</span> or <span id="selectAll">Subscribe all</span></p>
        <div class="tables__content__main">
          {# cards #}
          <div class="tables__content__main__cards">
            {% for table in tables %}
            <div class="tableCard">
              <div class="tableCard__info">
                <div class="tableCard__info__title">
                  <h3><a href="/table/{{ table['id'] }}" }>{{ table['title'] }}</a></h3>
                  <p>{{ table['tagline'] }}</p>
                </div>
                <button class="tableCard__info__subscribe subscribe" data-action="subscribe" data-id="{{ table['id'] }}"
                    onclick="var event = arguments[0] || window.event; event.stopPropagation();">
                  <span></span>
                </button>
              </div>
              <div class="tableCard__stats">
                {# table type #}
                <a class="tableCard__stats__item tableCard__stats__item--type" href="/?topic=&type={{ table['typeId'] }}">
                  {% if table['topic1'] %}
                  <span>{{ table['topic1'] }}</span>
                  {% else %}
                  <span></span>
                  {% endif %}
                </a>
                {# tokens #}
                <a class="tableCard__stats__item tableCard__stats__item--token" href="/table/{{ table['id'] }}">
                  {% if table['tokensCount'] > 0 %}
                  <span>{{ table['tokensCount'] +0 }} Tokens</span>
                  {% else %}
                  <span>0 Token</span>
                  {% endif %}
                </a>
                {# views #}
                <a class="tableCard__stats__item tableCard__stats__item--views" href="/table/{{ table['id'] }}/about">
                  <span><i>{{ table['viewsCount'] +0 }}</i> Views</span>
                </a>
                {# comments #}
                <a class="tableCard__stats__item tableCard__stats__item--comments" href="/table/{{ table['id'] }}/about#comments">
                  <span><i>{{ table['commentsCount'] +0 }}</i> Comments</span>
                </a>
                {# contributions #}
                <a class="tableCard__stats__item tableCard__stats__item--contributions" href="/table/{{ table['id'] }}/users/contributors">
                  <span><i>{{ table['contributionCount'] }}</i> Contributions</span>
                </a>
              </div>
            </div>

            {% endfor %}
          </div>
        </div>
      </div>
      <aside class="aside aside--onboarding">
        <a href="/signup/topics">
          <div class="aside__item"><p>Topics</p></div>
        </a>
        <a href="/signup/follow">
          <div class="aside__item"><p>People</p></div>
        </a>
        <a href="/signup/location">
          <div class="aside__item"><p>Regions</p></div>
        </a>
        <a href="/signup/tables">
          <div class="aside__item item-selected"><p>Tables</p></div>
        </a>
      </aside>
    </div>
  </div>
</form>
{% endblock %}

{% block scripts %}
<script type="text/javascript">
  $(document).ready(function () {
    var $subscribeButtons = $('.tableCard__info__subscribe.subscribe');
    $('#selectAll').on('click', function() {
      if ($(this).text() === 'Subscribe all') {
        for (var i = 0; i < $subscribeButtons.length; i++) {
          if (!$($subscribeButtons[i]).hasClass('subscribed')) {
            $subscribeButtons[i].click();
          }
        }
        $(this).text('Unsubscribe all');
      } else {
        for (var i = 0; i < $subscribeButtons.length; i++) {
          if ($($subscribeButtons[i]).hasClass('subscribed')) {
            $subscribeButtons[i].click();
          }
        }
        $(this).text('Subscribe all');
      }
    });
  });
</script>
{% endblock %}
