<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600,800" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
  <link rel="stylesheet" href="/css/styles.css">
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
      <a href="#"><img src="/assets/icons/add.svg" class="navbar__controls__add" /></a>
      <a href="#"><img src="/assets/icons/bell.svg" class="navbar__controls__notification" /></a>
      <a href="/settings/personal"><img src="{{ auth.getUser().getImage() }}" class="navbar__controls__profile" id="profileImage" /></a>
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
          <p>About</p>
          <ul>
            <li>Vision</li>
            <li>Team</li>
            <li>Press</li>
            <li>Invest</li>
            <li>Donate</li>
            <li>Jobs</li>
          </ul>
        </div>
        <div class="footer__top__right__column footer__top__right__column--second">
          <p>Useful links</p>
          <ul>
            <li>Feature Voting</li>
            <li>Table Guideline</li>
            <li>Frequently Asked</li>
            <li>Privacy Policy</li>
            <li>Request Table</li>
          </ul>
        </div>
        <div class="footer__top__right__column footer__top__right__column--third">
          <p>Navigate</p>
          <ul>
            <li>Feed</li>
            <li>Ranking</li>
            <li>Sign In & Up</li>
            <li>Create Table</li>
            <li>Topics</li>
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
          <li>Facebook</li>
          <li>Twitter</li>
          <li>Medium</li>
          <li>GitHub</li>
          <li>Patreon</li>
          <li>Dribbble</li>
          <li>Product Hunt</li>
        </ul>
      </div>
    </div>
  </footer>
</section>
<script type="text/javascript" src="/js/react/main.f8c5d60c.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.slim.min.js"></script>
</body>
</html>
