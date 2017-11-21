{% extends 'layouts/main.volt' %}

{% block title %}Spreadshare{% endblock %}

{% block content %}

<div style="width:100%;height:800px;background-color:#e0e9ee;color:#65768e;">
  <div style="margin: 40px auto;text-align:center;">
    <div style="">
      <img style="height:200px;" src="/assets/images/404.jpg" />
    </div>
    <h1 style="margin: 20px 0 5px 0;">Page not found</h1>
    <p>The link you clicked may be broken or the page may have been removed.</p>
    <p style="font-weight:500;">Visit the <a href="{{ site.baseurl }}/">Home</a> page or <a href="mailto:hi@spreadshare.co">Contact us</a> about the problem.</p>
  </div>
</div>

{% endblock %}