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
      <aside class="locations__content__aside">
        <div class="locations__content__aside__box">
          <a href="/signup/topics">
            <div>Topics</div>
          </a>
          <a href="/signup/follow">
            <div>People</div>
          </a>
          <a href="/signup/location">
            <div class="sign-box-selected">Regions</div>
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
