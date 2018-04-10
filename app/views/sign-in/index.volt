{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
<p class="sign-in-up-pretext">WELCOME</p>
<h3 class="sign-in-up-heading">Start subscribing and curating lists</h3>
<p class="sign-in-up-text sign-in-up-text--large">Please sign in</p>
<div class="sign-in-options">
  <button class="sign-in-button sign-in-facebook" onclick="location.href='/sign-up';" >
    <img class="img-fb" src="/assets/images/sign-in-facebook.svg" />
    Continue with Facebook
  </button>
  <button class="sign-in-button sign-in-twitter" onclick="location.href='/sign-up';">
    <img class="img-twit" src="/assets/images/sign-in-twitter.svg" />
    Continue with Twitter
  </button>
  <button class="sign-in-button sign-in-google" onclick="location.href='/sign-up';">
    <img class="img-goog" src="/assets/images/sign-in-google.svg" />
    Continue with Google
  </button>
  <p class="sign-in-privacy">Besides getting your name and profile image we’re not doing anything else with your data.</p>
</div>
{% endblock %}

{% block scripts %}
  <script type="text/javascript">
    $(document).ready(function () {

    });
  </script>
{% endblock %}
