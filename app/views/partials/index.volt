{% extends 'layouts/main.volt' %}

{# page title #}
{% block title %}
  <title>SpreadShare</title>
{% endblock %}

{# page header #}
{% block header %}{% endblock %}

{# main section #}
{% block main %}
  <section class="main">
    <div class="main__hero">
      <p>Collaborate with and get rewarded by the community</p>
      <h2>A marketplace for community-curated tables in the blockchain</h2>
    </div>
    <div class="main__content">
      {{ flash.output() }}
      <div class="main__content__tables">
        <div class="main__content__tables__filters"></div>
        <div class="main__content__tables__cards"></div>
      </div>
      <div class="main__content_sidebar">
        <div class="main_content__sidebar__categories"></div>
        <div class="main_content__sidebar__types"></div>
        <div class="main_content__sidebar__tags"></div>
        <div class="main_content__sidebar__location"></div>
      </div>
    </div>
  </section>
{% endblock %}
