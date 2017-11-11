{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - Sign Up{% endblock %}

{% block content %}
  <div class="signup">
    <div class="signup__content">
      <div class="signup__content__wrapper">
        <p class="signup__content__title">Join now</p>
        <p class="signup__content__subtitle">Discover and contribute to the community of data lovers.</p>
        <form class="signup__content__form">
          <p>Your name</p>
          <input type="text" autofocus />
          <span>We’re big on real names around here, so people know who’s who</span>
          <p>Email</p>
          <input type="email" />
          <p>Password</p>
          <input type="password" />
          <div id="showPassword">
            <img src="/assets/icons/eye.svg" /><span>Show Password</span>
          </div>
          <div class="signup__content__form__buttons">
            <button>Login</button>
            <button type="submit">Sign up</button>
          </div>
        </form>
      </div>
      <aside class="signup__content__aside">
        <div class="signup__content__aside__box">
          <div>Sign up</div>
          <div>Sign in</div>
        </div>
        <p>OR</P>
        <div class="signup__content__aside__social">
          <div class="signup__content__aside__social__facebook">
            <img src="/assets/icons/facebook.svg" />
            <span>Use Facebook</span>
          </div>
          <div class="signup__content__aside__social__twitter">
            <img src="/assets/icons/twitter.svg" />
            <span>Use Twitter</span>
          </div>
        </div>
      </aside>
    </div>
  </div>
{% endblock %}
