{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - {{ profile.name }}{% endblock %}

{% block header %}
{% endblock %}

{% block content %}
    <form id="profileData" name="profileData" method="post" action="/user/profileUpdate" enctype="multipart/form-data">
        <input type="hidden" id="name" name="name" value=""/>
        <input type="hidden" id="tagline" name="tagline" value=""/>
        <input type="file" name="image" id="fileUpload" style="display: none;"/>
    </form>
    <div class="re-page">
        <div class="profile-info u-flex u-sm-flexCol u-md-flexRow u-flexJustifyBetween u-md-flexAlignItemsStart">
            <div class="profile-info__col1">
                <h1 class="profile-name">{{ profile.name }}</h1>
                <h3 class="profile-tagline">{{ profile.tagline }}</h3>
                <div class="status">
                 {% if currentPage == 'following' %}
                   <a href="/user/{{ profile.handle }}/followers"><span>{{ numFollowers }}</span> FOLLOWERS</a>
                    <a href="/user/{{ profile.handle }}/following" class="status-link-green"><span>{{ numFollowing }}</span> FOLLOWING</a>
                 {% else %}
                    <a href="/user/{{ profile.handle }}/followers" class="status-link-green"><span>{{ numFollowers }}</span> FOLLOWERS</a>
                    <a href="/user/{{ profile.handle }}/following"><span>{{ numFollowing }}</span> FOLLOWING</a>
                 {% endif %}
                    
                </div>
                <div class="social-links">
                    {% for connection in connections %}
                        <a href="{{ connection['link'] }}">{{ connection['name'] }}</a>
                    {% endfor %}
                </div>
                <div class="profile-buttons">
                    {% if auth.loggedIn() and auth.getUserId() != profile.id %}
                        <a class="follow-button" href="/user/follow/{{ profile.id }}">{% if amIFollowing(profile.id) %}Unfollow{% else %}Follow{% endif %}</a>
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
                <div class="profile-image" id="changeProfileImage"
                     style="background: url({{ profile.image }}) center / cover;">
                    <div id="profile-image-upload" class="profile-image-upload"></div>
                </div>
                <div class="profile-buttons">
                    {% if auth.loggedIn() and auth.getUserId() != profile.id %}
                        <a class="follow-button small-follow-button" href="#">{% if amIFollowing(profile.id) %}Unfollow{% else %}Follow{% endif %}</a>
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
        {% if currentPage == 'following' or currentPage == 'folowers' %}
            <div class="u-flex u-flexWrap med-gutter">
                {% for user in users %}
                <div class="list-tab-content-subscribers__card">
                    {{ partial('partials/profile-card', [
                        'id': user['id'],
                        'username': user['handle'],
                        'avatar': user['image'],
                        'name': user['name'],
                        'bio': user['tagline'],
                        'type': 10,
                        'truncate': true
                    ]) }}
                </div>
                {% endfor %}
            </div>
        {% endif %}

        {% if currentPage == "upvoted" %}
            <div class="u-flex u-flexWrap big-gutter">
                {% for createdList in createdLists %}
                {{ partial('partials/list-card', [
                    'id': createdList['id'],
                    'slug': createdList['slug'],
                    'image': createdList['image'],
                    'name': createdList['title'],
                    'description': createdList['description'],
                    'subscriberCount': createdList['subscriberCount'],
                    'listingCount': createdList['listingCount'],
                    'showCurator': false,
                    'small': true,
                    'half': false,
                    'large': false
                ]) }}
                {% endfor %}
            </div>
        {% endif %}
    </div>
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
                $('#name').val($('.profile-name').text());
                $('#tagline').val($('.profile-tagline').text());
                $('#profileData').submit();
                // TODO: fill in some form values and submit, or do an ajax request.
                window.createAlert('success', 'Profile Saved', 'Your profile has been saved!')
            });
        });
    </script>
{% endblock %}
