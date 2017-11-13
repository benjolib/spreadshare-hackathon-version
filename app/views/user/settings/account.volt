{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
<div class="layout">
  <div class="layout__content">
    <div class="layout__content__wrapper">
      <p class="layout__content__title">Account</p>
      <p class="layout__content__subtitle">
        Manage your account and wallet. Invite friends and receive 20 tokens (you invited 10 so far)
      </p>
      <div class="layout__content__main layout__content__main__account">
        <div class="layout__content__main__account__email">
          <div class="layout__content__main__account__column">
            <div class="layout__content__main__account__email__text">
              <p>Email address</p>
            </div>
            <input type="email" value="jim.hopper@strangerthings.com" />
          </div>
        </div>
        <div class="layout__content__main__account__password">
          <div class="layout__content__main__account__column">
            <div class="layout__content__main__account__password__text">
              <p>Password</p>
            </div>
            <input type="password" value="somerandompassword" />
            <span>Show Password</span>
          </div>
        </div>
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
        <div class="layout__content__main__account__logout">
          <div class="layout__content__main__account__column">
            <div class="layout__content__main__account__logout__text">
              <p>Log out of your account</p>
            </div>
            <div class="layout__content__main__account__logout__button">
              <img src="/assets/icons/log-out.svg" />
              <span>Logout</span>
            </div>
          </div>
        </div>
        <div class="layout__content__main__buttons">
          <a href="/">Cancel</a>
          <button type="submit">Save Changes</button>
        </div>
      </div>
    </div>
    <aside class="layout__content__aside">
      <div class="layout__content__aside__box">
        <a href="/settings/personal"><div>Personal</div></a>
        <a href="/settings/account"><div class="settings-box-selected">Account</div></a>
        <a href="/settings/notifications"><div>Notifications</div></a>
        <a href="/settings/connected"><div>Connect Accounts</div></a>
        <a href="/settings/wallet"><div>Wallet</div></a>
        <a href="/settings/invite"><div>Invite</div></a>
      </div>
    </aside>
  </div>
</div>
{% endblock %}
