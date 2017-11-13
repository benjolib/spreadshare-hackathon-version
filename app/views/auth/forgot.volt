{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - Forgot Password{% endblock %}

{% block content %}
<div class="login">
  <div class="login__content">
    <div class="login__content__wrapper">
      <p class="login__content__title">Join now</p>
      <p class="login__content__subtitle">Discover and contribute to the community of data lovers.</p>
      <form class="login__content__form" method="post">
        <p>Username <span>or</span> Email</p>
        <input type="text" name="username" tabindex="1" autofocus />
        <div class="login__content__form__buttons">
          <a href="/login">Cancel</a>
          <button type="submit">Resend Password</button>
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
      <div class="signup__content__aside__social">
        <div class="signup__content__aside__social__facebook">
          <img src="/assets/icons/facebook.svg" />
          <a href="/login/facebook">Use Facebook</a>
        </div>
        <div class="signup__content__aside__social__twitter">
          <img src="/assets/icons/twitter.svg" />
          <a href="/login/twitter">Use Twitter</a>
        </div>
      </div>
    </aside>
  </div>
</div>
{% endblock %}
