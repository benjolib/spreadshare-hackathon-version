{% extends 'layouts/main.volt' %} {% block title %}Spreadshare - 404{% endblock %} {% block content %}
<div class="re-page">
</div>
<div class="info-box">
  <div class="info">
    <div class="heading"> 404 </div>
    <div class="subheading"> The page you are looking for can't be found. </div>
  </div>
  <div class="action">
    <button onclick="window.location.href='/'" :> Back to Home </button>
  </div>

</div>
{% endblock %}