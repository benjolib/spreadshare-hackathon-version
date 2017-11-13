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
      <div class="layout__content__main layout__content__main__personal">
        <div class="layout__content__main__personal__profile">
          <div class="layout__content__main__personal__column">
            <div class="layout__content__main__personal__profile__text">
              <p>Profile Photo</p>
            </div>
            <div class="layout__content__main__personal__row">
              <div class="layout__content__main__personal__profile__photo">
                <img src="/assets/images/jim_hopper.png" />
              </div>
              <div class="layout__content__main__personal__profile__add">
                <button>Replace</button>
              </div>
              <div class="layout__content__main__personal__profile__remove">
                <a href="#">Remove</a>
              </div>
            </div>
          </div>
        </div>
        <div class="layout__content__main__personal__name">
          <div class="layout__content__main__personal__column">
            <div class="layout__content__main__personal__name__text">
              <p>Full name</p>
            </div>
            <input type="text" value="Jim Hopper" />
          </div>
        </div>
        <div class="layout__content__main__personal__username">
          <div class="layout__content__main__personal__column">
            <div class="layout__content__main__personal__username__text">
              <p>Username</p>
            </div>
            <input type="text" value="@jim_hopper" />
          </div>
        </div>
        <div class="layout__content__main__personal__tagline">
          <div class="layout__content__main__personal__column">
            <div class="layout__content__main__personal__tagline__text">
              <p>Tagline</p>
            </div>
            <input type="text" value="Police chief in Hawkins, Indiana." />
            <span>Max <i>140</i> characters</span>
          </div>
        </div>
        <div class="layout__content__main__personal__locations">
          <div class="layout__content__main__personal__column">
            <div class="layout__content__main__personal__locations__text">
              <p>Locations</p>
            </div>
            <div class="layout__content__main__personal__locations__tags">
              <div class="layout__content__main__personal__locations__tags__item">
                <div class="layout__content__main__personal__locations__tags__item__text">
                  Indiana
                </div>
                <div class="layout__content__main__personal__locations__tags__item__close">
                  <img src="/assets/icons/close.svg" />
                </div>
              </div>
              <div class="layout__content__main__personal__locations__tags__item">
                <div class="layout__content__main__personal__locations__tags__item__text">
                  United States
                </div>
                <div class="layout__content__main__personal__locations__tags__item__close">
                  <img src="/assets/icons/close.svg" />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="layout__content__main__personal__website">
          <div class="layout__content__main__personal__column">
            <div class="layout__content__main__personal__website__text">
              <p>Website</p>
            </div>
            <input type="text" value="" />
          </div>
        </div>
        <div class="layout__content__main__personal__switch">
          <div class="layout__content__main__personal__column">
            <div class="layout__content__main__personal__switch__text">
              <p>Show tokens on profile page</p>
            </div>
            <div class="layout__content__main__personal__row">
              <div class="layout__content__main__personal__switch__buttons">
                <div class="layout__content__main__personal__switch__buttons layout__content__main__personal__switch__buttons--left active">
                  On
                </div>
                <div class="layout__content__main__personal__switch__buttons layout__content__main__personal__switch__buttons--right">
                  Off
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="layout__content__main__buttons">
          <a href="/signup">Cancel</a>
          <button type="submit">Save Changes</button>
        </div>
      </div>
    </div>
    <aside class="layout__content__aside">
      <div class="layout__content__aside__box">
        <a href="#"><div class="sign-box-selected">Personal</div></a>
        <a href="#"><div>Account</div></a>
        <a href="#"><div>Notifications</div></a>
        <a href="#"><div>Connect Accounts</div></a>
        <a href="#"><div>Wallet</div></a>
        <a href="#"><div>Invite</div></a>
        </a>
      </div>
    </aside>
  </div>
</div>
{% endblock %}
