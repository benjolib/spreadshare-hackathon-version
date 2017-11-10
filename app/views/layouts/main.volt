<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,800" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
  <link rel="stylesheet" href="/css/styles.css">
  <title>{% block title %}Spreadshare{% endblock %}</title>
  {% block header %}{% endblock %}
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="navbar__logo">
      <h1>SpreadShare</h1>
      <h2>Community Curated Tables</h2>
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
    <a href="/login" class="navbar__login">Log in <span>or</span> Sign up</a>
  </nav>
  <!-- Main Section -->
  <section class="main">
    <!-- Hero -->
    <div class="main__hero">
      <p>Collaborate with and get rewarded by the community</p>
      <h2>A marketplace for community-curated tables in the blockchain</h2>
    </div>
    <!-- Content -->
    <div class="main__content">
      {{ flash.output() }}

      <!-- Table Cards -->
      <div class="main__content__tables">
        {% block content %}{% endblock %}
      </div>
      <!-- Sidebar -->
      <div class="main__content_sidebar">
        {% block sidebar %}{% endblock %}
      </div>
    </div>
  </section>

  {% block footer %}{% endblock %}
</body>
</html>
