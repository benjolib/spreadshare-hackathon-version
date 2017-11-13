{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
<div class="layout">
  <div class="layout__content">
    <div class="layout__content__wrapper">
      <p class="layout__content__title">Title</p>
      <p class="layout__content__subtitle">Subtitle.</p>
      <div class="layout__content__main">
        Main Content
      </div>
    </div>
    <aside class="layout__content__aside">
      Aside
    </aside>
  </div>
</div>
{% endblock %}
