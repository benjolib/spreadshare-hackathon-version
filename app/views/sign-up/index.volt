{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
<p class="sign-in-up-pretext">CONTRIBUTE</p>
<h3 class="sign-in-up-heading">Almost there</h3>
<p class="sign-in-up-text">Finish creating your account</p>
<form class="sign-up-form" action="/">
  <label class="re-field">
    <img class="re-field__image re-field__image-default" src="/assets/images/circle-default.svg" />
    <img class="re-field__image re-field__image-success" src="/assets/images/circle-success.svg" />
    <img class="re-field__image re-field__image-error" src="/assets/images/circle-cross.svg" />
    <div>
        <div class="re-field__label">USERNAME</div>
        <input id="username" class="re-field__input" type="text" name="username" placeholder="Your Username" />
    </div>
  </label>

  <label class="re-field">
    <img class="re-field__image re-field__image-default" src="/assets/images/circle-default.svg" />
    <img class="re-field__image re-field__image-success" src="/assets/images/circle-success.svg" />
    <img class="re-field__image re-field__image-error" src="/assets/images/circle-cross.svg" />
    <div>
        <div class="re-field__label">EMAIL</div>
        <input id="email" class="re-field__input" type="text" name="email" placeholder="Your Email Address" />
    </div>
  </label>

  <button id="sign-up-submit" class="sign-up-form-submit">Create Account</button>
  <a href="#" class="sign-up-already-account-link">I already have an account</a>
</form>
{% endblock %}

{% block scripts %}
  <script type="text/javascript">
    $(document).ready(function () {
      $('#username').val('');
      $('#email').val('');

      // username can't be blank
      $('#username').on('input', function() {
        var $input = $(this);
        var $field = $(this).parents('.re-field');

        if ($input.val()) {
          $field.removeClass('re-field--error').addClass('re-field--success');
        } else {
          $field.removeClass('re-field--success').addClass('re-field--error');
        }
      });

      // email must be an email
      $('#email').on('input', function() {
        var $input = $(this);
        var $field = $(this).parents('.re-field');

        var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

        if (re.test($input.val())) {
          $field.removeClass('re-field--error').addClass('re-field--success');
        } else {
          $field.removeClass('re-field--success').addClass('re-field--error');
        }
      });

      // prevent submission not all fields valid
      $("#sign-up-submit").click(function (e) {
        var $usernameField = $('#username').parents('.re-field');
        var $emailField = $('#email').parents('.re-field');
        var isValidUsername = $usernameField.hasClass('re-field--success');
        var isValidEmail = $emailField.hasClass('re-field--success');

        if (!isValidUsername || !isValidEmail) {
          e.preventDefault();
          if (!isValidUsername) {
            window.createAlert('error', 'Username invalid', 'Please enter a valid username');
            $usernameField.removeClass('re-field--success').addClass('re-field--error');
          }
          if (!isValidEmail) {
            window.createAlert('error', 'Email invalid', 'Please enter a valid email address');
            $emailField.removeClass('re-field--success').addClass('re-field--error');
          }
        }
      });
    });
  </script>
{% endblock %}
