<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,800" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
  <link rel="stylesheet" href="/css/styles.css">
  <link href="/css/main.508c7389.css" rel="stylesheet">
  {% block header %}{% endblock %}
  <title>{% block title %}{% endblock %}</title>
</head>
<body>
{# navbar #}
<nav class="navbar">
  <div class="navbar__logo">
    <a href="/"><h1>SpreadShare</h1></a>
    <h2>Community curated Tables</h2>
  </div>
  <div class="navbar__search">
    <div class="navbar__search__icon">
      <img src="/assets/icons/search.svg" />
    </div>
    <input type="text" class="navbar__search__field" placeholder="Find anything" />
    <div class="navbar__search__filter">
      <img class="navbar__search__filter__icon" src="/assets/icons/filter.svg" />
    </div>
  </div>
  {% if auth.loggedIn() %}
  <div class="navbar__controls">
    <img src="/assets/icons/add.svg" class="navbar__controls__add" />
    <a href="javascript:;"><img src="/assets/icons/bell.svg" class="navbar__controls__notification" /></a>
    <a href="javascript:;"><img src="{{ auth.getUser().getImage() }}" class="navbar__controls__profile" id="profileImage" /></a>
    <div class="profile-menu navbar__controls__dropdown">
      <ul>
        <li><a href="/table/add">Create a Table</a></li>
        <li><a href="/feed">Feed</a></li>
        <li><a href="/user/{{ auth.getUser().handle }}">Profile</a></li>
        <li><a href="/settings/wallet">Wallet</a></li>
        <li><a href="/settings/invite">Get Token</a></li>
        <li><a href="/settings/account">Settings</a></li>
        <li><a href="/logout">Sign out</a></li>
      </ul>
    </div>
  </div>

  {% else %}
  <span class="navbar__login">
      <a href="/login" class="navbar__login__login">Login</a>
      <span>or</span>
      <a href="/signup" class="navbar__login__signup">Sign up</a>
    </span>
  {% endif %}
</nav>
{# main section #}
<section class="main">
  {{ flash.output() }}

  {# content #}
  {% block content %}{% endblock %}

  {# footer #}
  {{ partial('layouts/footer') }}
</section>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script>
<script type="text/javascript" src="/js/api.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
    /* Popper */
    var referenceElement;
    var onPopper = $('.profile-menu');

    // initial state
    if (window.innerWidth < 1024) {
      referenceElement = $('.navbar__controls__add');
    } else {
      referenceElement = $('.navbar__controls__notification');
    }
    new Popper(referenceElement, onPopper, {
      placement: 'bottom',
    });

    // event listener
    $(window).resize(function () {
      if (window.innerWidth < 1024) {
        referenceElement = $('.navbar__controls__add');
      } else {
        referenceElement = $('.navbar__controls__notification');
      }
      new Popper(referenceElement, onPopper, {
        placement: 'bottom',
      });
    });

    //toggle menu
    $('#profileImage').click(function () {
      $(onPopper).toggleClass('show');
    });

    // flash messages timeout
    var $flash = $('.flash');
    if ($flash.length > 0) {
      setTimeout(function () {
        $flash.css('display', 'none');
      }, 3800);
    }

    /* Define API endpoints once and globally */
    $.fn.api.settings.api = {
      'upvote': '/api/v1/vote/{id}',
      'subscribe': '/api/v1/subscribe/{id}',
      'flag': '/table/{id}/flag/{flag}',
      'follow-user': '/api/v1/follow-user/{id}',
    };

    $('div.upvote, button.upvote').api({
      method: 'POST',
      onSuccess: function (response, button) {
        var span = button.find('span');
        if (response.data.voted) {
          button.addClass('selected');
          span.text(parseInt(parseInt(span.text()) + 1));
        } else {
          button.removeClass('selected');
          span.text(parseInt(parseInt(span.text()) - 1));
        }
      },
    });
    $('button.subscribe').api({
      method: 'POST',
      onSuccess: function (response, button) {
        if (response.data.subscribed) {
          button.addClass('subscribed');
        } else {
          button.removeClass('subscribed');
        }
      },
    });
    $('button.follow-user').api({
      method: 'POST',
      action: 'follow-user',
      onRequest: showLoading,
      onSuccess: function (response, button) {
        $(button).toggleClass('selected').toggleClass('following-user').toggleClass('not-following-user');
      },
    });
  });
</script>
<script type="text/javascript" src="/js/react/main.f1ea3b65.js"></script>
{% block scripts %}{% endblock %}
</body>
</html>
