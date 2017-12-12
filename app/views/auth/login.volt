{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - Sign In{% endblock %}

{% block content %}
<div class="login">
  <div class="login__content">
    <div class="login__content__wrapper">
      <p class="login__content__title">Join now</p>
      <p class="login__content__subtitle">Discover and contribute to the community of data lovers.</p>
      <form class="login__content__form" action="/login" method="post">
        <p>Username <span>or</span> Email</p>
        <input type="text" name="username" tabindex="1" autofocus />
        <span>We’re big on real names around here, so people know who’s who</span>
        <p>Password ● <a href="/login/forgot">Forgot?</a></p>
        <input type="password" name="password" tabindex="2" />
        {{ flash.output() }}

        <div class="login__content__form__buttons">
          <a href="/signup">Sign up</a>
          <button type="submit">Login</button>
        </div>
      </form>
    </div>
    <aside class="login__content__aside">
      <div class="login__content__aside__box">
        <a href="/signup">
          <div>Sign up</div>
        </a>
        <a href="/login">
          <div class="sign-box-selected">Sign in</div>
        </a>
      </div>
      <p>OR</P>
      <div class="login__content__aside__social">
        <div class="login__content__aside__social__facebook">
          <img src="/assets/icons/facebook.svg" />
          <a href="/login/facebook">Connect via Facebook</a>
        </div>
        <div class="login__content__aside__social__twitter">
          <img src="/assets/icons/twitter.svg" />
          <a href="/login/twitter">Connect via Twitter</a>
        </div>
        <div class="login__content__aside__social__google">
          <img src="/assets/icons/google.svg" />
          <a href="/login/google">Connect via Google</a>
        </div>
      </div>
    </aside>
  </div>
</div>
{% endblock %}
