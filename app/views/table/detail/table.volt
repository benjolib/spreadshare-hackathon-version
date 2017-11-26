{% extends 'layouts/main.volt' %}

{% block content %}
<div class="table">
  {{ partial('table/detail/header') }}

  <div class="flag-table" style="display:none;color:#6a7c93;text-align:center;margin-bottom:25px;">
    <p>Please shortly describe why you want to flag this table:</p>
    <input type="hidden" id="flagType" value="" />
    <input type="text" id="flagText" value="" placeholder="" />
    <button type="button" class="send-flag-report">Send</button>
  </div>

  <div>
    <div id="Table" data-id="{{ table['id'] }}" data-permission="{% if auth.getUserId() == table['ownerUserId'] %}2{% elseif auth.loggedIn() %}1{% else %}0{% endif %}" class="react-component">Table
    </div>
  </div>
</div>
{% endblock %}

{% block scripts %}
<script type="text/javascript">
  $(document).ready(function () {
    $('.flag-icon').on('click', function () {
      $('.table-menu').toggleClass('show');
    });

    $('.table-menu li a').on('click', function (event) {
      var el = event.currentTarget;
      document.getElementById('flagType').value = el.getAttribute('data-flag');
      document.querySelector('.flag-table').style.display = 'block';
      document.getElementById('flagText').focus();
      $('.table-menu').toggleClass('show');
    });

    $('.send-flag-report')
      .api({
        action: 'flag',
        method: 'POST',
        beforeSend: function (settings) {
          settings.urlData = {
            id: '{{ table["id"] }}',
            flag: $('input#flagType').val(),
          }
          ;
          settings.data = {
            text: $('input#flagText').val(),
          };
          return settings;
        },
      });
  });
</script>
{% endblock %}
