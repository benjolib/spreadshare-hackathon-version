{# title #}
<div class="addTableEmpty__content__main__options__item">
  <div class="addTableEmpty__content__main__options__item__column">
    <p>Title</p>
    <input type="text" placeholder="Bay Area Seed-stage Business Angels" autofocus name="title" value="{{ table['title'] }}" />
    <span>Max <i>100</i> characters</span>
  </div>
</div>
{# tagline #}
<div class="addTableEmpty__content__main__options__item">
  <div class="addTableEmpty__content__main__options__item__column">
    <p>Tagline</p>
    <input type="text" placeholder="Business Angels from SV who invest in tech startups valuated below 5MN" name="tagline" value="{{ table['tagline'] }}" />
    <span>Max <i>140</i> characters</span>
  </div>
</div>
{# topics #}
<div class="addTableEmpty__content__main__options__item">
  <div class="addTableEmpty__content__main__options__item__column">
    <p>Topics</p>
    <div id="TopicsSelect" data-name="topics[]" data-values="{{ reactArray(table['topics']) }}" data-placeholder="Add topics" class="react-component"></div>
    <span>Max <i>2</i> topics</span>
  </div>
</div>
{# content type #}
<div class="addTableEmpty__content__main__options__item">
  <div class="addTableEmpty__content__main__options__item__column">
    <p>Content type</p>
    <div id="ContentTypeSelect" data-name="type" data-value="{{ table['type'] }}" class="react-component"></div>
  </div>
</div>
{# tags #}
<div class="addTableEmpty__content__main__options__item">
  <div class="addTableEmpty__content__main__options__item__column">
    <p>Tags</p>
    <div id="TagsSelect" data-name="tags[]" data-values="{{ reactArray(table['tags']) }}" class="react-component"></div>
  </div>
</div>
{# locations #}
<div class="addTableEmpty__content__main__options__item">
  <div class="addTableEmpty__content__main__options__item__column">
    <p>Locations</p>
    <div id="LocationSelect" data-name="location[]" data-value="{{ reactArray(table['location']) }}" class="react-component"></div>
  </div>
</div>

{# buttons #}
<div class="addTableEmpty__content__main__buttons">
  <a href="/table/add">Cancel</a>
  <button type="submit">Save Changes</button>
</div>
