{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
<form id="onboardingForm" method="post" action="/signup/tables">
  <div class="locations">
    <div class="locations__content">
      <div class="locations__content__wrapper">
        <p class="locations__content__title">Pick the <span>locations</span> you’re interested in</p>
        <p class="locations__content__subtitle">Tell us which geographies you’re most interested in. <span>Pick at least 1</span></p>
        <div class="locations__content__main">
          <div class="locations__content__main__left">
            <p>Locations</p>

            <div id="LocationSelect" data-name="locations[]" data-placeholder="Add a location" class="react-component"></div>
          </div>
        </div>

        <div class="signup__content__form__buttons">
          <button id="continueOnboard">Continue</button>
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
          <div class="aside__item item-selected"><p>Regions</p></div>
        </a>
        <a href="/signup/tables">
          <div class="aside__item"><p>Tables</p></div>
        </a>
      </aside>
    </div>
  </div>
</form>
{% endblock %}
