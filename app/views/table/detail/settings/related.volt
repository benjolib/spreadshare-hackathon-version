<div class="tableRelated">
  <p class="tableRelated__title">Related tables</p>
  <div class="tableRelated__tables">
    {% for related in relatedTables %}
      <div class="addTableEmpty__content__main__options__item">
        <div class="addTableEmpty__content__main__options__item__column">
          <a href="/table/{{ related['id'] }}">
            <div class="tableAbout__sidebar__content__item">
              <h5>{{ related['title'] }}</h5>
              <p>{{ related['tagline'] }}</p>
            </div>
          </a>
        </div>
      </div>
    {% endfor %}
  </div>

  <p class="tableRelated__title tableRelated__title--addRelated">Add another related table</p>
  <div id="TableSelect" data-name="tableId" data-placeholder="Find a table" class="react-component"></div>
</div>
