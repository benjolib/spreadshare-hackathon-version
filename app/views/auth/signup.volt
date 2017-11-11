{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - Sign Up{% endblock %}

{% block content %}
<div class="signup">
  <div class="signup__content">
    <div class="signup__content__wrapper">
      <p class="signup__content__title">Join now</p>
      <p class="signup__content__subtitle">Discover and contribute to the community of data lovers.</p>
      <form class="signup__content__form" method="post">
        <p>Your name</p>
        <input type="text" name="name" value="{{ post['name'] }}" autofocus />
        <span>We’re big on real names around here, so people know who’s who</span>
        <p>Username</p>
        <input type="text" name="handle" value="{{ post['handle'] }}" />
        <span>Your Spreadshare URL: <span style="color:#444;">spreadshare.co/USERNAME</span></span>
        <p>Email</p>
        <input type="email" name="email" value="{{ post['email'] }}" />
        <p>Password</p>
        <input type="password" id="password" name="password" />
        <div id="showPassword">
          <img src="/assets/icons/eye.svg" /><span id="showPasswordSpan" onclick="togglePassword('password');">Show Password</span>
        </div>
        <p style="color:darkred;">{{ errorMessage }}</p>
        <div class="signup__content__form__buttons">
          <a href="/login">Login</a>
          <button type="submit">Sign up</button>
        </div>
      </form>
    </div>
    <aside class="signup__content__aside">
      <div class="signup__content__aside__box">
        <a href="/signup">
          <div class="sign-box-selected">Sign up</div>
        </a>
        <a href="/login">
          <div>Sign in</div>
        </a>
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

<script type="text/javascript">
  function togglePassword(target) {
    var d = document;
    var tag = d.getElementById(target);
    var tag2 = d.getElementById('showPasswordSpan');

    if (tag2.innerHTML === 'Show Password') {
      tag.setAttribute('type', 'text');
      tag2.innerHTML = 'Hide Password';

    } else {
      tag.setAttribute('type', 'password');
      tag2.innerHTML = 'Show Password';
    }
  }
</script>
{% endblock %}
