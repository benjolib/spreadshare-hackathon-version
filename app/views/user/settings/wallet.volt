{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
<div class="layout">
  <div class="layout__content">
    <div class="layout__content__wrapper">
      <p class="layout__content__title">Account</p>
      <p class="layout__content__subtitle">Manage your account and wallet. Invite friends and receive 20 tokens (you invited 10 so far)</p>
      <div class="layout__content__main layout__content__main__wallet">
        <div class="layout__content__main__wallet__stats">
          <div class="layout__content__main__wallet__column">
            <div class="layout__content__main__wallet__stats__text">
              <p>Your token overview</p>
            </div>
            <div class="layout__content__main__wallet__stats__data">
              <p>230,000</p>
              <p><span class="up-arrow-icon">⬆</span><i>2.3%</i> <span>(to last week)<span></p>
            </div>
          </div>
        </div>
        <div class="layout__content__main__wallet__tables">
          <div class="layout__content__main__wallet__column">
            <div class="layout__content__main__wallet__tables__text">
              <p>Your tables</p>
            </div>
            <div class="layout__content__main__wallet__tables__titles">
              <div>
                <p>Table name</p>
              </div>
              <div>
                <p>Your role</p>
                <img src="/assets/icons/sort.svg" />
              </div>
              <div>
                <p>% Ownership</p>
                <img src="/assets/icons/sort.svg" />
              </div>
              <div>
                <p>Tokens earned</p>
                <img src="/assets/icons/sort.svg" />
              </div>
            </div>
            <div class="layout__content__main__wallet__tables__cells">
              <div class="layout__content__main__wallet__tables__cells__item">
                <div>Lorem ipsum</div>
                <div>Owner</div>
                <div>10.12%</div>
                <div>3,245.23</div>
              </div>
              <div class="layout__content__main__wallet__tables__cells__item">
                <div>Lorem ipsum</div>
                <div>Owner</div>
                <div>10.12%</div>
                <div>3,245.23</div>
              </div>
              <div class="layout__content__main__wallet__tables__cells__item">
                <div>Lorem ipsum</div>
                <div>Owner</div>
                <div>10.12%</div>
                <div>3,245.23</div>
              </div>
              <div class="layout__content__main__wallet__tables__cells__item">
                <div>Lorem ipsum</div>
                <div>Owner</div>
                <div>10.12%</div>
                <div>3,245.23</div>
              </div>
              <div class="layout__content__main__wallet__tables__cells__item">
                <div>Lorem ipsum</div>
                <div>Owner</div>
                <div>10.12%</div>
                <div>3,245.23</div>
              </div>
              <div class="layout__content__main__wallet__tables__cells__item">
                <div>Lorem ipsum</div>
                <div>Owner</div>
                <div>10.12%</div>
                <div>3,245.23</div>
              </div>
              <div class="layout__content__main__wallet__tables__cells__item">
                <div>Lorem ipsum</div>
                <div>Owner</div>
                <div>10.12%</div>
                <div>3,245.23</div>
              </div>
              <div class="layout__content__main__wallet__tables__cells__item">
                <div>Lorem ipsum</div>
                <div>Owner</div>
                <div>10.12%</div>
                <div>3,245.23</div>
              </div>
              <div class="layout__content__main__wallet__tables__cells__item">
                <div>Lorem ipsum</div>
                <div>Owner</div>
                <div>10.12%</div>
                <div>3,245.23</div>
              </div>
              <div class="layout__content__main__wallet__tables__cells__item">
                <div>Lorem ipsum</div>
                <div>Owner</div>
                <div>10.12%</div>
                <div>3,245.23</div>
              </div>
              <div class="layout__content__main__wallet__tables__cells__item">
                <div>Lorem ipsum</div>
                <div>Owner</div>
                <div>10.12%</div>
                <div>3,245.23</div>
              </div>
              <div class="layout__content__main__wallet__tables__cells__item">
                <div>Lorem ipsum</div>
                <div>Owner</div>
                <div>10.12%</div>
                <div>3,245.23</div>
              </div>
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
        <a href="/settings/account"><div>Account</div></a>
        <a href="/settings/notifications"><div>Notifications</div></a>
        <a href="/settings/connected"><div>Connect Accounts</div></a>
        <a href="/settings/wallet"><div class="settings-box-selected">Wallet</div></a>
        <a href="/settings/invite"><div>Invite</div></a>
      </div>
    </aside>
  </div>
</div>
{% endblock %}
