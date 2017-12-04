{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
<div class="layout">
  <div class="layout__content">
    <div class="layout__content__wrapper">
      <p class="layout__content__title">Account</p>
      <p class="layout__content__subtitle">
        Manage everything related to your account, profile, wallet and tokens here.
      </p>
      <div class="layout__content__main layout__content__main__account">
        <form method="post">
          <div class="layout__content__main__account__email">
            <div class="layout__content__main__account__column">
              <div class="layout__content__main__account__email__text">
                <p>Email address</p>
              </div>
              <input type="email" name="email" value="{{ profile.email }}" />
            </div>
          </div>
          <div class="layout__content__main__account__password">
            <div class="layout__content__main__account__column">
              <div class="layout__content__main__account__password__text">
                <p>Password</p>
              </div>
              <input type="password" id="password" name="password" value="" />
              <div id="showPassword">
                <img src="/assets/icons/eye.svg" /><span id="showPasswordSpan" onclick="togglePassword('password');">Show Password</span>
              </div>
            </div>
          </div>
          <!--
          <div class="layout__content__main__account__facebook">
            <div class="layout__content__main__account__column">
              <div class="layout__content__main__account__facebook__text">
                <p>Connect to Facebook</p>
              </div>
              <div class="layout__content__main__account__facebook__button">
                <img src="/assets/icons/facebook.svg" />
                <span>Sign up with Facebook</span>
              </div>
              <div class="layout__content__main__account__facebook__info">
                Your Facebook friends (who are also on SpreadShare) will become part of your network on SpreadShare. We will never post without your permission.
              </div>
            </div>
          </div>
          <div class="layout__content__main__account__twitter">
            <div class="layout__content__main__account__column">
              <div class="layout__content__main__account__twitter__text">
                <p>Your are connected to Twitter</p>
              </div>
              <div class="layout__content__main__account__twitter__button connected">
                <img src="/assets/icons/twitter.svg" />
                <span>Disconnect</span>
              </div>
              <div class="layout__content__main__account__twitter__info">
                Connections you have on Twitter (who are also on SpreadShare) have become part of your network on SpreadShare. We will never post or message without your permission.
              </div>
            </div>
          </div>
          -->
          <div class="layout__content__main__account__logout">
            <div class="layout__content__main__account__column">
              <div class="layout__content__main__account__logout__text">
                <p>Log out of your account</p>
              </div>
              <a href="/logout" class="layout__content__main__account__logout__link">
                <div class="layout__content__main__account__logout__link__button">
                  <img src="/assets/icons/log-out.svg" />
                  <span>Logout</span>
                </div>
              </a>
            </div>
          </div>
          <div class="layout__content__main__buttons">
            <a href="/">Cancel</a>
            <button type="submit">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
    <aside class="aside aside--settings">
      <a href="/settings/personal">
        <div class="aside__item"><p>Personal</p></div>
      </a>
      <a href="/settings/account">
        <div class="aside__item item-selected"><p>Account</p></div>
      </a>
      <a href="/settings/notifications">
        <div class="aside__item"><p>Notifications</p></div>
      </a>
      <a href="/settings/connected">
        <div class="aside__item"><p>Connect Accounts</p></div>
      </a>
      <a href="/settings/wallet">
        <div class="aside__item"><p>Wallet</p></div>
      </a>
      <a href="/settings/invite">
        <div class="aside__item"><p>Invite</p></div>
      </a>
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
