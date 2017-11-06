<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>{% block title %}Spreadshare{% endblock %}</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.css">
  <style type="text/css">
    html {
      font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Helvetica, Arial, sans-serif;
      font-size: .94285714rem;
    }

    .ui.aligned.message {
      margin-bottom: 10px !important;
    }

    .ui.aligned.main,
    .ui.aligned.message {
      max-width: 1000px;
      margin: 0 auto;
    }

    .ui.text.container, .ui.feed {
      font-size: .94285714rem !important;
    }

    .ui.menu {
      border: 0;
      border-bottom: 1px solid rgba(34, 36, 38, .15);
      -webkit-border-radius: 0; -moz-border-radius: 0; border-radius: 0;
    }

    .ui.text.container,
    .ui.feed.container,
    div.container-content > .ui.message {
      max-width: 1000px !important;
    }

    .ui.feed.container {
      margin: 20px;
      border: 1px solid #ccc;
      background: #fff;
      padding: 20px;
    }

    .ui.feed > .event > .label {
      width: 85px;
    }

    .list .link:active {
      margin-top: 1px;
    }

    .list .link:hover {
      background: #eee;
    }

    .list .link.voted {
      background: #68809e;
      border-color: #68809e;
    }

    .list .link.voted:hover i {
      color: white;
    }

    .list .link.voted span,
    .list .link.voted i {
      color: white;
    }

    .list .link {
      border: 1px solid #ccc;
      -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;
      padding: 4px 8px;
      margin: 5px 5px 0 0;
      background: white;
    }

    .list .link span {
      color: black;
      font-size: 90%;
      font-weight: 600;
    }

    .list .item .label img {
      -webkit-border-radius: 5px !important;; -moz-border-radius: 5px !important;; border-radius: 5px !important;
      width: 85px !important;
      height: 85px !important;;
    }

    .ui.large.feed.relaxed.divided.list div.content .description {
      margin-top: 5px;
      color: #999;
    }

    .list .content .meta {
      margin-top: 5px !important;
      width: 100%;
    }

    .list .content .meta .links {
      float: right;
    }

    .list .content .meta .links .external.link i {
      margin-right: -4px;
    }

    .event.item {
      padding: 15px !important;
    }

    .event.item:hover {
      background: #f9f9f9;
      cursor: pointer;
    }

    .ui.label > .detail {
      font-weight: 100;
    }

    .ui.segment {
      -webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none;
    }

    .ui.comments .reply.form textarea {
      height: auto;
    }

    i.icon {
      margin: 0 .2rem 0 0;
    }

    .ui.message i.icon {
      margin: 0;
    }

    .event.item .content {
      position: relative;
    }

    .event.item .content .hunter {
      position: absolute;
      right: 0;
      top: 0;
    }

    .ui.popup {
      padding: 0 !important;
    }

    div.content > div.meta .right.floated {
      position: absolute;
      right: 0;
      top: 0;
    }

    @media (max-width: 600px) {
      div.content > div.meta .left.floated {
        display: none;
      }

      .shareaholic-canvas {
        display: none;
      }
    }
  </style>
  {% block header %}{% endblock %}
</head>
<body>
<div class="ui borderless main menu" style="margin:0;">
  <div class="ui text container">
    <a href="/" class="header item">
      Spreadshare
    </a>
    <a href="/about" class="ui item">About</a>
    {% if auth().loggedIn() %}
    <a href="/hunt" class="ui item">
      <svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
        <path d="M8,10 L8,4 L6,4 L6,10 L0,10 L0,12 L6,12 L6,18 L8,18 L8,12 L14,12 L14,10 L8,10 Z" transform="translate(0 -4)" fill="#999" fill-rule="evenodd"></path>
      </svg> &nbsp; Add Deck</a>
    <div class="ui right floated dropdown item">

      <div class="ui rounded image">
        <img height="32" src="{{ auth().getUser().getImage() }}" width="32">
      </div>
      <i class="dropdown icon"></i>
      <div class="menu">
        <a href="/user/{{ auth().getUser().getHandle() }}" class="item">My Profile</a>
        <!--<div class="item">Settings</div>-->
        <div class="divider"></div>
        <a href="/logout" class="item">Logout</a>
      </div>
    </div>
    {% else %}
    <a href="/login" class="ui right floated dropdown item">Login / Register</a>
    {% endif %}
  </div>
</div>
<div class="container-content" style="background: #f9f9f9;padding:10px;">
  {{ flash.output() }}
  {% block content %}{% endblock %}
</div>

<div class="ui vertical footer basic segment" style="background: #f9f9f9;margin-bottom:0;padding-bottom:50px;">
  <div class="ui hidden divider"></div>
  <div class="ui center aligned container">
    <div class="seven wide column">
      <h4 class="ui header">© 2017 Spreadshare</h4>
    </div>
    <div class="ui hidden divider"></div>
    <div class="ui horizontal small divided link list">
      <a class="item" href="mailto:hello@spreadshare.co">Contact Us</a>
      <a class="item" href="/terms">Terms and Conditions</a>
      <a class="item" href="/privacy">Privacy Policy</a>
    </div>
  </div>
  {% block footer %}{% endblock %}
</div>

<script>

</script>
</body>
</html>