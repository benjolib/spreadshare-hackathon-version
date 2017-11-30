{% if tables %}
  <div class="container__content container__content--tables">
    {% for table in tables %}
      {{ partial('partials/table') }}
    {% endfor %}
  </div>
{% endif %}
