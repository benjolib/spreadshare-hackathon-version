{% extends 'layouts/main.volt' %}

{% block title %}Spreadshare{% endblock %}

{% block content %}

<div style="width:100%;height:800px;background-color:#e0e9ee;color:#65768e;">
  <div style="margin: 40px auto;text-align:center;">
    <div style="">
      <img style="height:200px;" src="/assets/images/404.jpg" />
    </div>
    <h1 style="margin: 20px 0 5px 0;">Oh!</h1>
    <p>{{ error }}</p>
  </div>
</div>

{% endblock %}