{% extends 'layouts/main.volt' %}

{% block header %}
<style>
  .introduction .content img {
    float: left;
  }

  .introduction .content a {
    color: white;
  }

  .introduction .content a:hover {
    color: #f0f0f0;
  }

  .introduction .content {
    color: white;
  }

  .display {
    margin-bottom: 5px;
  }

  .display.name {
    font-size: 175%;
    font-weight: 700;
  }

  .display.city,
  .display.description {
    color: #ddd;
    font-weight: 400;
  }

  .display.handle {
    font-weight: 300;
  }

  .display.handle a.social {
    margin-left: 10px;
  }
</style>
{% endblock %}

{% block content %}
<div class="ui main aligned">
  <div class="ui segment" style="background: #69819d;">
    <div class="introduction">

      <div class="ui grid content" style="margin:40px;">
        <div class="three wide column">
          <img class="ui small circular image middle aligned" src="{{ profile.getImage() }}">
        </div>
        <div class="thirteen wide column" style="padding-top:50px;">
          <div class="ui grid content">
            <div class="thirteen wide column">
              <h1 class="display name">{{ profile.getName() }}</h1>
              <div class="display handle">
                <a href="/user/{{ profile.getHandle()}}">@{{ profile.getHandle() }}</a>
                <span class="city"> | {{ profile.getCity() }}</span>
                {% if profile.getTwitterUrl() %}
                <a class="social" href="{{ profile.getTwitterUrl() }}"><i class="ui twitter icon"></i></a>
                {% endif %}
                {% if profile.getFacebookUrl() %}
                <a class="social" href="{{ profile.getFacebookUrl() }}"><i class="ui facebook icon"></i></a>
                {% endif %}
              </div>
            </div>
            <div class="three wide column right aligned ui statistics">
              <div class="ui inverted tiny  statistic">
                <div class="value">
                  {{ profile.huntCount }}
                </div>
                <div class="label">
                  DeckHunts
                </div>
              </div>
            </div>
          </div>
          <div class="display description">{{ profile.getDescription() }}</div>
        </div>
      </div>

    </div>
  </div>

  <div class="ui text container ui top attached segment">
    <h4 class="ui header">Tables</h4>
    <div class="ui divider" style="margin-bottom:-5px;"></div>

    <div class="ui large feed relaxed divided list">

    </div>

  </div>
</div>

{% endblock %}