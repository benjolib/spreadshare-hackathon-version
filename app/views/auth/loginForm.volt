{% extends 'layouts/main.volt' %}

{% block content %}
<div class="ui middle aligned center aligned grid" style="max-width:600px;margin:0 auto;">
  <div class="column">

    <form class="ui large form">
      <div class="ui stacked segment">
        <h2 class="ui image header" style="margin:15px 0 20px 0;">
          <div class="content">Spreadshare - Login using</div>
        </h2>

        <p>
          <a class="ui twitter fluid submit button" href="/login/twitter"><i class="twitter icon"></i> Twitter</a>
        </p>
        <p>
          <a class="ui facebook fluid submit button" style=" " href="/login/facebook"><i class="facebook icon"></i> Facebook</a>
        </p>
      </div>
      <div class="ui error message"></div>
    </form>
  </div>
</div>
{% endblock %}