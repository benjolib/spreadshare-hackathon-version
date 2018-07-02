{% extends 'layouts/main.volt' %} {% block title %}SpreadShare - Subscriptions{% endblock %} {% block header %} {% endblock
%} {% block content %}
<div class="re-page">
  <div class="lists-page-space">
    <h1 class="re-heading">Subscriptions</h1>
    <h2 class="re-subheading re-subheading--button-below">Manage all your subscriptions in one place.</h2>
  </div>

  {# {% if tables is defined AND tables %} #}

  <form id="subscriptions_form" method="post" action="/subscriptions">
    <input type="hidden" name="table_id" value="" />
    <input type="hidden" name="subscription_freq" value="" />
    <table class="re-table">
      <tbody>
        {{ partial('subscriptions/content') }}
      </tbody>
    </table>
  </form>
  {# {% endif %} #} {#
  <div class="u-flex u-flexJustifyCenter">
    <a href="#" class="re-button re-button--load-more" {{ moreToLoad ? '' : 'style="display:none;"' }}>Load More</a>
  </div> #}
</div>
{% endblock %} {% block scripts %}
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

  function subsFreqOnClick(id, freq) {
    $('[name="table_id"]').val(id);
    $('[name="subscription_freq"]').val(freq);
    $('#subscriptions_form').submit();
  }
</script>
{% endblock %}