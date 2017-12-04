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
      <div class="layout__content__main layout__content__main__invite">
        <p>Inviting is not possible, yet. Stay tuned for an update!</p>

        <p>In the meantime, we'd be happy if you could spread the word on social media</p>
        <p>
          <div class="socialshares" data-url="http://www.spreadshare.co" data-title="Community curated tables!" data-description="" data-size="small" data-theme="brand" data-icononly>
            <div class="socialshares-twitter"></div>
            <div class="socialshares-facebook"></div>
            <div class="socialshares-googleplus"></div>
            <div class="socialshares-reddit"></div>
            <div class="socialshares-tumblr"></div>
            <div class="socialshares-linkedin"></div>
            <div class="socialshares-pinterest"></div>
            <div class="socialshares-slack"></div>
            <div class="socialshares-vk"></div>
            <div class="socialshares-email"></div>
          </div>
        </p>

        <!--
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
    <aside class="aside aside--settings">
      <a href="/settings/personal">
        <div class="aside__item"><p>Personal</p></div>
      </a>
      <a href="/settings/account">
        <div class="aside__item"><p>Account</p></div>
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
        <div class="aside__item item-selected"><p>Invite</p></div>
      </a>
    </aside>
  </div>
</div>

<script src="https://unpkg.com/socialshares@2/dist/socialshares.min.js" defer></script>
{% endblock %}
