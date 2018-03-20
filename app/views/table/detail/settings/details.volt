{# image #}
<div class="layout__content__main__personal__column">
  <div class="layout__content__main__personal__profile__text">
    <p>Image</p>
  </div>
  <div class="layout__content__main__personal__row">
    <div class="layout__content__main__personal__profile__photo">
      <img class="listImage" id="listImage" src="{{ table['image'] }}" />
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
        <input type="text" placeholder="Bay Area Seed-stage Business Angels" name="title" value="{{ table['title'] }}" />
        <span>Max <i>100</i> characters</span>
    </div>
</div>
{# slug #}
<div class="addTableEmpty__content__main__options__item">
    <div class="addTableEmpty__content__main__options__item__column">
        <p>Slug</p>
        <input type="text" placeholder="bay-area-seed-stage-business-angels" name="slug" value="{{ table['slug'] }}" />
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
{# description #}
<div class="addTableEmpty__content__main__options__item">
    <div class="addTableEmpty__content__main__options__item__column">
        <p>Description</p>
        <textarea placeholder="Enter description" name="description">{{ table['description'] }}</textarea>
    </div>
</div>
{# topics #}
<div class="addTableEmpty__content__main__options__item">
    <div class="addTableEmpty__content__main__options__item__column">
        <p>Topics</p>
        <div id="TopicsSelect" data-name="topics[]" data-values="{{ reactArray(topics) }}" data-placeholder="Add topics" class="react-component"></div>
        <span>Max <i>2</i> topics</span>
    </div>
</div>
{# content type #}
<div class="addTableEmpty__content__main__options__item">
    <div class="addTableEmpty__content__main__options__item__column">
        <p>Content type</p>
        <div id="ContentTypeSelect" data-name="type" data-value="{{ table['typeId'] }}" class="react-component"></div>
    </div>
</div>
{# tags #}
<div class="addTableEmpty__content__main__options__item">
    <div class="addTableEmpty__content__main__options__item__column">
        <p>Tags</p>
        <div id="TagsSelect" data-name="tags[]" data-value="{{ reactArray(tags) }}" class="react-component"></div>
    </div>
</div>
{# locations #}
<div class="addTableEmpty__content__main__options__item">
    <div class="addTableEmpty__content__main__options__item__column">
        <p>Locations</p>
        <div id="LocationSelect" data-name="location[]" data-value="{{ reactArray(locations) }}" class="react-component"></div>
    </div>
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
