{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
<div class="locations">
  <div class="locations__content">
    <div class="locations__content__wrapper">
      <p class="locations__content__title">Pick the <span>regions</span> you’re interested in</p>
      <p class="locations__content__subtitle">Tell us which geographies you’re most interested in. <span>Pick at least 1</span></p>
      <div class="locations__content__main">
        <div class="locations__content__main__left">
          <p>Geographies</p>
          <div class="locations__content__main__left__add">
            <div class="locations__content__main__left__add__search">
              <div class="locations__content__main__left__add__search__icon">
                <img src="/assets/icons/search.svg" />
              </div>
              <input type="text" class="locations__content__main__left__add__search__field" placeholder="Add a region" autofocus />
            </div>
          </div>
        </div>
        <div class="locations__content__main__right">
          <div class="locations__content__main__right__regions">
            <div class="locations__content__main__right__regions__tag">
              <div class="locations__content__main__right__regions__tag__text">Worldwide</div>
              <div class="locations__content__main__right__regions__tag__close">
                <img src="/assets/icons/close.svg" />
              </div>
            </div>
          </div>
        </div>
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
{% endblock %}
