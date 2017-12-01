{% extends 'layouts/main.volt' %}

{% block header %}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" />
{% endblock %}

{% block content %}
<form method="post">
    <div class="layout">
        <div class="layout__content">
            <div class="layout__content__wrapper">
                <p class="layout__content__title">Account</p>
                <p class="layout__content__subtitle">
                    Manage everything related to your account, profile, wallet and tokens here.
                </p>
                <div class="layout__content__main layout__content__main__notifications">
                    <div class="layout__content__main__notifications__wrapper">
                        <div class="layout__content__main__notifications__column">
                            <div class="layout__content__main__notifications__text">
                                <p>Customize email notifications</p>
                            </div>
                            <div class="layout__content__main__notifications__switch">
                                <div class="layout__content__main__notifications__column">
                                    <div class="layout__content__main__notifications__row">
                                        <div class="layout__content__main__notifications__switch__buttons">
                                            <input type="hidden" name="followerDigest" value="{{ settings.followerDigest }}" />
                                            <button class="layout__content__main__notifications__switch__buttons layout__content__main__notifications__switch__buttons--left YSwitch {% if settings.followerDigest %}active{% endif %}"
                                                    data-name="followerDigest" value="1">
                                                Y
                                            </button>
                                            <button class="layout__content__main__notifications__switch__buttons layout__content__main__notifications__switch__buttons--right NSwitch  {% if !settings.followerDigest %}active{% endif %}"
                                                    data-name="followerDigest" value="0">
                                                N
                                            </button>
                                        </div>
                                        <div class="layout__content__main__notifications__switch__info">
                                            <p>Follower Digest</p>
                                            <p>We’ll email you with new tables created and recommended by people you follow</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="layout__content__main__notifications__switch">
                                <div class="layout__content__main__notifications__column">
                                    <div class="layout__content__main__notifications__row">
                                        <div class="layout__content__main__notifications__switch__buttons">
                                            <input type="hidden" name="topicDigest" value="{{ settings.topicDigest }}" />
                                            <button class="layout__content__main__notifications__switch__buttons layout__content__main__notifications__switch__buttons--left YSwitch {% if settings.topicDigest %}active{% endif %}"
                                                    data-name="topicDigest" value="1">
                                                Y
                                            </button>
                                            <button class="layout__content__main__notifications__switch__buttons layout__content__main__notifications__switch__buttons--right NSwitch {% if !settings.topicDigest %}active{% endif %}"
                                                    data-name="topicDigest" value="0">
                                                N
                                            </button>
                                        </div>
                                        <div class="layout__content__main__notifications__switch__info">
                                            <p>Topic Digest</p>
                                            <p>We’ll email you occasionally with top stories curated around specific subjects or interests you follow</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="layout__content__main__notifications__switch">
                                <div class="layout__content__main__notifications__column">
                                    <div class="layout__content__main__notifications__row">
                                        <div class="layout__content__main__notifications__switch__buttons">
                                            <input type="hidden" name="newProductAnnouncements" value="{{ settings.newProductAnnouncements }}" />
                                            <button class="layout__content__main__notifications__switch__buttons layout__content__main__notifications__switch__buttons--left YSwitch  {% if settings.newProductAnnouncements %}active{% endif %}"
                                                    data-name="newProductAnnouncements" value="1">
                                                Y
                                            </button>
                                            <button class="layout__content__main__notifications__switch__buttons layout__content__main__notifications__switch__buttons--right NSwitch  {% if !settings.newProductAnnouncements %}active{% endif %}"
                                                    data-name="newProductAnnouncements" value="0">
                                                N
                                            </button>
                                        </div>
                                        <div class="layout__content__main__notifications__switch__info">
                                            <p>New product announcements</p>
                                            <p>We’ll email you when we have news to share about product features on SpreadShare</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--
                          <div class="layout__content__main__notifications__switch">
                            <div class="layout__content__main__notifications__column">
                              <div class="layout__content__main__notifications__row">
                                <div class="layout__content__main__notifications__switch__buttons">
                                  <button type="button" name="newProductAnnouncements" class="layout__content__main__notifications__switch__buttons layout__content__main__notifications__switch__buttons--left YSwitch active" value="1">
                                    Y
                                  </button>
                                  <button class="layout__content__main__notifications__switch__buttons layout__content__main__notifications__switch__buttons--right NSwitch" value="0">
                                    N
                                  </button>
                                </div>
                                <div class="layout__content__main__notifications__switch__info">
                                  <p>All</p>
                                  <p>Turn off all notifications which are not related to a specific table</p>
                                </div>
                              </div>
                            </div>
                          </div>
                            -->
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
                    <a href="/settings/personal">
                        <div>Personal</div>
                    </a>
                    <a href="/settings/account">
                        <div>Account</div>
                    </a>
                    <a href="/settings/notifications">
                        <div class="settings-box-selected">Notifications</div>
                    </a>
                    <a href="/settings/connected">
                        <div>Connect Accounts</div>
                    </a>
                    <a href="/settings/wallet">
                        <div>Wallet</div>
                    </a>
                    <a href="/settings/invite">
                        <div>Invite</div>
                    </a>
                </div>
            </aside>
        </div>
    </div>
</form>
{% endblock %}

{% block scripts %}
<script type="text/javascript">
  $(document).ready(function () {
    window.initOnOffSwitches();
  });
</script>
{% endblock %}
