{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
  <div class="re-page re-page--create-list">
    <form id="createListFrom" method="post" action="/create-list" enctype="multipart/form-data">
      <div class="re-image re-image--create-list">
        <div class="re-image__upload-button"></div>
        <div class="re-image__delete-button"></div>
      </div>
      <input type="file" name="image" id="re-image-fileUpload" style="display: none;" />
      <div class="re-heading-input">
        <img class="re-heading-input__tick" src="/assets/images/input-tick.svg" />
        <img class="re-heading-input__tick-green" src="/assets/images/input-tick-green.svg" />
        {{ text_field('name', 'placeholder':"Your publication's title") }}
        {#<input type="text" placeholder="Your publication's title" name="name" />#}
      </div>
      <div class="re-subheading-input">
        <img class="re-heading-input__tick" src="/assets/images/input-tick.svg" />
        <img class="re-heading-input__tick-green" src="/assets/images/input-tick-green.svg" />
          {{ text_field('tagline', 'placeholder':"Write a tagline for your publication") }}
        {#<input type="text" placeholder="Write a tagline for your publication" name="tagline" />#}
      </div>
      <div class="re-para-input">
        <img class="re-heading-input__tick" src="/assets/images/input-tick.svg" />
        <img class="re-heading-input__tick-green" src="/assets/images/input-tick-green.svg" />
          {{ text_field('description', 'placeholder':"Write a short description text") }}
        {#<input type="text" placeholder="Write a short desciption text" name="description" />#}
      </div>

      <div class="create-list-add-tags">
        <img class="re-heading-input__tick" src="/assets/images/input-tick.svg" />
        <img class="re-heading-input__tick-green" src="/assets/images/input-tick-green.svg" />
        <p>Add at least 3 tags: {{ text_field('tags', 'placeholder':"Tags") }}{#<input type="text" placeholder="Tags" name="tags" />#}</p>
      </div>
      <div class="create-list-has-thumbnails">
        <img class="re-heading-input__tick" src="/assets/images/input-tick.svg" />
        <img class="re-heading-input__tick-green" src="/assets/images/input-tick-green.svg" />
        <p>
          Do your posts have thumbnails?
        </p>
        <label class="on-off-switch">
          {# <input type="checkbox" name="thumbnails" /> #}
          {{ check_field('thumbnails') }}
          <div class="on-off">
            <span class="on">On</span>
            <span class="off">Off</span>
          </div>
        </label>
      </div>
      <div class="create-list-add-curator">
        <p>If there are other curators than you? {{ text_field('curators', 'placeholder':"Curators") }}{#<input type="text" placeholder="Curators" name="curators" />#}</p>
      </div>
      <div class="create-list-add-related">
        <p>Related lists: {{ text_field('related-lists', 'placeholder':"Related") }}{#<input type="text" placeholder="Related" name="related-lists" />#}</p>
      </div>

      <div class="create-create-list-tabs">
        <div class="create-create-list-tabs__inner">
          <div class="create-list-tab-buttons u-flex extra-small-gutter">
            <a href="#" class="re-button re-button--full-width extra-small-margin create-list-tab-button create-list-tab-button-copy">Copy Paste content from a site</a>
            <a href="#" class="re-button re-button--grey re-button--full-width extra-small-margin create-list-tab-button create-list-tab-button-import">Upload your list as a CSV file</a>
          </div>

          <div class="create-list-tab-content create-list-tab-content-copy">
              {% if tableColumns is not empty %}
                  {{ partial('create-list/list') }}
                  {% else %}
                    <div class="create-list-copy-textarea-container">
              <textarea class="create-list-copy-textarea" placeholder="Paste here" name="copy"></textarea>
              <button class="re-button create-list-copy-button">Format to List</button>
                    </div>
              {% endif %}
            <div class="l-button create-list-copy-seperator-chooser" data-dropdown-placement="bottom-start">
              SEPERATE BY
              <div class="create-list-copy-seperator-chooser__seperator">COMMA <img src="/assets/images/create-list-copy-dropdown-arrow.svg" /></div>
            </div>
            <div class="dropdown seperator-dropdown u-flex u-flexCol u-flexJustifyCenter l-dropdown">
              <a href="#" class="active">Comma</a>
              <a href="#">Semicolon</a>
              <a href="#">Space</a>
              <a href="#">Tab</a>
            </div>
            <input type="text" value="," name="seperator" />
          </div>

          <div class="create-list-tab-content create-list-tab-content-import" style="display: none;">
            <div class="u-flex small-gutter">
              <div class="small-margin" style="width: 100%;"></div>
              <a href="#" class="re-button re-button--full-width small-margin" id="file-upload-button"><img class="re-button__icon" src="/assets/images/create-list-import-browse-file.svg" /> Browse File</a>
              <input type="file" name="file" id="create-list-fileUpload" style="display: none;" />
              <div class="small-margin" style="width: 100%;"></div>
            </div>
          </div>

        </div>
      </div>

      <input type="hidden" id="create-list-step" name="step" value="1" />
      <input type="hidden" id="list-columns" name="list-columns" value="" />
      <input type="hidden" id="list-rows" name="list-rows" value="" />
    </form>
  </div>
{% endblock %}

{% block scripts %}
  <script type="text/javascript">
    $(document).ready(function () {
      document.querySelector('#re-image-fileUpload').addEventListener('change', function () {
        if (this.files && this.files[0]) {
          var img = $('.re-image');
          img.attr('style', 'background: #f5f5f5 url(' + URL.createObjectURL(this.files[0]) + ') center / cover;');
          //img.onload = fn;
        }
      });
      document.querySelector('.re-image__upload-button').onclick = function () {
        document.getElementById('re-image-fileUpload').click();
      };
      document.querySelector('.re-image__delete-button').onclick = function () {
        document.getElementById('re-image-fileUpload').value = "";
        var img = $('.re-image');
        img.attr('style', 'background: #f5f5f5 url() center / cover;');
      };

      document.querySelector('#file-upload-button').onclick = function () {
        document.getElementById('create-list-fileUpload').click();
      };

      $('.create-list-tab-button-import').on('click', function (e) {
        e.preventDefault();
        $('.create-list-tab-button').addClass('re-button--grey');
        $('.create-list-tab-button-import').removeClass('re-button--grey');
        $('.create-list-tab-content').hide();
        $('.create-list-tab-content-import').show();
      });

      $('.create-list-tab-button-copy').on('click', function (e) {
        e.preventDefault();
        $('.create-list-tab-button').addClass('re-button--grey');
        $('.create-list-tab-button-copy').removeClass('re-button--grey');
        $('.create-list-tab-content').hide();
        $('.create-list-tab-content-copy').show();
      });

      $('.create-list-copy-button').on('click', function (e) {
        e.preventDefault();

        $('#createListFrom').submit();
      });

      $('.re-header .save-button').on('click', function (e) {
        e.preventDefault();

        var listColumns = $('.re-table th:nth-of-type(1n+4)').map(function(){ return this.innerText });
        var listRows = $('.re-table tr.list-row-tr:not(.list-row-tr--add-row)').map(function(){
          var $this = $(this);
          return {
            id: $this.data('id'),
            image: $this.find('.re-table__list-image').attr('style'),
            content: $this.find('td:nth-of-type(1n+4) div').map(function(){
              return this.innerText;
            }).get(),
          }
        });

        $('#create-list-step').val('2');
        $('#list-columns').val(JSON.stringify(listColumns.get()));
        $('#list-rows').val(JSON.stringify(listRows.get().map(function (row) {
          return {
            id: row.id,
            content: row.content,
            image: row.image.replace('background: #f5f5f5 url(', '').replace(') center / cover;', '')
          };
        })));

        $('#createListFrom').submit();
      });
    });
  </script>
{% endblock %}
