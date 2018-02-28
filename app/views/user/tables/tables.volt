{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - {{ profile.name }} - Lists{% endblock %}

{% block header %}
{% endblock %}

{% block content %}
  <div class="re-page">
    <div class="u-flex u-sm-flexCol u-md-flexRow u-flexJustifyBetween u-md-flexAlignItemsEnd lists-page-space">
      <div>
        <h1 class="re-heading">Lists</h1>
        <h2 class="re-subheading re-subheading--button-below">Manage all your lists in one place.</h2>
      </div>
      <div>
        <a href="/table/add" class="re-button">Curate a List</a>
      </div>
    </div>

    {% if tables is defined AND tables %}
      <table class="re-table">
        <tbody>
          {% for table in tables %}
            <tr>
              <td>
                <div class="{{ table['flags'] === '2' ? 're-table-green' : '' }}">{{ table['flags'] === '2' ? 'PUBLISHED' : 'DRAFT' }}</div>
                <a href="/table/{{ table['id'] }}"><h3>{{ table['title'] }}</h3></a>
                <p>{{ table['tagline'] }}</p>
              </td>
              <td>
                <div class="u-flex u-flexJustifyCenter u-flexAlignItemsCenter card-actions-button l-button-{{ table['id'] }}">
                  <img src="/assets/images/arrow-down.svg" />
                </div>
                <div class="dropdown card-actions-dropdown u-flex u-flexCol u-flexJustifyCenter l-dropdown-{{ table['id'] }}">
                  <a href="/table/{{ table['id'] }}/settings"><img src="/assets/images/pencil2.svg" /> Edit List</a>
                  <a href="#" onclick="alert('TODO')" class="warning-color"><img src="/assets/images/bin2.svg" /> Delete List</a>
                </div>
              </td>
            </tr>
            <tr class="re-table-space"></tr>
          {% endfor %}
        </tbody>
      </table>
    {% endif %}
  </div>
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
