<!DOCTYPE html>
<html lang="en">

<head prefix="og:http://ogp.me/ns#">
  <title>{% block title %}{% endblock %}</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta property="og:title" content="{% block title %}{% endblock %}" /> {# TODO: It's not taking block title the second time #}
  <meta property="og:type" content="website" />
  <meta property="og:description" content="{{ config.description }}" />
  <meta property="og:url" content="http://{{ config.domain }}" />
  <meta property="og:image" content="http://{{ config.domain }}/assets/images/logo_big.png" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt"
  crossorigin="anonymous">

  <meta property="fb:app_id" content="{{ config.hybridauth.providers.Facebook.keys.id }}"> {# TODO: remove if not needed anymore #}
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,800" rel="stylesheet"> {# TODO: use only needed font sizes #}
  <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet"> {# TODO: use only needed font sizes #}
  <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:100,100i,300,300i,400,400i,500,500i,700,700i" rel="stylesheet">
  <link rel="stylesheet" href="/css/styles.css">
  <link href="/css/main.878d83e3.css" rel="stylesheet">
  <link href="/semantic/semantic.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="/assets/images/9-0/logo.png"> {% block header %}{% endblock %}

</head>

<body>
  <script>
    window.fbAsyncInit = function () {
      FB.init({
        appId: '153117502101937',
        autoLogAppEvents: true,
        xfbml: true,
        version: 'v2.12'
      });
    };

    (function (d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {
        return;
      }
      js = d.createElement(s);
      js.id = id;
      js.src = "https://connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script>

  {# navbar #} {% if hideHeader is empty or not hideHeader %} {{ partial('layouts/header') }} {% endif %} {# main section #}
  <section class="main">

    <div class="feedback">
      <div class="title">Shape our product</div>
      <div class="content">Tell us about feature ideas and bugs you found</div>
    </div>

    <div class="flash">
      {% set flashMessages = flash.getMessages() %} {% if flashMessages %} {% for type, messages in flashMessages %} {% for message
      in messages %}
      <div class="flash__message flash__message--{{ type }}">
        <span class="flash__message__heading">{{ message|split(' - ')[0] }}</span>
        &nbsp;&nbsp;
        <span class="flash__message__text">{{ message|split(' - ')[1] }}</span>
      </div>
      {% endfor %} {% endfor %} {% endif %}
    </div>

    {# content #} {% block content %}{% endblock %}
  </section>

  {# footer #} {# {{ partial('layouts/footer') }} #}

  <div class="white-overlay"></div>
  {#
  <a class="button green found-a-bug" href="https://betterresearch.typeform.com/to/o3W0BI" target="_blank">Report a Bug 🐞</a> #}
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script>
  <script type="text/javascript" src="/js/api.js"></script>
  <script type="text/javascript" src="/js/jquery.sticky-sidebar.min.js"></script>
  <script type="text/javascript" src="/js/infinite-scroll.min.js"></script>
  <script type="text/javascript" src="/semantic/semantic.min.js"></script>
  <script type="text/javascript" src="/js/initial.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearchLite.min.js"></script>
  <script type="text/javascript">
    var client = algoliasearch("{{ config['algolia']['app-id'] }}", "{{ config['algolia']['api-key'] }}");
    document.searchstream = client.initIndex('spreadshare-stream-{{ config["mode"] }}');
    document.searchusers = client.initIndex('spreadshare-users-{{ config["mode"] }}');
  </script>


  {{ partial('layouts/scripts') }} {#

  <script type="text/javascript" src="/js/react/main.3bd21672.js"></script>#} {% block scripts %}{% endblock %}

  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-110506889-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-110506889-1');
  </script>
</body>

</html>