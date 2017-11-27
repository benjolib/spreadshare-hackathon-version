<h2>Related Tables</h2>
{% for related in relatedTables %}
<a href="/table/{{ related['id'] }}">
  <div class="tableAbout__sidebar__content__item">
    <h5>{{ related['title'] }}</h5>
    <p>{{ related['tagline'] }}</p>
  </div>
</a>
{% endfor %}

<h2>Add another</h2>

<form method="POST">
  <div id="TableSelect" data-name="tableId" data-placeholder="Search table" class="react-component"></div>

  <div class="addTableEmpty__content__main__buttons">
    <a href="/table/{{ table['id'] }}">Cancel</a>
    <button type="submit">Add related table</button>
  </div>
</form>