{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - Settings{% endblock %}

{% block header %}
{% endblock %}

{% block content %}
  <div class="re-page">
    <h1 class="re-heading">Settings</h1>
    <h2 class="re-subheading">Manage your profile and acount.</h2>

    <form method="post" enctype="multipart/form-data">
      <div class="settings-tabs">
        <div class="settings-tabs__inner">
          <div class="settings-tabs-buttons">
            <a href="#" class="settings-tabs-button settings-tabs-button-user active">User</a>
            <a href="#" class="settings-tabs-button settings-tabs-button-emails">Emails</a>
          </div>

          <div class="settings-tab-content settings-tab-content-user">
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">NAME</div>
                  <input id="name" class="re-field__input" type="text" name="name" placeholder="Your Name" value="{{ profile.name }}" />
              </div>
            </label>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">USERNAME</div>
                  <input id="handle" class="re-field__input" type="text" name="handle" placeholder="Your Username" value="{{ profile.handle }}" />
              </div>
            </label>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">TAGLINE</div>
                  <input id="tagline" class="re-field__input" type="text" name="tagline" placeholder="Your Tagline" value="{{ profile.tagline }}" />
              </div>
            </label>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">FROM</div>
                  <input id="from" class="re-field__input" type="text" name="from" placeholder="Your Homeland" value="" />
              </div>
            </label>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">LINK</div>
                  <input id="website" class="re-field__input" type="text" name="website" placeholder="Your Link" value="{{ profile.website }}" />
              </div>
            </label>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">EMAIL</div>
                  <input id="email" class="re-field__input" type="text" name="email" placeholder="Your Email" value="{{ profile.email }}" />
              </div>
            </label>
            <!-- <label class="re-field re-field--settings"> -->
              <!-- <div>
                  <div class="re-field__label">PASSWORD <span id="showPasswordSpan" class="show-password" onclick="togglePassword('password');">Show</span></div> -->
                  <input id="password" class="re-field__input" type="hidden" name="password" placeholder="Your Password" value="" autocomplete="new-password" />
              <!-- </div>
            </label> -->
            <h3 class="settings-seperator-heading">Social Accounts</h3>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">TWITTER</div>
                  <input id="link-twitter" class="re-field__input" type="text" name="link[twitter]" placeholder="Your Twitter Profile URL" value="{{ connections.twitter }}" />
              </div>
            </label>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">FACEBOOK</div>
                  <input id="link-facebook" class="re-field__input" type="text" name="link[facebook]" placeholder="Your Facebook Profile URL" value="{{ connections.facebook }}" />
              </div>
            </label>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">MEDIUM</div>
                  <input id="link-medium" class="re-field__input" type="text" name="link[medium]" placeholder="Your Medium Profile URL" value="{{ connections.medium }}" />
              </div>
            </label>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">YOUTUBE</div>
                  <input id="link-youtube" class="re-field__input" type="text" name="link[youtube]" placeholder="Your Youtube Profile URL" value="{{ connections.youtube }}" />
              </div>
            </label>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">INSTAGRAM</div>
                  <input id="link-instagram" class="re-field__input" type="text" name="link[instagram]" placeholder="Your Instagram Profile URL" value="{{ connections.instagram }}" />
              </div>
            </label>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">LINKEDIN</div>
                  <input id="link-linkedin" class="re-field__input" type="text" name="link[linkedin]" placeholder="Your LinkedIn Profile URL" value="{{ connections.linkedin }}" />
              </div>
            </label>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">PATREON</div>
                  <input id="link-patreon" class="re-field__input" type="text" name="link[patreon]" placeholder="Your Patreon Profile URL" value="{{ connections.patreon }}" />
              </div>
            </label>
          </div>

          <div class="settings-tab-content settings-tab-content-emails" style="display: none;">
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">SUMMARIES</div>
                  <p>We email you summaries of your subscriptions</p>
              </div>
              <div>
<a href="/subscriptions" class="manage-subscriptions-link">Manage Subscriptions</a>
              </div>
            </label>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">NEW PUBLICATION</div>
                  <p>We email you when users you follow publish new publications</p>
              </div>
              <div>
                <label class="on-off-switch">
                  <input type="checkbox" />
                  <div class="on-off">
                    <span class="on">On</span>
                    <span class="off">Off</span>
                  </div>
                </label>
              </div>
            </label>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">FRIENDS</div>
                  <p>We email you when friends join Spreadshare</p>
              </div>
              <div>
                <label class="on-off-switch">
                  <input type="checkbox" />
                  <div class="on-off">
                    <span class="on">On</span>
                    <span class="off">Off</span>
                  </div>
                </label>
              </div>
            </label>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">FOLLOWER</div>
                  <p>We email you if you have a new follower</p>
              </div>
              <div>
                <label class="on-off-switch">
                  <input type="checkbox" />
                  <div class="on-off">
                    <span class="on">On</span>
                    <span class="off">Off</span>
                  </div>
                </label>
              </div>
            </label>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">BEST OF THE WEEK</div>
                  <p>We email you a curation of the best publications of a week</p>
              </div>
              <div>
                <label class="on-off-switch">
                  <input type="checkbox" />
                  <div class="on-off">
                    <span class="on">On</span>
                    <span class="off">Off</span>
                  </div>
                </label>
              </div>
            </label>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">PRODUCT UPDATES</div>
                  <p>We email you updates to our product every month</p>
              </div>
              <div>
                <label class="on-off-switch">
                  <input type="checkbox" />
                  <div class="on-off">
                    <span class="on">On</span>
                    <span class="off">Off</span>
                  </div>
                </label>
              </div>
            </label>
            <h3 class="settings-seperator-heading">For Curators</h3>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">CURATOR INFORMED</div>
                  <p>We email you with updates to our collaborations</p>
              </div>
              <div>
                <label class="on-off-switch">
                  <input type="checkbox" />
                  <div class="on-off">
                    <span class="on">On</span>
                    <span class="off">Off</span>
                  </div>
                </label>
              </div>
            </label>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">POST REVIEWED</div>
                  <p>We email you with updates to our collaborations</p>
              </div>
              <div>
                <label class="on-off-switch">
                  <input type="checkbox" />
                  <div class="on-off">
                    <span class="on">On</span>
                    <span class="off">Off</span>
                  </div>
                </label>
              </div>
            </label>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">POST REVIEWED</div>
                  <p>We email you with updates to our collaborations</p>
              </div>
              <div>
                <label class="on-off-switch">
                  <input type="checkbox" />
                  <div class="on-off">
                    <span class="on">On</span>
                    <span class="off">Off</span>
                  </div>
                </label>
              </div>
            </label>
            <h3 class="settings-seperator-heading">For Collaborators</h3>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">PENDING COLLABORATIONS</div>
                  <p>We email you with pending collaborations</p>
              </div>
              <div>
                <label class="on-off-switch">
                  <input type="checkbox" />
                  <div class="on-off">
                    <span class="on">On</span>
                    <span class="off">Off</span>
                  </div>
                </label>
              </div>
            </label>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">NEW COLLABORATION</div>
                  <p>We email you with new collaborations</p>
              </div>
              <div>
                <label class="on-off-switch">
                  <input type="checkbox" />
                  <div class="on-off">
                    <span class="on">On</span>
                    <span class="off">Off</span>
                  </div>
                </label>
              </div>
            </label>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">NEW SUBSCRIBER</div>
                  <p>We email you with new subscriptions</p>
              </div>
              <div>
                <label class="on-off-switch">
                  <input type="checkbox" />
                  <div class="on-off">
                    <span class="on">On</span>
                    <span class="off">Off</span>
                  </div>
                </label>
              </div>
            </label>
            <label class="re-field re-field--settings">
              <div>
                  <div class="re-field__label">NEW COMMENT</div>
                  <p>We email you with new comments</p>
              </div>
              <div>
                <label class="on-off-switch">
                  <input type="checkbox" />
                  <div class="on-off">
                    <span class="on">On</span>
                    <span class="off">Off</span>
                  </div>
                </label>
              </div>
            </label>
          </div>

        </div>
      </div>
      <div class="u-flex u-flex u-flexJustifyCenter small-gutter" style="margin-top: 30px;">
        <input type="reset" value="Cancel" class="re-button re-button--grey small-margin" /> <input type="submit" value="Save" class="re-button small-margin" />
      </div>
      <div class="u-flex u-flexCol u-flexAlignItemsCenter" style="margin-top: 40px;">
        <a href="/logout" class="re-button re-button--light-grey re-button-logout">Logout</a>
        <a href="#" class="settings-delete-account-button">Delete Account</a>
      </div>
    </form>
  </div>
{% endblock %}

{% block scripts %}
  <script type="text/javascript">
    function togglePassword(target) {
      var d = document;
      var tag = d.getElementById(target);
      var tag2 = d.getElementById('showPasswordSpan');

      if (tag2.innerHTML === 'Show') {
        tag.setAttribute('type', 'text');
        tag2.innerHTML = 'Hide';

      } else {
        tag.setAttribute('type', 'password');
        tag2.innerHTML = 'Show';
      }
    }
    $(document).ready(function () {
 $("#handle").on({ keydown: function(e) { if (e.which === 32) return false; }, change: function() { this.value = this.value.replace(/\s/g,
""); } });

      $('.settings-tabs-button-user').on('click', function (e) {
        e.preventDefault();
        $('.settings-tabs-button').removeClass('active');
        $('.settings-tabs-button-user').addClass('active');
        $('.settings-tab-content').hide();
        $('.settings-tab-content-user').show();
      });
 if(window.location.href.indexOf("#emails") !== -1){
 $('.settings-tabs-button').removeClass('active');
        $('.settings-tabs-button-emails').addClass('active');
        $('.settings-tab-content').hide();
        $('.settings-tab-content-emails').show();
 }
      $('.settings-tabs-button-emails').on('click', function (e) {
        e.preventDefault();
        $('.settings-tabs-button').removeClass('active');
        $('.settings-tabs-button-emails').addClass('active');
        $('.settings-tab-content').hide();
        $('.settings-tab-content-emails').show();
      });
    });
  </script>
{% endblock %}
