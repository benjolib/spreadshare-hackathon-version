{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - Sign Up{% endblock %}

{% block content %}
{{ flash.output() }}
<div class="signup">
  <div class="signup__content">
    <div class="signup__content__wrapper">
      <p class="signup__content__title">Join now</p>
      <p class="signup__content__subtitle">Discover and contribute to the community of data lovers.</p>
      <form class="signup__content__form" method="post">
        <div class="flex-display">
          <div class="display-flex">
            <p>Your name</p>
            <input name="name" value="{{ post['name'] }}" autofocus="" type="text"></br>
            <p class="signup-field-msg">We’re big on real names around here, so people know who’s who</p>
            {% if errors['name'] is defined %}<p class="signup-field-error">{{ errors['name'] }}</p>{% endif %}
          </div>
          <div class="display-flex">
            <p>Username</p>
            <input name="handle" value="{{ post['handle'] }}" type="text"></br>
            <p class="signup-field-msg">Your Spreadshare URL: <span>spreadshare.co/USERNAME</span></p>
            {% if errors['handle'] is defined %}<p class="signup-field-error">{{ errors['handle'] }}</p>{% endif %}
          </div>
        </div>

        <div class="flex-display">
          <div class="display-flex">
            <p>Email</p>
            <input type="email" name="email" value="{{ post['email'] }}" />
            {% if errors['email'] is defined %}<p class="signup-field-error">{{ errors['email'] }}</p>{% endif %}
          </div>
          <div class="display-flex">
            <p>Password</p>
            <input type="password" id="password" name="password" />
            <div id="showPassword">
              <img src="/assets/icons/eye.svg" /><span id="showPasswordSpan" onclick="togglePassword('password');">Show Password</span>
            </div>
            {% if errors['password'] is defined %}<p class="signup-field-error">{{ errors['password'] }}</p>{% endif %}
          </div>
        </div>
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
          <a href="/login/facebook">Connect via Facebook</a>
        </div>
        <div class="signup__content__aside__social__twitter">
          <img src="/assets/icons/twitter.svg" />
          <a href="/login/twitter">Connect via Twitter</a>
        </div>
        <div class="signup__content__aside__social__google">
          <img src="/assets/icons/google.svg" />
          <a href="/login/google">Connect via Google</a>
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
