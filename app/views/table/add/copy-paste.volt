{% extends 'layouts/main.volt' %}

{% block content %}
<form id="addTableCopyPasteForm" method="post">
  <div class="addTableCopyPaste">
    <div class="addTableCopyPaste__content">
      <div class="addTableCopyPaste__content__wrapper">
        <p class="addTableCopyPaste__content__title">Add a Table</p>
        <p class="addTableCopyPaste__content__subtitle">As an table owner you receive 2,5% of all tokens a table generates</p>
        <div class="addTableCopyPaste__content__main">
          {# flash messages #}
          {{ flash.output() }}
          <div class="addTableCopyPaste__content__main__options">
            {# title #}
            <div class="addTableCopyPaste__content__main__options__item">
              <div class="addTableCopyPaste__content__main__options__item__column">
                <div class="addTableCopyPaste__content__main__options__item__row addTableCopyPaste__content__main__options__item__row--divided">
                  <p>Paste table content here</p>
                  <p>Separate by <span>comma</span><i></i></p>
                </div>
                <textarea rows="20" autofocus></textarea>
              </div>
            </div>
          </div>
          {# buttons #}
          <div class="addTableCopyPaste__content__main__buttons">
            <a href="/table/add">Cancel</a>
            <button type="submit">Import pasted Data</button>
          </div>
        </div>
      </div>
      <aside class="addTableCopyPaste__content__aside">
        <div class="addTableCopyPaste__content__aside__box">
          <a href="/table/add">
            <div class="sign-box-selected">Choose table</div>
          </a>
          <a href="#">
            <div>Description</div>
          </a>
          <a href="#">
            <div>Confirm</div>
          </a>
        </div>
      </aside>
    </div>
  </div>
</form>
{% endblock %}
