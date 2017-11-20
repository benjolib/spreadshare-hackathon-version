{% extends 'layouts/main.volt' %}

{% block content %}
<form id="addEmptyTableForm" method="post">
  <div class="addTableEmpty">
    <div class="addTableEmpty__content">
      <div class="addTableEmpty__content__wrapper">
        <p class="addTableEmpty__content__title">Add a Table</p>
        <p class="addTableEmpty__content__subtitle">As an table owner you receive 2,5% of all tokens a table generates</p>
        <div class="addTableEmpty__content__main">
          {{ flash.output() }}

          <div class="addTableEmpty__content__main__options">
            {# title #}
            <div class="addTableEmpty__content__main__options__item">
              <div class="addTableEmpty__content__main__options__item__column">
                <p>Title</p>
                <input type="text" placeholder="Bay Area Seed-stage Business Angels" autofocus name="title" value="{{ post['title'] }}" />
                <span>Max <i>100</i> characters</span>
              </div>
            </div>
            {# tagline #}
            <div class="addTableEmpty__content__main__options__item">
              <div class="addTableEmpty__content__main__options__item__column">
                <p>Tagline</p>
                <input type="text" placeholder="Business Angels from SV who invest in tech startups valuated below 5MN" name="tagline" value="{{ post['tagline'] }}" />
                <span>Max <i>140</i> characters</span>
              </div>
            </div>
            {# topics #}
            <div class="addTableEmpty__content__main__options__item">
              <div class="addTableEmpty__content__main__options__item__column">
                <p>Topics</p>
                <div id="TopicsSelect" data-name="topics[]" data-values="{{ reactArray(post['topics']) }}" data-placeholder="Add topics" class="react-component"></div>
                <span>Max <i>2</i> topics</span>
              </div>
            </div>
            {# content type #}
            <div class="addTableEmpty__content__main__options__item">
              <div class="addTableEmpty__content__main__options__item__column">
                <p>Content type</p>
                <div id="ContentTypeSelect" data-name="type" data-value="{{ post['type'] }}" class="react-component"></div>
              </div>
            </div>
            {# tags #}
            <div class="addTableEmpty__content__main__options__item">
              <div class="addTableEmpty__content__main__options__item__column">
                <p>Tags</p>
                <div id="TagsSelect" data-name="tags[]" data-values="{{ reactArray(post['tags']) }}" class="react-component"></div>
              </div>
            </div>
            {# locations #}
            <div class="addTableEmpty__content__main__options__item">
              <div class="addTableEmpty__content__main__options__item__column">
                <p>Locations</p>
                <div id="LocationSelect" data-name="location[]" data-value="{{ reactArray(post['location']) }}" class="react-component"></div>
              </div>
            </div>
          </div>
          {# buttons #}
          <div class="addTableEmpty__content__main__buttons">
            <a href="/table/add">Cancel</a>
            <button type="submit">Save Changes</button>
          </div>
        </div>
      </div>
      <aside class="addTableEmpty__content__aside">
        <div class="addTableEmpty__content__aside__box">
          <a href="/table/add">
            <div>Choose table</div>
          </a>
          <a href="#">
            <div class="sign-box-selected">Description</div>
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
