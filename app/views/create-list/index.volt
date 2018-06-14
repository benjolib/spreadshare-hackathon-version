{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}

  <div class="re-page re-page--create-list">
    <form id="createListFrom" method="post" action="/create-list" enctype="multipart/form-data">
    
        {% if tempImage is defined %}
            {%  set imageStyle='background: #f5f5f5 url(/temptableimages/'~tempImage~') center / cover;' %}
            {{ hidden_field('tempImage','value':tempImage) }}
        {% else %}
            {% set imageStyle='' %}
        {% endif %}      <div class="re-image re-image--create-list" style="{{ imageStyle }}">
        <div class="re-image__upload-button"></div>
        <div class="re-image__delete-button"></div>
      </div>
      <input type="file" name="image" id="re-image-fileUpload" style="display: none;" />
      <div class="re-heading-input">
        <img class="re-heading-input__tick" src="/assets/images/input-tick.svg" />
        <img class="re-heading-input__tick-green" src="/assets/images/input-tick-green.svg" />
        <div class="ui input" style="width:100%">
        {{ text_field('name', 'placeholder':"Your publication's title", 'autocomplete':"off") }}
        {#<input type="text" placeholder="Your publication's title" name="name" style="border:0px" />#}
      </div>
      </div>
      <div class="re-subheading-input">
        <img class="re-heading-input__tick" src="/assets/images/input-tick.svg" />
        <img class="re-heading-input__tick-green" src="/assets/images/input-tick-green.svg" />
        <div class="ui input" style="width:100%">
          {{ text_field('tagline', 'placeholder':"Write a tagline for your publication", 'autocomplete':"off") }}
        {#<input type="text" placeholder="Write a tagline for your publication" name="tagline" style="border:0px"/>#}
        </div>
      </div>
      <div class="re-para-input">
        <img class="re-heading-input__tick" src="/assets/images/input-tick.svg" />
        <img class="re-heading-input__tick-green" src="/assets/images/input-tick-green.svg" />
        <div class="ui input" style="width:100%">
          {{ text_field('description', 'placeholder':"Write a short description text", 'autocomplete':"off") }}
        {#<input type="text" placeholder="Write a short desciption text" name="description" style="border:0px" />#}
      </div>
      </div>

      <div class="create-list-add-tags">
        <img class="re-heading-input__tick" src="/assets/images/input-tick.svg" />
        <img class="re-heading-input__tick-green" src="/assets/images/input-tick-green.svg" />
       

        
          <select name="tags" multiple="" class="ui search fluid dropdown">
          <option value="">Add at least 3 tags</option>
          <option value="angular" selected>Angular</option>
          <option value="css" selected>CSS</option>
          <option value="design">Graphic Design</option>
          <option value="ember">Ember</option>
          <option value="html">HTML</option>
          <option value="ia">Information Architecture</option>
          <option value="javascript">Javascript</option>
          <option value="mech">Mechanical Engineering</option>
          <option value="meteor">Meteor</option>
          <option value="node">NodeJS</option>
          <option value="plumbing">Plumbing</option>
          <option value="python">Python</option>
          <option value="rails">Rails</option>
          <option value="react">React</option>
          <option value="repair">Kitchen Repair</option>
          <option value="ruby">Ruby</option>
          <option value="ui">UI Design</option>
          <option value="ux">User Experience</option>
        </select>
   

      </div>
      <!--<div class="create-list-has-thumbnails">
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
      </div>-->
      <div class="create-list-add-curator">
       <!-- <p>If there are other curators than you? {{ text_field('curators', 'placeholder':"Curators") }}{#<input type="text" placeholder="Curators" name="curators" />#}</p>
      -->
      <div class="ui fluid multiple search selection dropdown">
  <input type="hidden" name="country">
  <i class="dropdown icon"></i>
  <div class="default text">Select other curators</div>
  <div class="menu">
  <div class="item" data-value="af"><i class="af flag"></i>Afghanistan</div>
  <div class="item" data-value="ax"><i class="ax flag"></i>Aland Islands</div>
  </div></div>
      </div>






      <div class="create-list-add-curator">
       <!-- <p>If there are other curators than you? {{ text_field('related-lists', 'placeholder':"Related") }}{#<input type="text" placeholder="Related" name="related-list" />#}</p>
      -->
      <div class="ui fluid multiple search selection dropdown">
  <input type="hidden" name="related-lists">
  <i class="dropdown icon"></i>
  <div class="default text">Pick a related lists</div>
  <div class="menu">

  </div></div>
      </div>

      <div class="create-list-add-related">
        <!--<p>Related lists: {{ text_field('related-lists', 'placeholder':"Related") }}{#<input type="text" placeholder="Related" name="related-lists" />#}</p>
    -->
      <select name="related-lists" multiple="" class="ui search fluid dropdown">
  
        </select>      
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
                      {{ text_area('copy', 'placeholder':'Paste here','class':'create-list-copy-textarea') }}
              {#<textarea class="create-list-copy-textarea" placeholder="Paste here" name="copy"></textarea>#}
              <button class="re-button create-list-copy-button">Format to List</button>
                    </div>
              {% endif %}
            <!--<div class="l-button create-list-copy-seperator-chooser" data-dropdown-placement="bottom-start">
              SEPERATE BY
              <div class="create-list-copy-seperator-chooser__seperator">COMMA <img src="/assets/images/create-list-copy-dropdown-arrow.svg" /></div>
            </div>
            <div class="dropdown seperator-dropdown u-flex u-flexCol u-flexJustifyCenter l-dropdown">
              <a href="#" class="active">Comma</a>
              <a href="#">Semicolon</a>
              <a href="#">Space</a>
              <a href="#">Tab</a>
            </div>
            <input type="text" value="," name="seperator" />-->
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
  
  $('.ui.dropdown').dropdown({
  allowAdditions: true,
   apiSettings: {
      // this url parses query server side and returns filtered results
      url: '/api/v2/tags/?q={query}'
    }
});
    $(document).ready(function () {
      $('.ui.dropdown').style = "visibility:hidden"
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

      document.querySelector('#create-list-fileUpload').addEventListener('change', function () {
        $('#createListFrom').submit();
      });
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

      // list edit stuff

      function listCellEditableSizing() {
        console.log('blinput');
        var $this = $(this);

        var len = $this.text().length;
        console.log(len);
        var minWidth = 0;
        if (len > 160) {
          minWidth = 480;
        } else if (len > 80) {
          minWidth = 300;
        } else if (len > 40) {
          minWidth = 175;
        } else if (len > 20) {
          minWidth = 150;
        }

        $this.parents('td').attr('style', 'min-width:' + minWidth + 'px;');
      }

      function bindListCellEditableSizing() {
        console.log('blon');
        $('.re-table tr.list-row-tr:not(.list-row-tr--add-row) td:nth-of-type(1n+4) div').on('input', listCellEditableSizing);
      }

      function unbindListCellEditableSizing() {
        console.log('bloff');
        $('.re-table tr.list-row-tr:not(.list-row-tr--add-row) td:nth-of-type(1n+4) div').off('input', listCellEditableSizing);
      }

      function linkifyAndDropdownifyCells() {
        $('.re-table tr.list-row-tr:not(.list-row-tr--add-row)').each(function(){
          $(this).find('td:nth-of-type(1n+4) div').each(function(){
            var $this = $(this);
            var maxPos = 161;
            var rawText = $this.text();
            var text = '';
            var linkStrippedText = rawText.replace(/((http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?)/g, function (match) {
              return (new URL(match))['host'].replace('www.', '');
            });
            if (linkStrippedText.length > maxPos) {
              var lastPos = maxPos - 3;
              text = rawText.substr(0, lastPos);
              text = text.substr(0, Math.min(text.length, text.lastIndexOf(" "))) + '...';
              text += '<a href="javascript:;" class="table-cell-show-more-button l-button" data-dropdown-placement="bottom">More</a>';
              text += '<div class="l-dropdown dropdown table-cell-show-more-dropdown">' + rawText + '</div>';
            } else {
              text = rawText;
            }
            text = text.replace(/((http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?)/g, function (match) {
              return '<a class="re-table-link" target="_blank" title="' + match + '" href="' + match + '">' + (new URL(match))['host'].replace('www.', '') + '</a>';
            })
            $this.html(text);
          });
          window.bindPops();
        });
      }

      function unlinkifyAndUnDropdownifyCells() {
        $('.re-table').find('.re-table-link').replaceWith($('.re-table').find('.re-table-link').attr('href'));
        $('.table-cell-show-more-dropdown').each(function(){
          var $this = $(this);
          $this.parents('td').html('<div>' + $this.text() + '</div>');
        });
      }

      $('.re-table__list-image-fileUpload').on('change', function () {
        if (this.files && this.files[0]) {
          var img = $(this).parents('td').find('.re-table__list-image');
          img.removeClass('re-table__list-image--empty');
          img.attr('style', 'background: #f5f5f5 url(' + URL.createObjectURL(this.files[0]) + ') center / cover;');
          //img.onload = fn;
        }
      });
      $('.re-table__list-image__upload-button').on('click', function () {
        $(this).parents('td').find('.re-table__list-image-fileUpload').click();
      });
      $('.re-table__list-image__delete-button').on('click', function () {
        $(this).parents('td').find('.re-table__list-image-fileUpload').val('');
        var img = $(this).parents('td').find('.re-table__list-image');
        img.addClass('re-table__list-image--empty');
        img.attr('style', 'background: #f5f5f5 url() center / cover;');
      });


      function startEditList () {
        unlinkifyAndUnDropdownifyCells();

        $('.re-table th:nth-of-type(1n+4)').attr('contenteditable', 'true');
        $('.re-table tr.list-row-tr:not(.list-row-tr--add-row) td:nth-of-type(1n+4) div').attr('contenteditable', 'true');
        $('.re-table__list-image').addClass('re-table__list-image--editing');
        bindListCellEditableSizing();
      }

      startEditList();

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
