{% extends 'layouts/main.volt' %} {% block header %} {% endblock %} {% block content %}
<div class="re-page re-page--create-list">
  <form id="createListFrom" method="post" action="" enctype="multipart/form-data">
    {% if tableId is defined %} {{ hidden_field('tableId', 'value':tableId) }} {% endif %}
    {% if tempImage is defined %} {% set imageStyle='background: #f5f5f5 url('~tempImage~') center / cover;'
    %} {# TODO I don't think the hidden field is needed anymore #} {{ hidden_field('tempImage','value':tempImage) }} {% else %} {% set imageStyle='' %} {% endif %}
    <div class="re-image re-image--create-list"
      style="{{ imageStyle }}">
      <div class="re-image__upload-button"></div>
       <!-- <div class="re-image__delete-button" style="display:none"></div>  -->
    </div>
    <input type="file" name="image" id="re-image-fileUpload" style="display: none;" />
    
    
    
    <div class="re-heading-input">
      <img class="re-heading-input__tick titledisabled" src="/assets/images/input-tick.svg" />
      <img id="titlechecked" class="re-heading-input__tick-green titlechecked" src="/assets/images/input-tick-green.svg" />
      <div class="ui input" style="width:100%">
        {% if post['name'] is not defined %}
        {% set post['name'] = "" %}
        {% endif %}
        {{ text_field('name', 'placeholder':"Your publication's title", 'autocomplete':"off", 'value':post['name']) }} {#
        <input type="text" placeholder="Your publication's title" name="name" style="border:0px" />#}
      </div>
    </div>
    <div class="re-subheading-input">
      <img class="re-heading-input__tick taglinedisabled" src="/assets/images/input-tick.svg" />
      <img class="re-heading-input__tick-green taglinechecked" src="/assets/images/input-tick-green.svg" />
      <div class="ui input" style="width:100%">
       {% if post['tagline'] is not defined %}
        {% set post['tagline'] = "" %}
        {% endif %}
        {{ text_field('tagline', 'placeholder':"Write a tagline for your publication", 'autocomplete':"off", 'value':post['tagline']) }} {#
        <input type="text" placeholder="Write a tagline for your publication" name="tagline" style="border:0px" />#}
      </div>
    </div>
    <div class="re-para-input">
      <img class="re-heading-input__tick descdisabled" src="/assets/images/input-tick.svg" />
      <img class="re-heading-input__tick-green descchecked" src="/assets/images/input-tick-green.svg" />
      <div class="ui input" style="width:100%">
       {% if post['description'] is not defined %}
        {% set post['description'] = "" %}
        {% endif %}
        {{ text_field('description', 'placeholder':"Write a short description text", 'autocomplete':"off", 'value':post['description']) }} {#
        <input type="text" placeholder="Write a short desciption text" name="description" style="border:0px" />#}
      </div>
    </div>



    <div class="create-list-add-tags">
      <img class="re-heading-input__tick tagsdisabled" src="/assets/images/input-tick.svg" />
      <img class="re-heading-input__tick-green tagschecked" src="/assets/images/input-tick-green.svg" />
   
      <div class="ui fluid multiple search selection dropdown tags">
      
        {% if post['tags'] is not defined %}
        {% set post['tags'] = "" %}
        {% else %}
        {% set post['tags'] = implode(",", post['tags']) %}
        {% endif %}
        {{ hidden_field('tags', 'placeholder':"Tags", 'value': post['tags']) }}

      
        <i class="dropdown icon"></i>
        <div class="default text input">Add at least 3 tags</div>
        <div class="menu">
        {% if tagsNames is defined %}
        {% for index, tag in tagsNames %}
          <div class="item" data-value='{{ post['tags'][index] }}'>{{ tag }}</div>
        {%  endfor %}
        {% endif %}

              
        </div>
      </div>
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

    <div class="create-list-add-curators">
        
      <div class="ui fluid curators multiple search selection dropdown">
       {% if post['curators'] is not defined %}
        {% set post['curators'] = "" %}
        {% else %}
        {% set post['curators'] = implode(",", post['curators']) %}
        {% endif %}
         {{ hidden_field('curators', 'placeholder':"Curators", 'value': post['curators']) }}
        <i class="sh-dropdown icon"></i>
        <div class="default text"><b><u>Optional</u></b>  Add another person if you're curating in a team</div>
        <div class="menu">
        {% if curatorsNames is defined %}
        {% for index, curator in curatorsNames %}
          <div class="item" data-value='{{ post['curators'][index] }}'>{{ curator }}</div>
        {%  endfor %}
        {% endif %}
      </div>
    </div></div>


    <div class="create-list-add-related">

      <div class="ui fluid multiple search selection dropdown related">
        
        {% if post['related-lists'] is not defined %}
        {% set post['related-lists'] = "" %}
        {% else %}
        {% set post['related-lists'] = implode(",", post['related-lists']) %}
        {% endif %}

        {{ hidden_field('related-lists', 'placeholder':"Related Lists", 'value':post['related-lists']) }}
        <i class="dropdown icon"></i>
        <div class="default text"><u>Optional</u></b> Recommend related lists to your subscribers</div>
        <div class="menu">
        {% if relatedListsNames is defined %}
        {% for index, related in relatedListsNames %}
          <div class="item" data-value='{{ post['related-lists'][index] }}'>{{ related }}</div>
        {%  endfor %}
        {% endif %}
      </div>

    </div></div>


    
 
    <div class="create-create-list-tabs">
      <div class="create-create-list-tabs__inner">
      {% if editing %}
       
      {% else %}
        <div class="create-list-tab-buttons u-flex extra-small-gutter">
          <a href="#" class="re-button re-button--full-width extra-small-margin create-list-tab-button create-list-tab-button-copy">Copy Paste content from a site</a>
          <a href="#" class="re-button re-button--grey re-button--full-width extra-small-margin create-list-tab-button create-list-tab-button-import">Upload your list from a CSV file</a>
        </div>
      {% endif %}
        <div class="create-list-tab-content create-list-tab-content-copy">
          {% if tableColumns is not empty %} {{ partial('create-list/list') }} {% else %}
          <div class="create-list-copy-textarea-container">
            {{ text_area('copy', 'placeholder':'Paste here','class':'create-list-copy-textarea') }} {#
            <textarea class="create-list-copy-textarea" placeholder="Paste here" name="copy"></textarea>#}
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
            <a href="#" class="re-button re-button--full-width small-margin" id="file-upload-button">
              <img class="re-button__icon" src="/assets/images/create-list-import-browse-file.svg" /> Browse File</a>
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
{% endblock %} {% block scripts %}
<script type="text/javascript">
  var x,y,top,left,down,moving;

$(".table-scroll").mousedown(function(e){
   // e.preventDefault();
    $(e.target).closest(".table-scroll").addClass("moving");
    moving = $(e.target).closest(".table-scroll");
    down = true;
    x = e.pageX;
    y = e.pageY;
    top = $(this).scrollTop();
    left = $(this).scrollLeft();
});

$("body").mousemove(function(e){
    if(down){
        
        var newX = e.pageX;
        var newY = e.pageY;

 $(".moving").scrollTop(top - newY + y);
 $(".moving").scrollLeft(left - newX + x);
    }
});

$("body").mouseup(function(e){
    down = false;
    $(moving).removeClass("moving");
    });
  $(document).ready(function () {
    $('.ui.dropdown.tags').dropdown({
    allowAdditions: true,
    apiSettings: {
      // this url parses query server side and returns filtered results
      url: '/api/v2/tags/?q={query}'
    },
    label: {
  transition : 'horizontal flip',
  duration   : 200,
  variation  : false
},
  });
  $('.ui.dropdown.curators').dropdown({
    allowAdditions: true,
    apiSettings: {
      // this url parses query server side and returns filtered results
      url: '/api/v2/curators/?q={query}'
    },
    label: {
  transition : 'horizontal flip',
  duration   : 200,
  variation  : false
},
  });
  $('.ui.dropdown.related').dropdown({
    allowAdditions: true,
    label: {
  transition : 'horizontal flip',
  duration   : 200,
  variation  : false
},
    apiSettings: {
      // this url parses query server side and returns filtered results
 url: '/api/v2/streams/?q={query}'
    }
  });
     $('.empty ').initial({height:82, width:82 });
    $('.empty ').css('border-radius', "6px")  
    $(".search").keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
    })

     if(tags.value.split(",").map(Number).length >= 1) {
       $('.tagschecked').show()
            $('.tagsdisabled').hide()
     }
   
     if(document.getElementById("name").value.length > 3) {
       $('.titlechecked').show()
            $('.titledisabled').hide()
     }
     if(tagline.value.length > 3) {
       $('.taglinechecked').show()
            $('.taglinedisabled').hide()
     }
      if(description.value.length >= 3) {
       $('.descchecked').show()
            $('.descdisabled').hide()
     }
     if(tags.value.split(",").map(Number).length >= 1) {
       $('.tagschecked').show()
            $('.tagsdisabled').hide()
     }

    $('.ui.input input').on('input', function(e) { 
      console.log(e.target.name, e.target.value.length)
      if(e.target.name ==='name'){
        if(e.target.value.length > 3){
            $('.titlechecked').show()
            $('.titledisabled').hide()
        }else {
             $('.titlechecked').hide()
             $('.titledisabled').show()
        }
      }
       if(e.target.name ==='tagline'){
        if(e.target.value.length > 3){
          console.log("here")
            $('.taglinechecked').show()
            $('.taglinedisabled').hide()
        }else {
             $('.taglinechecked').hide()
             $('.taglinedisabled').show()
        }
      }
      
      if(e.target.name ==='description'){
        if(e.target.value.length > 3){
            $('.descchecked').show()
            $('.descdisabled').hide()
        }else {
             $('.descchecked').hide()
             $('.descdisabled').show()
        }
      }
      
     });
    $('.ui.multiple').on('change', function(e) { 
      console.log("tag",tags.value.split(",").map(Number).length)
        if(tags.value.split(",").map(Number).length >=3){
            $('.tagschecked').show()
            $('.tagsdisabled').hide()
        }else {
             $('.tagschecked').hide()
             $('.tagsdisabled').show()
        }
    })
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
    // document.querySelector('.re-image__delete-button').onclick = function () {
    //   if(document.getElementById('re-image-fileUpload').value != ""){
    //         document.getElementById('re-image-fileUpload').value = "";
    //         var img = $('.re-image');
    //         img.attr('style', '');
    //   }
      
      
    // };

    document.querySelector('#create-list-fileUpload').addEventListener('change', function () {
      $('#createListFrom').submit();
    });
    document.querySelector('#file-upload-button').onclick = function () {
      var vimage = document.querySelector(".re-image--create-list").style["background"] == "" ? false : true;
      var vtitle = document.getElementById("name").value.length > 3 ? true : false
      var vtagline = document.getElementById("tagline").value.length > 3 ? true : false
      var vdescription = document.getElementById("tagline").value.length > 3 ? true : false
      var vtags = document.getElementById("tags").value.split(",").map(Number).length >= 3 ? true : false
      if (vimage && vtitle && vtagline && vdescription && vtags) {
       document.getElementById('create-list-fileUpload').click();
      } else {
        $("html, body").animate({
          scrollTop: 0
        }, "slow");
      }
      
      
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
      var vimage = document.querySelector(".re-image--create-list").style["background"] == "" ? false : true;
      var vtitle = document.getElementById("name").value.length > 3 ? true : false
      var vtagline = document.getElementById("tagline").value.length > 3 ? true : false
      var vdescription = document.getElementById("tagline").value.length > 3 ? true : false
      var vtags = document.getElementById("tags").value.split(",").map(Number).length >= 3 ? true : false
      var vcopy = document.getElementById("copy").value.length > 3 ? true : false
      if (vimage && vtitle && vtagline && vdescription && vtags && vcopy) {
        $('#createListFrom').submit();
      } else {
        $("html, body").animate({
          scrollTop: 0
        }, "slow");
      }

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
      $('.re-table tr.list-row-tr:not(.list-row-tr--add-row) td:nth-of-type(1n+4) div').on('input',
        listCellEditableSizing);
    }

    function unbindListCellEditableSizing() {
      console.log('bloff');
      $('.re-table tr.list-row-tr:not(.list-row-tr--add-row) td:nth-of-type(1n+4) div').off('input',
        listCellEditableSizing);
    }

    function linkifyAndDropdownifyCells() {
      $('.re-table tr.list-row-tr:not(.list-row-tr--add-row)').each(function () {
        $(this).find('td:nth-of-type(1n+4) div').each(function () {
          var $this = $(this);
          var maxPos = 161;
          var rawText = $this.text();
          var text = '';
          var linkStrippedText = rawText.replace(
            /((http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?)/g,
            function (match) {
              return (new URL(match))['host'].replace('www.', '');
            });
          if (linkStrippedText.length > maxPos) {
            var lastPos = maxPos - 3;
            text = rawText.substr(0, lastPos);
            text = text.substr(0, Math.min(text.length, text.lastIndexOf(" "))) + '...';
            text +=
              '<a href="javascript:;" class="table-cell-show-more-button l-button" data-dropdown-placement="bottom">More</a>';
            text += '<div class="l-dropdown sh-dropdown table-cell-show-more-dropdown">' + rawText + '</div>';
          } else {
            text = rawText;
          }
          text = text.replace(
            /((http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?)/g,
            function (match) {
              return '<a class="re-table-link" target="_blank" title="' + match + '" href="' + match +
                '">' + (new URL(match))['host'].replace('www.', '') + '</a>';
            })
          $this.html(text);
        });
        window.bindPops();
      });
    }

    function unlinkifyAndUnDropdownifyCells() {
      $('.re-table').find('.re-table-link').replaceWith($('.re-table').find('.re-table-link').attr('href'));
      $('.table-cell-show-more-dropdown').each(function () {
        var $this = $(this);
        $this.parents('td').html('<div>' + $this.text() + '</div>');
      });
    }

    $('.re-table__list-image-fileUpload').on('change', function () {
      if (this.files && this.files[0]) {
        
        var img = $(this).parents('td').find('.re-table__list-image');
        img.removeClass('re-table__list-image--empty');
        img.attr('style', 'background: #f5f5f5 url(' + URL.createObjectURL(this.files[0]) + ') center / cover;');
        console.log("where", img.find('img'))
        img.find('img')[0].setAttribute("style", "visibility:hidden;");
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


    function startEditList() {
      unlinkifyAndUnDropdownifyCells();

      $('.re-table th:nth-of-type(1n+4)').attr('contenteditable', 'true');
      $('.re-table tr.list-row-tr:not(.list-row-tr--add-row) td:nth-of-type(1n+4) div').attr('contenteditable',
        'true');
      $('.re-table__list-image').addClass('re-table__list-image--editing');
      bindListCellEditableSizing();
    }

    startEditList();

    $('.re-header .save-button').on('click', function (e) {
      e.preventDefault();

      var listColumns = $('.re-table th:nth-of-type(1n+4)').map(function () {
        return this.innerText
      });
      var listRows = $('.re-table tr.list-row-tr:not(.list-row-tr--add-row)').map(function () {
        var $this = $(this);
        return {
          id: $this[0]['id'],

          image: $this.find('.re-table__list-image').attr('style'),
          content: $this.find('td:nth-of-type(1n+4) div').map(function () {
            
            return this.innerText;
          }).get(),
        }
      });

      $('#create-list-step').val('2');
      $('#list-columns').val(JSON.stringify(listColumns.get()));
      
      $('#list-rows').val(JSON.stringify(listRows.get().map(function (row, index) {
        var c = {}
        c['id'] = row.id
        c['content'] = row.content
        
        return {
          id: row.id,
          row: c,
          image: row.image.replace('background: #f5f5f5 url(', '').replace(') center / cover;', '')
        };
      })));

      $('#createListFrom').submit();
    });




  });
</script>

{% endblock %}