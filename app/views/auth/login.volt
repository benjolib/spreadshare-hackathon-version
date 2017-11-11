{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - Sign In{% endblock %}

{% block content %}
  <div class="login">
    <div class="login__content">
      <div class="login__content__wrapper">
        <p class="login__content__title">Join now</p>
        <p class="login__content__subtitle">Discover and contribute to the community of data lovers.</p>
        <form class="login__content__form">
          <p>Username <span>or</span> Email</p>
          <input type="text" autofocus />
          <span>We’re big on real names around here, so people know who’s who</span>
          <p>Password ● <a>Forgot?</a></p>
          <input type="password" />
          <div class="login__content__form__buttons">
            <a href="/signup">Sign up</a>
            <button type="submit">Login</button>
          </div>
        </form>
      </div>
      <aside class="login__content__aside">
        <div class="login__content__aside__box">
          <a href="/signup"><div>Sign up</div></a>
          <a href="/login"><div class="sign-box-selected">Sign in</div></a>
        </div>
        <p>OR</P>
        <div class="login__content__aside__social">
          <div class="login__content__aside__social__facebook">
            <img src="/assets/icons/facebook.svg" />
            <span>Use Facebook</span>
          </div>
          <div class="login__content__aside__social__twitter">
            <img src="/assets/icons/twitter.svg" />
            <span>Use Twitter</span>
          </div>
        </div>
      </aside>
    </div>
  </div>
{% endblock %}
