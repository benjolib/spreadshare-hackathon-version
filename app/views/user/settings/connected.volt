{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
<form method="post">
  <div class="layout">
    <div class="layout__content">
      <div class="layout__content__wrapper">
        <p class="layout__content__title">Account</p>
        <p class="layout__content__subtitle">Manage everything related to your account, profile, wallet and tokens here.</p>
        <div class="layout__content__main" id="connectedAccounts">
          <div class="connected">
            <div class="connected__item">
              <div class="connected__item__logo" data-social="twitter">
                <img src="/assets/icons/social/twitter.svg" />
              </div>
              <input type="text" name="link[twitter]" value="{{ connections.twitter }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="instagram">
                <img src="/assets/icons/social/instagram.svg" />
                <span>Instagram</span>
              </div>
              <input type="text" name="link[instagram]" value="{{ connections.instagram }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="facebook">
                <img src="/assets/icons/social/facebook.svg" />
                <span>Facebook</span>
              </div>
              <input type="text" name="link[facebook]" value="{{ connections.facebook }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="vsco">
                <img src="/assets/icons/social/vsco.svg" />
                <span>VSCO</span>
              </div>
              <input type="text" name="link[vsco]" value="{{ connections.vsco }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="medium">
                <img src="/assets/icons/social/medium.svg" />
                <span>Medium</span>
              </div>
              <input type="text" name="link[medium]" value="{{ connections.medium }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="soundcloud">
                <img src="/assets/icons/social/soundcloud.svg" />
                <span>SoundCloud</span>
              </div>
              <input type="text" name="link[soundcloud]" value="{{ connections.soundcloud }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="dribbble">
                <img src="/assets/icons/social/dribbble.svg" />
                <span>Dribbble</span>
              </div>
              <input type="text" name="link[dribbble]" value="{{ connections.dribbble }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="vimeo">
                <img src="/assets/icons/social/vimeo.svg" />
                <span>Vimeo</span>
              </div>
              <input type="text" name="link[vimeo]" value="{{ connections.vimeo }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="behance">
                <img src="/assets/icons/social/behance.svg" />
                <span>Behance</span>
              </div>
              <input type="text" name="link[behance]" value="{{ connections.behance }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="twitch">
                <img src="/assets/icons/social/twitch.svg" />
                <span>Twitch</span>
              </div>
              <input type="text" name="link[twitch]" value="{{ connections.twitch }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="github">
                <img src="/assets/icons/social/github.svg" />
                <span>GitHub</span>
              </div>
              <input type="text" name="link[github]" value="{{ connections.github }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="patreon">
                <img src="/assets/icons/social/patreon.svg" />
                <span>Patreon</span>
              </div>
              <input type="text" name="link[patreon]" value="{{ connections.patreon }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="gitlab">
                <img src="/assets/icons/social/gitlab.svg" />
                <span>Gitlab</span>
              </div>
              <input type="text" name="link[gitlab]" value="{{ connections.gitlab }}" />
            </div>
            <div class="connected__item">
              <!-- UNKNWON - FIX -->
              <div class="connected__item__logo" data-social="deviantart">
                <img src="/assets/icons/social/deviantart.svg" />
                <span>DeviantArt</span>
              </div>
              <input type="text" name="link[deviantart]" value="{{ connections.deviantart }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="bitbucket">
                <img src="/assets/icons/social/bitbucket.svg" />
                <span>BitBucket</span>
              </div>
              <input type="text" name="link[bitbucket]" value="{{ connections.bitbucket }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="periscope">
                <img src="/assets/icons/social/periscope.svg" />
                <span>Periscope</span>
              </div>
              <input type="text" name="link[periscope]" value="{{ connections.periscope }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="slack">
                <img src="/assets/icons/social/slack.svg" />
                <span>Slack</span>
              </div>
              <input type="text" name="link[slack]" value="{{ connections.slack }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="500px">
                <img src="/assets/icons/social/500px.svg" />
                <span>500px</span>
              </div>
              <input type="text" name="link[fivehundretpx]" value="{{ connections.fivehundretpx }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="angellist">
                <img src="/assets/icons/social/angellist.svg" />
                <span>AngelList</span>
              </div>
              <input type="text" name="link[angellist]" value="{{ connections.angellist }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="codepen">
                <img src="/assets/icons/social/codepen.svg" />
                <span>Codepen</span>
              </div>
              <input type="text" name="link[codepen]" value="{{ connections.codepen }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="googleplus">
                <img src="/assets/icons/social/googleplus.svg" />
                <span>Google+</span>
              </div>
              <input type="text" name="link[googleplus]" value="{{ connections.googleplus }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="bloglovin">
                <img src="/assets/icons/social/bloglovin.svg" />
                <span>Bloglovin</span>
              </div>
              <input type="text" name="link[bloglovin]" value="{{ connections.bloglovin }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="stackoverflow">
                <img src="/assets/icons/social/stackoverflow.svg" />
                <span>Stackoverflow</span>
              </div>
              <input type="text" name="link[stackoverflow]" value="{{ connections.stackoverflow }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="raspberrypi">
                <img src="/assets/icons/social/raspberrypi.svg" />
                <span>RaspberryPi</span>
              </div>
              <input type="text" name="link[raspberrypi]" value="{{ connections.raspberrypi }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="linkedin">
                <img src="/assets/icons/social/linkedin.svg" />
                <span>LinkedIn</span>
              </div>
              <input type="text" name="link[linkedin]" value="{{ connections.linkedin }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="discord">
                <img src="/assets/icons/social/discord.svg" />
                <span>Discord</span>
              </div>
              <input type="text" name="link[discord]" value="{{ connections.discord }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="quora">
                <img src="/assets/icons/social/quora.svg" />
                <span>Quora</span>
              </div>
              <input type="text" name="link[quora]" value="{{ connections.quora }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="youtube">
                <img src="/assets/icons/social/youtube.svg" />
                <span>YouTube</span>
              </div>
              <input type="text" name="link[youtube]" value="{{ connections.youtube }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="reddit">
                <img src="/assets/icons/social/reddit.svg" />
                <span>Reddit</span>
              </div>
              <input type="text" name="link[reddit]" value="{{ connections.reddit }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="bandcamp">
                <img src="/assets/icons/social/bandcamp.svg" />
                <span>Bandcamp</span>
              </div>
              <input type="text" name="link[bandcamp]" value="{{ connections.bandcamp }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="ycombinator">
                <img src="/assets/icons/social/ycombinator.svg" />
                <span>YCombinator</span>
              </div>
              <input type="text" name="link[ycombinator]" value="{{ connections.ycombinator }}" />
            </div>
            <div class="connected__item">
              <div class="connected__item__logo" data-social="producthunt">
                <img src="/assets/icons/social/producthunt.svg" />
                <span>ProductHunt</span>
              </div>
              <input type="text" name="link[producthunt]" value="{{ connections.producthunt }}" />
            </div>
          </div>
          <div class="layout__content__main__buttons">
            <a href="/">Cancel</a>
            <button type="submit">Save Changes</button>
          </div>
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
          <div class="aside__item item-selected"><p>Connect Accounts</p></div>
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
</form>
{% endblock %}
