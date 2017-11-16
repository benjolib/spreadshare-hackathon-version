{% extends 'layouts/main.volt' %}

{% block content %}
<form id="addEmptyTableForm" method="post">
  <div class="layout">
    <div class="layout__content">
      <div class="layout__content__wrapper">
        <p class="layout__content__title">Add a table</p>
        <p class="layout__content__subtitle">
          As a table owner you receive 2,5% of all tokens a table generates.
        </p>
        <div class="layout__content__main layout__content__main__account">
          <div class="layout__content__main__account__email">
            <div class="layout__content__main__account__column">
              <div class="layout__content__main__account__email__text">
                <p>Title</p>
              </div>
              <input type="text" placeholder="Bay Area Seed-stage Business Angels" name="title" value="" maxlength="100" />
              Max 100 characters
            </div>
          </div>
        </div>
        <div class="layout__content__main layout__content__main__account">
          <div class="layout__content__main__account__email">
            <div class="layout__content__main__account__column">
              <div class="layout__content__main__account__email__text">
                <p>Tagline</p>
              </div>
              <input type="text" placeholder="Business Angels from SV who invest in tech startups valuated below 5M" name="tagline" value="" maxlength="140" />
              Max 140 characters
            </div>
          </div>
          <div class="layout__content__main__buttons">
            <a href="/">Cancel</a>
            <button type="submit">Create Table</button>
          </div>
        </div>
      </div>
      <aside class="layout__content__aside">
        <div class="layout__content__aside__box">
          <a href="javascript;">
            <div>Choose Table</div>
          </a>
          <a href="javascript;">
            <div class="settings-box-selected">
              Description
            </div>
          </a>
          </a>
          <a href="/settings/notifications">
            <div>Confirm</div>
          </a>
        </div>
      </aside>
    </div>
  </div>
</form>
{% endblock %}
