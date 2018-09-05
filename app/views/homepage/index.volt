{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - Data that matters.{% endblock %}
{% block header %}
{% endblock %}

{% block content %}
<div class="re-page re-page--medium">
    <div class="homepage-space">
        <h1 class="re-heading">Explore</h1>
        <h2 class="re-subheading re-subheading--button-below">We curate the best Streams for you every day</h2>
    </div>

{% if tag is defined %}
    <div class="home-heading u-flex">
        <div class="selected-topics__items">
            <a href="javascript:history.back()">
                <div>{{ tag }} x</div>
            </a>
        </div>
    </div>
{% endif %}

    <div class="u-flex u-flexWrap big-gutter home-top-margin-bottom" >

{% set rendered_index = -1 %}

{% set cur_section_rendered_num = 0 %}

{% for index, table in tables %}

    {% if index <= rendered_index %}
        {% continue %}
    {% endif %}
    {% if tables[index] is not defined %}
        {% continue %}
    {% endif %}
    {% if tables[index][ 'featured'] is not "1" %}
        {% continue %}
    {% endif %}

    {% if cur_section_rendered_num < 5 %}
        {% set cur_section_rendered_num = cur_section_rendered_num + 1 %}
        {% set rendered_index = index %}
        {{ partial('partials/list-card', [
            'id': tables[index]['id'],
            'slug': tables[index]['slug'],
            'image': tables[index]['image'],
            'name': tables[index]['title'],
            'description': tables[index]['tagline'],
            'subscriberCount': tables[index]['subscriberCount'],
            'listingCount': tables[index]['listingCount'],
            'showCurator': true,
            'curatorHandle': tables[index]['creatorHandle'],
            'curatorAvatar': tables[index]['creatorImage'],
            'curatorName': tables[index]['creator'],
            'curatorBio': tables[index]['creatorBio'],
            'half': false,
            'large': false
        ]) }}
    {% endif %}

    {% if cur_section_rendered_num == 3 %}
        {{ partial('partials/action-card', [
            'color': 'orange-bird',
            'heading': 'Follow topics, not people',
            'text': 'Keep track of your favorite topics.<br /><br />Our curators and the community will feed you with updates. In your feed and as summaries to your inbox.',
            'action': '/subscriptions',
            'buttonText': 'Manage Subscriptions'
        ]) }}
    {% endif %}

{% endfor %}
    </div>
</div>


<div class="trending-topics">
    <div class="trending-topics__inner">
        <h3>Trending Tags</h3>
{% if featuredTags %}
        <div class="trending-topics__items">
    {% for featuredTag in featuredTags %}
            <a href="/tag/{{ featuredTag['id'] }}"><div>{{ featuredTag['title'] }}</div></a>
    {% endfor %}
        </div>
{% endif %}
    </div>
</div>


<div class="re-page re-page--medium">
    <div class="u-flex u-flexWrap homepage-gutter">

{% set cur_section_rendered_num = 0 %}

{% for index, table in tables %}

    {% if index <= rendered_index %}
        {% continue %}
    {% endif %}
    {% if tables[index] is not defined %}
        {% continue %}
    {% endif %}
    {% if tables[index][ 'featured'] is not "1" %}
        {% continue %}
    {% endif %}

    {% if cur_section_rendered_num < 6 %}
        {% set cur_section_rendered_num = cur_section_rendered_num + 1 %}
        {% set rendered_index = index %}
        {{ partial( 'partials/list-card', [
            'id': tables[index]['id'],
            'slug': tables[index]['slug'],
            'image': tables[index]['image'],
            'name': tables[index]['title'],
            'description': tables[index]['tagline'],
            'subscriberCount': tables[index]['subscriberCount'],
            'listingCount': tables[index]['listingCount'],
            'showCurator': true,
            'curatorHandle': tables[index]['creatorHandle'],
            'curatorAvatar': tables[index]['creatorImage'],
            'curatorName': tables[index]['creator'],
            'curatorBio': tables[index]['creatorBio'],
            'half': false,
            'large': false
        ]) }}
    {% endif %}

    {% if cur_section_rendered_num == 1 %}
        {{ partial('partials/action-card', [
            'color': 'blue-octopus',
            'heading': 'Suggest a Curator',
            'text': 'Have someone in mind who should curate a Stream here?<br /><br />Please let us know.',
            'action': '/stream/our-curators',
            'buttonText': 'Recommend Someone'
        ]) }}
    {% endif %}

    {% if cur_section_rendered_num == 4 %}
        {{ partial('partials/action-card', [
            'color': 'purple-whale',
            'heading': 'Become a Curator',
            'text': 'Start curating a Stream. <br /><br />And shape the way your subscribers are being informed.',
            'action': '/stream/become-a-curator',
            'buttonText': 'Claim Curator Pass'
        ]) }}
    {% endif %}

    {% if cur_section_rendered_num == 4 %}
        {{ partial('partials/action-card', [
            'color': 'green-lightning',
            'heading': 'Work with us',
            'text': 'Engineering, design, content or community. Reach out to us if you want to join our journey.<br /><br />PS: We work remotely.',
            'action': 'mailto:hi@spreadshare.co',
            'buttonText': 'Write us'
        ]) }}
    {% endif %}
{% endfor %}
    </div>
</div>


<div class="wrapdigital">
    <div class="digital-expert">
        <div class="inner">
        </div>
        <div class="info">
            <div class="heading">Research as a Service</div>
            <div class="subheading">
                Need help from digital experts? Get your research tasks done.
            </div>
        </div>
        <div class="action u-sm-flexWrap u-sm-flexCol u-md-flexRow u-sm-flexGrow2 u-flexAlignItemsCenter">
            <button onclick="window.location.href='/stream/get-a-task-done'">Request Task</button>
            <button onclick="window.location.href='/stream/become-a-researcher'" class="transparent">Earn money as a Researcher</button>
        </div>
    </div>
</div>


<div class="re-page re-page--medium">
    <div class="u-flex u-flexWrap homepage-gutter">
{% set cur_section_rendered_num = 0 %}
{% for index, table in tables %}

    {% if index <= rendered_index %}
        {% continue %}
    {% endif %}
    {% if tables[index] is not defined %}
        {% continue %}
    {% endif %}
    {% if tables[index][ 'featured'] is not "1" %}
        {% continue %}
    {% endif %}

    {% if cur_section_rendered_num < 6 %}
        {% set cur_section_rendered_num = cur_section_rendered_num + 1 %}
        {% set rendered_index = index %}
        {{ partial( 'partials/list-card', [
            'id': tables[index]['id'],
            'slug': tables[index]['slug'],
            'image': tables[index]['image'],
            'name': tables[index]['title'],
            'description': tables[index]['tagline'],
            'subscriberCount': tables[index]['subscriberCount'],
            'listingCount': tables[index]['listingCount'],
            'showCurator': true,
            'curatorHandle': tables[index]['creatorHandle'],
            'curatorAvatar': tables[index]['creatorImage'],
            'curatorName': tables[index][ 'creator'],
            'curatorBio': tables[index]['creatorBio'],
            'half': false,
            'large': false
        ]) }}
    {% endif %}
{% endfor %}
    </div>
</div>


<div class="featured-curators">
    <div class="featured-curators__inner">
        <h3>Featured Curators</h3>
        <div class="u-flex u-sm-flexWrap">
{% for index, featuredCurator in featuredCurators %}
    {% if index < 9 %}
        {{ partial('partials/profile-card', [
            'id': featuredCurator['id'],
            'username': featuredCurator['handle'],
            'avatar': featuredCurator["image"],
            'name': featuredCurator["name"],
            'bio': featuredCurator["tagline"],
            'type': 4,
            'truncate':true
        ]) }}
    {% endif %}
{% endfor %}
        </div>
    </div>
</div>


<div class="re-page re-page--medium">
    <div id="load-more-container" class="u-flex u-flexWrap homepage-gutter">
{% set cur_section_rendered_num = 0 %}
{% for index, table in tables %}

    {% if index <= rendered_index %}
        {% continue %}
    {% endif %}
    {% if tables[index] is not defined %}
        {% continue %}
    {% endif %}
    {% if tables[index][ 'featured'] is not "1" %}
        {% continue %}
    {% endif %}

    {% if cur_section_rendered_num < 6 %}
        {% set cur_section_rendered_num = cur_section_rendered_num + 1 %}
        {% set rendered_index = index %}
        {{ partial( 'partials/list-card', [
            'id': tables[index]['id'],
            'slug': tables[index]['slug'],
            'image': tables[index]['image'],
            'name': tables[index]['title'],
            'description': tables[index]['tagline'],
            'subscriberCount': tables[index]['subscriberCount'],
            'listingCount': tables[index]['listingCount'],
            'showCurator': true,
            'curatorHandle': tables[index]['creatorHandle'],
            'curatorAvatar': tables[index]['creatorImage'],
            'curatorName': tables[index]['creator'],
            'curatorBio': tables[index]['creatorBio'],
            'half': false,
            'large': false
        ]) }}
    {% endif %}
{% endfor %}
    </div>
</div>

<div class="u-flex u-flexJustifyCenter">
    <a href="#" class="re-button re-button--load-more" {{ moreItemsAvailable ? '' : 'style="display:none;"' }}>Load More</a>
</div>

{% endblock %}

{% block scripts %}
<script type="text/javascript">
    $(document).ready(function () {
        var pageNumber = 1;

        $('.re-button--load-more').on('click', function (e) {
            e.preventDefault();
            $.ajax(window.location.pathname + '?page=' + pageNumber)
                .done(function (response) {
                    console.log(response);
                    if (response) {
                        $('#load-more-container').append(response);
                        pageNumber += 1;
                        if (!$('<div>' + response + '</div>').find('.moreItemsAvailable').val()) {
                            $('.re-button--load-more').hide();
                        }
                    }
                });
        });
    });
</script>
{% endblock %}
