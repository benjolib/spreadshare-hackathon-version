{{ flash.output() }}


<div class="addTableEmpty__content__main__options__item">
  <p class="addTableEmpty__content__main__options__item__tip">
    <img src="/assets/icons/tip.svg" /> You can change these information anytime in your&nbsp;<span>Table Settings</span>
  </p>
</div>
{# image #}
<div class="layout__content__main__personal__column">
  <div class="layout__content__main__personal__profile__text">
    <p>Image</p>
  </div>
  <div class="layout__content__main__personal__row">
    <div class="layout__content__main__personal__profile__photo">
      <img class="listImage" id="listImage" src="{% if post is defined AND post['image'] is defined %}{{ post['image'] }}{% endif %}" />
    </div>
    <div class="layout__content__main__personal__profile__add">
      <button type="button" id="listImageReplace">Replace</button>
    </div>
    <div class="layout__content__main__personal__profile__remove">
      <a href="javascript:" onclick="removeImage();">Remove</a>
    </div>
    <input type="hidden" name="removeListImage" id="removeListImage" value="0" />
    <input type="file" name="image" id="fileUpload" style="opacity:0; height:0;width:0;" />
  </div>
</div>
{# title #}
<div class="addTableEmpty__content__main__options__item">
  <div class="addTableEmpty__content__main__options__item__column">
    <p>Title</p>
    <input type="text" placeholder="Bay Area Seed-stage Business Angels" autofocus name="title" value="{% if post is defined AND post['title'] is defined %}{{ post['title'] }}{% endif %}" />
    <span>Max <i>100</i> characters</span>
  </div>
</div>
{# slug #}
<div class="addTableEmpty__content__main__options__item">
    <div class="addTableEmpty__content__main__options__item__column">
        <p>Slug</p>
        <input type="text" placeholder="bay-area-seed-stage-business-angels" name="slug" value="{% if post is defined AND post['slug'] is defined %}{{ post['slug'] }}{% endif %}" />
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
{# description #}
<div class="addTableEmpty__content__main__options__item">
    <div class="addTableEmpty__content__main__options__item__column">
        <p>Description</p>
        <textarea placeholder="Enter description" name="description">{% if post is defined AND post['description'] is defined %}{{ post['description'] }}{% endif %}</textarea>
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

<script type="text/javascript">
  window.addEventListener('load', function () {
    document.querySelector('input[type="file"]').addEventListener('change', function () {
      if (this.files && this.files[0]) {
        var img = document.querySelector('img.listImage');
        img.src = URL.createObjectURL(this.files[0]);
        //img.onload = fn;
      }
    });

    document.getElementById('listImageReplace').onclick = function () {
      document.getElementById('fileUpload').click();
    };

    function removeImage() {
      document.getElementById('removeListImage').value = '1';
      document.getElementById('listImage').src = '';
    }
  });
</script>
