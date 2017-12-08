{% extends 'layouts/main.volt' %}

{% block content %}
<div class="addTable">
  <div class="white-overlay" style="{% if visitedAddTablePage is defined AND !visitedAddTablePage %}display:block;{% endif %}"></div>
  <div class="addTable__content">
    <div class="addTable__content__wrapper">
      <p class="addTable__content__title">Add a Table</p>
      <p class="addTable__content__subtitle">As a table owner you are responsible for managing the community and content around it and therefore your receive 2.5% of all tokens a table generates.</p>
      <div class="addTable__content__main">
        <div id="addTableOpts" class="addTable__content__main__options" style="{% if visitedAddTablePage is defined AND !visitedAddTablePage %}display:none;{% endif %}">
          <form id="addTableForm" method="post" action="{{ action }}" enctype="multipart/form-data">
          {{ flash.output() }}

          <input type="hidden" name="tableId" value="{% if tableId is defined %}{{ tableId }}{% endif %}" />
          {% include content %}
          </form>
        </div>
        {% if visitedAddTablePage is defined AND !visitedAddTablePage %}
          <div id="addTableMsg" class="addTable__content__main__options">
            <div class="addTableEmpty__content__main__options__item">
            <div class="addTableEmpty__content__main__options__item__column">
              <p>Who is the admin of the table?</p>
              <p><img src ="/assets/icons/tip.svg"/> <span>You.</span> Soon, you'll be able to assign more admins to work as a team.</p>
            </div>
            </div>
            <div class="addTableEmpty__content__main__options__item">
            <div class="addTableEmpty__content__main__options__item__column">
              <p>Who can collaborate?</p>
              <p><img src ="/assets/icons/tip.svg"/> Every member of our community. <span>Members ca add, change and remove content to a tables cell.</span></p>
            </div>
            </div>
            <div class="addTableEmpty__content__main__options__item">
            <div class="addTableEmpty__content__main__options__item__column">
              <p>Collaborate on what?</p>
              <p><img src ="/assets/icons/tip.svg"/> The table's cell. Adding to empty table cells are live immeadiately. Changes or removes have to be confirmed by the admins.</p>
            </div>
            </div>
            <div id="addTableButtons">
            <p>✌ That's what I am looking for. <span>Try now</span></p>
            <button>Create 1st Table</button>
            </div>
          </div>
        {% endif %}
      </div>
      <div class="addTable__content__banner">
        <p>Need some inspiration? Here are some table topics our community is looking for</p>
        <button>Get Inspired</button>
      </div>
    </div>
    <aside class="aside aside--addTable">
      <a>
        <div class="aside__item {% if tab == 'choose-method' %}item-selected{% endif %}"><p>Choose Method</p></div>
      </a>
      <a>
        <div class="aside__item {% if tab == 'description' %}item-selected{% endif %}"><p>Description</p></div>
      </a>
      {% if hideChooseTable is defined AND !hideChooseTable %}
      <a>
        <div class="aside__item {% if tab == 'choose-table' %}item-selected{% endif %}"><p>Choose table</p></div>
      </a>
      {% endif %}
      <a>
        <div class="aside__item {% if tab == 'choose-confirm' %}item-selected{% endif %}"><p>Preview</p></div>
      </a>
    </aside>
  </div>


  {% if tableData is defined %}
  <div class="table-preview">
    <div class="header">
      <strong>Preview</strong>
      <span>This is how your table will look like</span>
      <a class="green button" href="javascript:history.go(-1);">Change it</a>
    </div>
    <div class="table htColumnHeaders">
      {#
      <h4>Loading table preview</h4>
      <div class="loading"></div>
      #}
      <table>
        <thead>
          <tr>
            {% for col in tableData['columns'] %}
            <th>{% if col['title'] is defined %}{{ col['title'] }}{% endif %}</th>
            {% endfor %}
          </tr>
        </thead>
        <tbody>
          {% for row in tableData['rows'] %}
          <tr>
            {% for cell in row['content'] %}
            <td>{% if cell['content'] is defined %}{{ cell['content'] }}{% endif %}</td>
            {% endfor %}
          </tr>
          {% endfor %}
        </tbody>
      </table>
    </div>
  </div>
  {% endif %}
</div>
{% endblock %}

{% block scripts %}
  {% if content_js is defined AND content_js %}
    <script type="text/javascript">
        {% include content_js %}
    </script>
  {% endif %}
  {% if visitedAddTablePage is defined AND !visitedAddTablePage %}
    <script type="text/javascript">
      window.addEventListener('load', function () {
        var $buttons = $('#addTableButtons');
        var $modal = $('#addTableMsg');
        var $options = $('#addTableOpts');
        var $overlay = $('.white-overlay');
        $buttons.on('click', 'span, button', function () {
          $modal.hide();
          $options.show();
          $overlay.hide();
        });
      });
    </script>
  {% endif %}
{% endblock %}
