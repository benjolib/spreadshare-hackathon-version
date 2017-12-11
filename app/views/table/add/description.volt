{{ flash.output() }}

{# title #}
<div class="addTableEmpty__content__main__options__item">
  <p class="addTableEmpty__content__main__options__item__tip">
    <img src="/assets/icons/tip.svg" /> You can change these information anytime in your&nbsp;<span>Table Settings</span>
  </p>
</div>
<div class="addTableEmpty__content__main__options__item">
  <div class="addTableEmpty__content__main__options__item__column">
    <p>Title</p>
    <input type="text" placeholder="Bay Area Seed-stage Business Angels" autofocus name="title" value="{% if post is defined AND post['title'] is defined %}{{ post['title'] }}{% endif %}" />
    <span>Max <i>100</i> characters</span>
  </div>
</div>
{# tagline #}
<div class="addTableEmpty__content__main__options__item">
  <div class="addTableEmpty__content__main__options__item__column">
    <p>Tagline</p>
    <input type="text" placeholder="Business Angels from SV who invest in tech startups valuated below 5MN" name="tagline" value="{% if post is defined AND post['tagline'] is defined %}{{ post['tagline'] }}{% endif %}" />
    <span>Max <i>140</i> characters</span>
  </div>
</div>
{# topics #}
<div class="addTableEmpty__content__main__options__item">
  <div class="addTableEmpty__content__main__options__item__column">
    <p>Topics</p>
      <div id="TopicsSelect" data-name="topics[]" data-values="{% if post is defined AND post['topics'] is defined %}{{ reactArray(post['topics']) }}{% endif %}" data-placeholder="Add topics" class="react-component"></div>
    <span>Max <i>2</i> topics</span>
  </div>
</div>
{# content type #}
<div class="addTableEmpty__content__main__options__item">
  <div class="addTableEmpty__content__main__options__item__column">
    <p>Content type</p>
    <div id="ContentTypeSelect" data-name="type" data-value="{% if post is defined AND post['type'] is defined %}{{ post['type'] }}{% endif %}" class="react-component"></div>
  </div>
</div>
{# tags #}
<div class="addTableEmpty__content__main__options__item">
  <div class="addTableEmpty__content__main__options__item__column">
    <p>Tags</p>
    <div id="TagsSelect" data-name="tags[]" data-values="{% if post is defined AND post['tags'] is defined %}{{ reactArray(post['tags']) }}{% endif %}" class="react-component"></div>
  </div>
</div>
{# locations #}
<div class="addTableEmpty__content__main__options__item">
  <div class="addTableEmpty__content__main__options__item__column">
    <p>Locations</p>
      <div id="LocationSelect" data-name="location[]" data-value="{% if post is defined AND post['location'] is defined %}{{ reactArray(post['location']) }}{% endif %}" class="react-component"></div>
  </div>
</div>

{# buttons #}
<div class="addTableEmpty__content__main__buttons">
  <a href="/table/add">Cancel</a>
  <button type="submit">Save Changes</button>
</div>
