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
      <div class="layout__content__main layout__content__main__invite">
        <div class="layout__content__main__invite__email">
          <div class="layout__content__main__invite__column">
            <div class="layout__content__main__invite__email__text">
              <p>Invite by email</p>
            </div>
            <div class="layout__content__main__invite__email__field">
              <input type="email" placeholder="Enter Email Address" autofocus />
              <div>
                <span>Send</span>
              </div>
            </div>
          </div>
        </div>
        <div class="layout__content__main__invite__share">
          <div class="layout__content__main__invite__column">
            <div class="layout__content__main__invite__share__text">
              <p>Share invite link</p>
            </div>
            <div class="layout__content__main__invite__share__field">
              <input type="text" value="https://spreadshare.co/jh3b42" readonly />
              <div>
                <span>Copy</span>
              </div>
            </div>
          </div>
        </div>
        <!--
        <div class="layout__content__main__invite__contacts">
          <div class="layout__content__main__invite__column">
            <div class="layout__content__main__invite__contacts__text">
              <p>Import contacts</p>
            </div>
            <div class="layout__content__main__invite__row">
              <div class="layout__content__main__invite__contacts__social layout__content__main__invite__contacts__social--twitter">
                <img src="/assets/icons/twitter.svg" />
              </div>
              <div class="layout__content__main__invite__contacts__social layout__content__main__invite__contacts__social--facebook">
                <img src="/assets/icons/facebook.svg" />
              </div>
              <div class="layout__content__main__invite__contacts__social layout__content__main__invite__contacts__social--gmail">
                <img src="/assets/icons/gmail.svg" />
              </div>
            </div>
          </div>
        </div>
        <div class="layout__content__main__invite__friends">
          <div class="layout__content__main__invite__column">
            <div class="layout__content__main__invite__friends__text">
              <p>Invite your Twitter friends</p>
            </div>
            <div class="layout__content__main__invite__row">
              <div class="layout__content__main__invite__friends__invitation">
                <div class="layout__content__main__invite__column">
                  <img src="/assets/images/mike.png" />
                  <span>Mike</span>
                  <div class="layout__content__main__invite__row">
                    <div class="layout__content__main__invite__friends__invitation__accept">
                      <img src="/assets/icons/confirm.svg" />
                    </div>
                    <div class="layout__content__main__invite__friends__invitation__reject">
                      <img src="/assets/icons/cancel.svg" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="layout__content__main__invite__friends__invitation">
                <div class="layout__content__main__invite__column">
                  <img src="/assets/images/eleven.png" />
                  <span>Eleven</span>
                  <div class="layout__content__main__invite__row">
                    <div class="layout__content__main__invite__friends__invitation__accept">
                      <img src="/assets/icons/confirm.svg" />
                    </div>
                    <div class="layout__content__main__invite__friends__invitation__reject">
                      <img src="/assets/icons/cancel.svg" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="layout__content__main__invite__friends__invitation">
                <div class="layout__content__main__invite__column">
                  <img src="/assets/images/dustin.jpg" />
                  <span>Dustin</span>
                  <div class="layout__content__main__invite__row">
                    <div class="layout__content__main__invite__friends__invitation__accept">
                      <img src="/assets/icons/confirm.svg" />
                    </div>
                    <div class="layout__content__main__invite__friends__invitation__reject">
                      <img src="/assets/icons/cancel.svg" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="layout__content__main__invite__friends__invitation">
                <div class="layout__content__main__invite__column">
                  <img src="/assets/images/lucas.png" />
                  <span>Lucas</span>
                  <div class="layout__content__main__invite__row">
                    <div class="layout__content__main__invite__friends__invitation__accept">
                      <img src="/assets/icons/confirm.svg" />
                    </div>
                    <div class="layout__content__main__invite__friends__invitation__reject">
                      <img src="/assets/icons/cancel.svg" />
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        <div class="layout__content__main__buttons">
          <a href="/">Cancel</a>
          <button type="submit">Save Changes</button>
        </div>
        -->
      </div>
    </div>
    <aside class="layout__content__aside">
      <div class="layout__content__aside__box">
        <a href="/settings/personal">
          <div>Personal</div>
        </a>
        <a href="/settings/account">
          <div>Account</div>
        </a>
        <a href="/settings/notifications">
          <div>Notifications</div>
        </a>
        <a href="/settings/connected">
          <div>Connect Accounts</div>
        </a>
        <a href="/settings/wallet">
          <div>Wallet</div>
        </a>
        <a href="/settings/invite">
          <div class="settings-box-selected">Invite</div>
        </a>
      </div>
    </aside>
  </div>
</div>
{% endblock %}
