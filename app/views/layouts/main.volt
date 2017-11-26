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
    <a href="javascript:;"><img src="/assets/icons/bell.svg" class="navbar__controls__notification" /></a>
    <a href="javascript:;"><img src="{{ auth.getUser().getImage() }}" class="navbar__controls__profile" id="profileImage" /></a>
    <div class="profile-menu navbar__controls__dropdown">
      <ul>
        <li><a href="/table/add">Create a Table</a></li>
        <li><a href="http://behance.net/patrickserrano">Feed</a></li>
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
      <a href="/login" class="navbar__login__login">Log in</a>
      <span>or</span>
      <a href="/signup" class="navbar__login__signup">Sign up</a>
    </span>
  {% endif %}
</nav>
{# main section #}
<section class="main">
  {# content #}
  {% block content %}{% endblock %}
  {# footer #}
  <footer class="footer">
    <div class="footer__top">
      <div class="footer__top__left">
        <h2>SpreadShare</h2>
        <h3>Community curated Tables</h3>
        <p>Explore community-curated tables for startups and professionals</p>
      </div>
      <div class="footer__top__right">
        <div class="footer__top__right__column footer__top__right__column--first">
          <p>HELLO</p>
          <ul>
            <li><a href="/about">About</a></li>
            <li><a href="/team">Blog</a></li>
          </ul>
        </div>
        <div class="footer__top__right__column footer__top__right__column--second">
          <p>GET INVOLVED</p>
          <ul>
            <li><a href="/jobs">Tasks & Jobs</a></li>
            <li><a href="/feature-voting">Feature Voting</a></li>
            <li><a href="/token">Token</a></li>
            <li><a href="/donate">Contribute</a></li>
          </ul>
        </div>
        <div class="footer__top__right__column footer__top__right__column--third">
          <p>IMPORTANT</p>
          <ul>
            <li><a href="/faq">Frequently Asked</a></li>
            <li><a href="/terms">Terms Of Use</a></li>
            <li><a href="/privacy">Privacy Policy</a></li>
            <li><a href="/disclaimer">Disclaimer</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer__bottom">
      <div class="footer__bottom__rights">
        <p>All Rights Reserved @ spreadshare.co</p>
      </div>
      <div class="footer__bottom__social">
        <ul>
          <li><a href="https://www.facebook.com/groups/403500643362775">Facebook</a></li>
          <li><a href="https://twitter.com/SpreadShareCo">Twitter</a></li>
          <li><a href="https://medium.com/spreadshare">Medium</a></li>
          <li><a href="https://www.producthunt.com/posts/spreadshare">Product Hunt</a></li>
        </ul>
      </div>
    </div>
  </footer>
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

    /* Define API endpoints once and globally */
    $.fn.api.settings.api = {
      'upvote': '/api/v1/vote/{id}',
      'subscribe': '/api/v1/subscribe/{id}',
      'flag': '/table/{id}/flag/{flag}',
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
  });
</script>
<script type="text/javascript" src="/js/react/main.f6706ce4.js"></script>
{% block scripts %}{% endblock %}
</body>
</html>
