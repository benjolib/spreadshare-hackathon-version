{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - {{ profile.name }}{% endblock %}

{% block header %}
{% endblock %}

{% block content %}
<div class="re-page">
  <div class="profile-info u-flex u-sm-flexCol u-md-flexRow u-flexJustifyBetween u-md-flexAlignItemsStart">
    <div class="profile-info__col1">
      <h1 class="profile-name">{{ profile.name }}</h1>
			<h3 class="profile-tagline">{{ profile.tagline }}</h3>
			<div class="status">
				<a href="#" class="status-link-green"><span>154</span> FOLLOWERS</a>
				<a href="#"><span>45</span> FOLLOWING</a>
			</div>
			<div class="social-links">
				<a href="#">Berlin</a>
				<a href="#" class="social-link-green">Spreadshare Co</a>
				<a href="#">Medium</a>
				<a href="#">Dribble</a>
				<a href="#">LinkedIn</a>
				<a href="#">Github</a>
				<a href="#">Twitter</a>
				<a href="#">Facebook</a>
			</div>
      <div class="profile-buttons">
        {% if auth.loggedIn() and auth.getUserId() != profile.id %}
          <a class="follow-button" href="#">Follow</a>
        {% endif %}

        {% if auth.loggedIn() and auth.getUserId() == profile.id %}
          <a class="edit-button" href="#">Edit</a>
          <div class="save-and-cancel">
            <a class="save-button" href="#">Save</a>
            <a class="cancel-button" href="#">Cancel</a>
          </div>
        {% endif %}
      </div>
    </div>
    <div class="profile-info__col2">
      <div class="profile-image" id="changeProfileImage" style="background: url({{ profile.image }}) center / cover;">
        <div id="profile-image-upload" class="profile-image-upload"></div>
      </div>
      <input type="file" name="image" id="fileUpload" style="display: none;" />
      <div class="profile-buttons">
        {% if auth.loggedIn() and auth.getUserId() != profile.id %}
          <a class="follow-button small-follow-button" href="#">Follow</a>
        {% endif %}

        {% if auth.loggedIn() and auth.getUserId() == profile.id %}
          <a class="edit-button small-edit-button" href="#">Edit</a>
          <div class="save-and-cancel">
            <a class="save-button small-save-button" href="#">Save</a>
            <a class="cancel-button small-cancel-button" href="#">Cancel</a>
          </div>
        {% endif %}
      </div>
    </div>
  </div>
  {% if auth.loggedIn() and auth.getUserId() != profile.id %}
    <div class="u-flex u-flexWrap small-gutter">
      {# {% for subscriber in tablemodel.tableSubscription %} #}
        <div class="list-tab-content-subscribers__card">
          {{ partial('partials/profile-card', [
            'id': 1,
            'username': 'andrewcoyle',
            'avatar': 'https://pbs.twimg.com/profile_images/983400206711455745/PsX5Kquv_400x400.jpg',
            'name': 'Andrew Coyle',
            'bio': 'Designing the future of global trade @Flexport. Sharing curated lists on Spreadshare.',
            'type': 10,
            'truncate': true
          ]) }}
        </div>
        <div class="list-tab-content-subscribers__card">
          {{ partial('partials/profile-card', [
            'id': 1,
            'username': 'andrewcoyle',
            'avatar': 'https://pbs.twimg.com/profile_images/983400206711455745/PsX5Kquv_400x400.jpg',
            'name': 'Andrew Coyle',
            'bio': 'Designing the future of global trade @Flexport. Sharing curated lists on Spreadshare.',
            'type': 10,
            'truncate': true
          ]) }}
        </div>
        <div class="list-tab-content-subscribers__card">
          {{ partial('partials/profile-card', [
            'id': 1,
            'username': 'andrewcoyle',
            'avatar': 'https://pbs.twimg.com/profile_images/983400206711455745/PsX5Kquv_400x400.jpg',
            'name': 'Andrew Coyle',
            'bio': 'Designing the future of global trade @Flexport. Sharing curated lists on Spreadshare.',
            'type': 10,
            'truncate': true
          ]) }}
        </div>
        <div class="list-tab-content-subscribers__card">
          {{ partial('partials/profile-card', [
            'id': 1,
            'username': 'andrewcoyle',
            'avatar': 'https://pbs.twimg.com/profile_images/983400206711455745/PsX5Kquv_400x400.jpg',
            'name': 'Andrew Coyle',
            'bio': 'Designing the future of global trade @Flexport. Sharing curated lists on Spreadshare.',
            'type': 10,
            'truncate': true
          ]) }}
        </div>
        <div class="list-tab-content-subscribers__card">
          {{ partial('partials/profile-card', [
            'id': 1,
            'username': 'andrewcoyle',
            'avatar': 'https://pbs.twimg.com/profile_images/983400206711455745/PsX5Kquv_400x400.jpg',
            'name': 'Andrew Coyle',
            'bio': 'Designing the future of global trade @Flexport. Sharing curated lists on Spreadshare.',
            'type': 10,
            'truncate': true
          ]) }}
        </div>
        <div class="list-tab-content-subscribers__card">
          {{ partial('partials/profile-card', [
            'id': 1,
            'username': 'andrewcoyle',
            'avatar': 'https://pbs.twimg.com/profile_images/983400206711455745/PsX5Kquv_400x400.jpg',
            'name': 'Andrew Coyle',
            'bio': 'Designing the future of global trade @Flexport. Sharing curated lists on Spreadshare.',
            'type': 10,
            'truncate': true
          ]) }}
        </div>
        <div class="list-tab-content-subscribers__card">
          {{ partial('partials/profile-card', [
            'id': 1,
            'username': 'andrewcoyle',
            'avatar': 'https://pbs.twimg.com/profile_images/983400206711455745/PsX5Kquv_400x400.jpg',
            'name': 'Andrew Coyle',
            'bio': 'Designing the future of global trade @Flexport. Sharing curated lists on Spreadshare.',
            'type': 10,
            'truncate': true
          ]) }}
        </div>
        <div class="list-tab-content-subscribers__card">
          {{ partial('partials/profile-card', [
            'id': 1,
            'username': 'andrewcoyle',
            'avatar': 'https://pbs.twimg.com/profile_images/983400206711455745/PsX5Kquv_400x400.jpg',
            'name': 'Andrew Coyle',
            'bio': 'Designing the future of global trade @Flexport. Sharing curated lists on Spreadshare.',
            'type': 10,
            'truncate': true
          ]) }}
        </div>
      {# {% else %}
        <div class="empty-subscribers">
          No Subscribers
        </div>
      {% endfor %} #}
    </div>
  {% endif %}

  {% if auth.loggedIn() and auth.getUserId() == profile.id %}
    <div class="u-flex u-flexWrap big-gutter">
      {{ partial('partials/list-card', [
        'id': 1,
        'slug': 'berlin-living',
        'image': 'http://www.babooka.nl/content/images/thumbs/0001984_living-in-style-berlin.jpeg',
        'name': 'Berlin Living',
        'description': 'Looking for a flat? Get the most recent market updates, curated by Airbnb',
        'subscriberCount': 239,
        'listingCount': 100,
        'showCurator': false,
        'half': true,
        'large': false
      ]) }}
      {{ partial('partials/list-card', [
        'id': 1,
        'slug': 'berlin-living',
        'image': 'http://www.babooka.nl/content/images/thumbs/0001984_living-in-style-berlin.jpeg',
        'name': 'Berlin Living',
        'description': 'Looking for a flat? Get the most recent market updates, curated by Airbnb',
        'subscriberCount': 239,
        'listingCount': 100,
        'showCurator': false,
        'half': true,
        'large': false
      ]) }}
      {{ partial('partials/list-card', [
        'id': 1,
        'slug': 'berlin-living',
        'image': 'http://www.babooka.nl/content/images/thumbs/0001984_living-in-style-berlin.jpeg',
        'name': 'Berlin Living',
        'description': 'Looking for a flat? Get the most recent market updates, curated by Airbnb',
        'subscriberCount': 239,
        'listingCount': 100,
        'showCurator': false,
        'half': true,
        'large': false
      ]) }}
      {{ partial('partials/list-card', [
        'id': 1,
        'slug': 'berlin-living',
        'image': 'http://www.babooka.nl/content/images/thumbs/0001984_living-in-style-berlin.jpeg',
        'name': 'Berlin Living',
        'description': 'Looking for a flat? Get the most recent market updates, curated by Airbnb',
        'subscriberCount': 239,
        'listingCount': 100,
        'showCurator': false,
        'half': true,
        'large': false
      ]) }}
      {{ partial('partials/list-card', [
        'id': 1,
        'slug': 'berlin-living',
        'image': 'http://www.babooka.nl/content/images/thumbs/0001984_living-in-style-berlin.jpeg',
        'name': 'Berlin Living',
        'description': 'Looking for a flat? Get the most recent market updates, curated by Airbnb',
        'subscriberCount': 239,
        'listingCount': 100,
        'showCurator': false,
        'half': true,
        'large': false
      ]) }}
      {{ partial('partials/list-card', [
        'id': 1,
        'slug': 'berlin-living',
        'image': 'http://www.babooka.nl/content/images/thumbs/0001984_living-in-style-berlin.jpeg',
        'name': 'Berlin Living',
        'description': 'Looking for a flat? Get the most recent market updates, curated by Airbnb',
        'subscriberCount': 239,
        'listingCount': 100,
        'showCurator': false,
        'half': true,
        'large': false
      ]) }}
    </div>
  {% endif %}
</div>
{# <div class="profile">
  {{ flash.output() }}
  <div class="profile__hero">
    <div class="profile__row">
      <div class="profile__hero__avatar">
        <img src="{{ profile.image }}" />
      </div>
      <div class="profile__hero__info">
        <div class="profile__hero__info__name"><h3>{{ profile.name }}{% if settings.showTokensOnProfilePage %} <span class="profile__hero__info__tokens">{{ userWallet.getTokens() }} Tokens</span>{% endif %}</h3></div>
        <div class="profile__hero__info__tagline">
          <p>{{ profile.tagline }}</p>
        </div>
        <div class="profile__row profile__row">
          <div class="profile__hero__info__location">
            {% if profile.location %}
            <p>{{profile.location}}</p>
            {% endif %}
          </div>
          <div class="profile__hero__info__website">
            {% if profile.website %}
            <span>●</span>
            <a href="{{ profile.website }}" target="_blank">{{profile.website}}</a>
            {% endif %}
          </div>
          <div class="profile__hero__info__mobile">
            <div class="profile__hero__info__mobile__website">
              {% if profile.website %}
              <a href="{{profile.website}}" target="_blank">{{profile.website}}</a>
              <span>●</span>
              {% endif %}
            </div>
            <div class="profile__hero__info__mobile__social">
              <ul>
                {% for connection in connections %}
                <li><a href="{{ connection['link'] }}"><img src="/assets/icons/social/{{ connection['name'] }}.svg" /></a></li>
                {% endfor %}
              </ul>
            </div>
          </div>
        </div>
        <div class="profile__row profile__row--pushToBottom">
          {% if auth.loggedIn() and auth.getUserId() != profile.id %}
          <div class="profile__hero__info__edit">
            {% if following %}
            <button class="follow-user following-user" data-id="{{ profile.id }}" type="button"></button>
            {% else %}
            <button class="follow-user not-following-user selected" data-id="{{ profile.id }}" type="button"></button>
            {% endif %}
          </div>
          {% endif %}

          {% if auth.loggedIn() and auth.getUserId() == profile.id %}
          <div class="profile__hero__info__edit">
            <button onclick="window.location.href='/settings/personal';">Edit</button>
          </div>
          {% endif %}
          <div class="profile__hero__info__social">
            <ul>
              {% for connection in connections %}
              <li><a href="{{ connection['link'] }}"><img src="/assets/icons/social/{{ connection['name'] }}.svg" /></a></li>
              {% endfor %}
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container container--usersAndTables">
    {% if tables is defined AND tables %}
      {{ partial('user/profile/tables') }}
    {% elseif users is defined AND users %}
      {{ partial('user/profile/users') }}
    {% else %}
      <div class="container__content" style="margin-right:40px;">
        <div class="container__content center" style="width:100%;padding: 40px;">
          <div class="center" style="width:100%;">
            <img src="/assets/images/desktop.png" alt="" />
            <p>&nbsp;</p>
            <p>There are no items available for your filter "<strong>{{ currentPage }}</strong>".</p>
          </div>
        </div>
      </div>
    {% endif %}
    {{ partial('user/profileAside') }}
  </div>
</div> #}
{% endblock %}

{% block scripts %}
  <script type="text/javascript">
    $(document).ready(function () {
      var profileName;
      var profileTagline;
      var profileImage;

      document.querySelector('input[type="file"]').addEventListener('change', function () {
        if (this.files && this.files[0]) {
          var img = $('#changeProfileImage');
          img.attr('style', 'background: url(' + URL.createObjectURL(this.files[0]) + ') center / cover;');
          //img.onload = fn;
        }
      });

      document.getElementById('profile-image-upload').onclick = function () {
        document.getElementById('fileUpload').click();
      };

      $('.profile-buttons .edit-button').on('click', function () {
        profileName = $('.profile-info__col1 .profile-name').text();
        profileTagline = $('.profile-info__col1 .profile-tagline').text();
        profileImage = $('#changeProfileImage').attr('style');

        $('.profile-buttons').addClass('profile-buttons--editing');
        $('.profile-image-upload').addClass('profile-image-upload--editing');
        $('.profile-info__col1 .profile-name').attr('contenteditable', 'true');
        $('.profile-info__col1 .profile-tagline').attr('contenteditable', 'true');
      });

      $('.profile-buttons .cancel-button').on('click', function () {
        $('.profile-buttons').removeClass('profile-buttons--editing');
        $('.profile-image-upload').removeClass('profile-image-upload--editing');
        $('.profile-info__col1 .profile-name').attr('contenteditable', 'false');
        $('.profile-info__col1 .profile-tagline').attr('contenteditable', 'false');
        $('.profile-info__col1 .profile-name').text(profileName);
        $('.profile-info__col1 .profile-tagline').text(profileTagline);
        $('#changeProfileImage').attr('style', profileImage);
      });

      $('.profile-buttons .save-button').on('click', function () {
        $('.profile-buttons').removeClass('profile-buttons--editing');
        $('.profile-image-upload').removeClass('profile-image-upload--editing');
        $('.profile-info__col1 .profile-name').attr('contenteditable', 'false');
        $('.profile-info__col1 .profile-tagline').attr('contenteditable', 'false');
        profileName = $('.profile-info__col1 .profile-name').text();
        profileTagline = $('.profile-info__col1 .profile-tagline').text();
        profileImage = $('#changeProfileImage').attr('style');
        // TODO: fill in some form values and submit, or do an ajax request.
        window.createAlert('success', 'Profile Saved', 'Your profile has been saved!')
      });
    });
  </script>
{% endblock %}
