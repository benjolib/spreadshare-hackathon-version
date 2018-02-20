{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - {{ profile.name }} - Lists{% endblock %}

{% block header %}
{% endblock %}

{% block content %}
  <div class="u-flex u-sm-flexCol u-md-flexRow u-flexJustifyBetween u-md-flexAlignItemsEnd page-top-margin-bottom">
    <div>
      <h1 class="heading h1">Lists</h1>
      <h2 class="page-subtitle">Manage all your lists in one place.</h2>
    </div>
    <div>
      <a href="/table/add" class="button">Curate a List</a>
    </div>
  </div>

  {% if tables is defined AND tables %}
    <div class="u-flex u-flexCol">
      {% for table in tables %}
        <div class="card u-flex u-flexJustifyBetween u-flexAlignItemsCenter">
          <div>
            <div class="card-flag {{ table['flags'] === '2' ? 'published' : 'draft' }}">{{ table['flags'] === '2' ? 'PUBLISHED' : 'DRAFT' }}</div>
            <h3 class="heading h3">{{ table['title'] }}</h3>
            <p class="text">{{ table['tagline'] }}</p>
          </div>
          <div>
            <div class="u-flex u-flexJustifyCenter u-flexAlignItemsCenter card-actions-button l-button-{{ table['id'] }}">
              <img src="/assets/images/arrow-down.svg" />
            </div>
            <div class="dropdown card-actions-dropdown u-flex u-flexCol u-flexJustifyCenter l-dropdown-{{ table['id'] }}">
              <a href="/table/{{ table['id'] }}/settings"><img src="/assets/images/pencil2.svg" /> Edit List</a>
              <a href="#" onclick="alert('TODO')" class="warning-color"><img src="/assets/images/bin2.svg" /> Delete List</a>
            </div>
          </div>
        </div>
      {% endfor %}
    </div>
  {% else %}
    <p>You haven't created any lists.</p>
  {% endif %}
{% endblock %}

{% block scripts %}
  <script type="text/javascript">
    {% for table in tables %}
      new Popper($('.l-button-{{ table['id'] }}'), $('.l-dropdown-{{ table['id'] }}'), {
        placement: 'bottom-end'
      });

      $('.l-button-{{ table['id'] }}').click(function () {
        $('.l-dropdown-{{ table['id'] }}').toggleClass('show');
      });
    {% endfor %}
  </script>
{% endblock %}
