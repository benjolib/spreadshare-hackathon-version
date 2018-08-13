{% extends 'layouts/main.volt' %}
{% block title %}SpreadShare - History{% endblock %}
{% block header %}
{% endblock %}

{% block content %}
<div class="re-page">
  <div class="collaborations-page-space">
    <h1 class="re-heading">History</h1>
    <h2 class="re-subheading">Streams you recently viewed.</h2>
  </div>

  <div class="u-flex u-flexWrap big-gutter">
    {% for table in tables %}
      {{ partial('partials/list-card', [
        'id': table['id'],
        'slug': table['slug'],
        'image': table['image'],
        'name': table['title'],
        'description': table['tagline'],
        'subscriberCount': table['subscriberCount'],
        'listingCount': table['listingCount'],
        'showCurator': false,
        'half': true,
        'small': true,
        'large': false
      ]) }}
    {% endfor %}
  <div>
</div>
{% endblock %}

{% block scripts %}
  <script type="text/javascript">
    $(document).ready(function () {

    });
  </script>
{% endblock %}
