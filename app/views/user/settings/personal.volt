{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
<form method="post" enctype="multipart/form-data">
  <div class="layout">
    <div class="layout__content">
      <div class="layout__content__wrapper">
        <p class="layout__content__title">Account</p>
        <p class="layout__content__subtitle">
          Manage everything related to your account, profile, wallet and tokens here.
        </p>
        <div class="layout__content__main layout__content__main__personal">
          <div class="layout__content__main__personal__profile">
            <div class="layout__content__main__personal__column">
              <div class="layout__content__main__personal__profile__text">
                <p>Profile Photo</p>
              </div>
              <div class="layout__content__main__personal__row">
                <div class="layout__content__main__personal__profile__photo">
                  <img class="profileImage" id="profileImage" src="{{ profile.image }}" />
                </div>
                <div class="layout__content__main__personal__profile__add">
                  <button type="button" id="profileImageReplace">Replace</button>
                </div>
                <div class="layout__content__main__personal__profile__remove">
                  <a href="javascript:" onclick="removeImage();">Remove</a>
                </div>
                <input type="hidden" name="removeProfileImage" id="removeProfileImage" value="0" />
                <input type="file" name="image" id="fileUpload" style="opacity:0; height:0;width:0;" />
              </div>
            </div>
          </div>
          <div class="layout__content__main__personal__name">
            <div class="layout__content__main__personal__column">
              <div class="layout__content__main__personal__name__text">
                <p>Full name</p>
              </div>
              <input type="text" name="name" value="{{ profile.name }}" />
            </div>
          </div>
          <div class="layout__content__main__personal__username">
            <div class="layout__content__main__personal__column">
              <div class="layout__content__main__personal__username__text">
                <p>Username</p>
              </div>
              <input type="text" name="handle" value="{{ profile.handle }}" />
            </div>
          </div>
          <div class="layout__content__main__personal__tagline">
            <div class="layout__content__main__personal__column">
              <div class="layout__content__main__personal__tagline__text">
                <p>Tagline</p>
              </div>
              <input type="text" name="tagline" value="{{ profile.tagline }}" />
              <span>Max <i>140</i> characters</span>
            </div>
          </div>
          <div class="layout__content__main__personal__locations">
            <div class="layout__content__main__personal__column">
              <div class="layout__content__main__personal__locations__text">
                <p>Locations</p>
              </div>
              <div id="LocationSelect" data-name="locations[]" data-value="{{ locations }}" data-placeholder="Add a location" class="react-component"></div>
            </div>
          </div>
          <div class="layout__content__main__personal__website">
            <div class="layout__content__main__personal__column">
              <div class="layout__content__main__personal__website__text">
                <p>Website</p>
              </div>
              <input type="text" name="website" value="{{ profile.website }}" />
            </div>
          </div>

          <div class="layout__content__main__personal__switch">
            <div class="layout__content__main__personal__column">
              <div class="layout__content__main__personal__switch__text">
                <p>Show tokens on profile page</p>
              </div>
              <div class="switch">
                <input type="hidden" name="showTokensOnProfilePage" value="{{ settings.showTokensOnProfilePage }}" />
                <button type="button" class="switch switch--left YSwitch {% if settings.showTokensOnProfilePage %}active{% endif %}"
                    data-name="showTokensOnProfilePage" value="1">
                  Y
                </button>
                <button type="button" class="switch switch--right NSwitch {% if !settings.showTokensOnProfilePage %}active{% endif %}"
                    data-name="showTokensOnProfilePage" value="0">
                  N
                </button>
              </div>
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
            <div class="aside__item item-selected"><p>Personal</p></div>
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
            <div class="aside__item"><p>Invite</p></div>
          </a>
      </aside>
    </div>
  </div>
</form>

<script type="text/javascript">
  window.addEventListener('load', function () {
  document.querySelector('input[type="file"]').addEventListener('change', function () {
    if (this.files && this.files[0]) {
    var img = document.querySelector('img.profileImage');
    img.src = URL.createObjectURL(this.files[0]);
    //img.onload = fn;
    }
  });

  window.initOnOffSwitches();
  });

  document.getElementById('profileImageReplace').onclick = function () {
  document.getElementById('fileUpload').click();
  };

  function removeImage() {
  document.getElementById('removeProfileImage').value = '1';
  document.getElementById('profileImage').src = '';
  }
</script>
{% endblock %}
