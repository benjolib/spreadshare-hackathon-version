{% extends 'layouts/main.volt' %}

{% block content %}

  <div class="__page__top">
    <h1>Blog</h1>
    <h2>Join and write with us. Write us an email to hi@spreadshare.co </h2>
  </div>

  <div class="__page__container">

  <div class="__page__wrapper">


    {% for post in posts %}
      <div id="post">
       <img class="img-rounded" src="//cdn-images-1.medium.com/max/700/{{ post.virtuals.previewImage.imageId|e }}">
       <h3>{{ post.title|e }}</h3>
       <p>{{ post.virtuals.subtitle|e }} </p>
       <br>
       <p><a class="read-more" target="_new" href="//medium.com/spreadshare/{{ post.uniqueSlug }}">Read More</a></p>
      </div>
      <br>
    {% endfor  %}

  </div>

  <div class="__page__sidebar">
   <ul>
    <li class="active"><a href="/blog">Posts</a></li>
   </ul>
  </div>
  </div>

{% endblock %}
