{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - Lists{% endblock %}

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
        <a href="/table/add" class="re-button">Create a List</a>
      </div>
    </div>

    {% if tables is defined AND tables %}
      <table class="re-table">
        <tbody>
          {{ partial('lists/content') }}
        </tbody>
      </table>
    {% endif %}
    <div class="u-flex u-flexJustifyCenter">
      <a href="#" class="re-button re-button--load-more" {{ moreToLoad ? '' : 'style="display:none;"' }}>Load More</a>
    </div>
  </div>
{% endblock %}

{% block scripts %}
  <script type="text/javascript">
    $(document).ready(function () {
      var pageNumber = 1;

      $('.re-button--load-more').on('click', function (e) {
        e.preventDefault();
        $.ajax(window.location.pathname + '?page=' + pageNumber)
          .done(function (response) {
            if (response) {
              $('.re-table tbody').append(response);
              pageNumber += 1;
              if (!$('<div>' + response + '</div>').find('.moreToLoad').val()) {
                $('.re-button--load-more').hide();
              }
              window.bindPops();
            }
          });
      });
    });
  </script>
{% endblock %}
