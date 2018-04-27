{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare {% endblock %}

{% block content %}
<div class="re-page re-page--list">
  <div class="list-page-space">
    <div class="re-image" style="background: #f5f5f5 url({{ table['image'] ? table['image'] : 'https://picsum.photos/894/258/?image=' ~ table['id'] }}) center / cover;"></div>
    <div class="re-pre-heading-info">
      <div>{{ table['topic1'] }}</div>
      <div class="re-green">{{ table['subscriberCount'] }} SUBSCRIBERS</div>
      <div class="re-lighten">{{ date("d.m.Y", table['createdAt']) }}</div>
    </div>
    <h1 class="re-heading re-heading--list">{{ table['title'] }}</h1>
    <h2 class="re-subheading re-subheading--list">{{ table['tagline'] }}</h2>
    <p class="re-para">{{ table['description'] }}</p>
    <a class="re-button re-button--double-line" href="subscribe/{{table['id']}}">
      Subscribe
      <div class="re-button__extra-text">Get new listings to your inbox</div>
    </a>
  </div>

  <div class="table-scroll">
    <table class="re-table re-table--list" data-id="{{ table['id'] }}">
      <thead>
        <tr>
          <th>
            <div class="l-button">VOTES <img src="/assets/images/updown.svg" class="updown" /></div>
            <div class="dropdown sort-dropdown u-flex u-flexCol u-flexJustifyCenter l-dropdown">
              <a href="{{table['id']}}"><img src="/assets/images/lightning.svg" /> Sort by <span>Popularity</span></a>

              <a href="{{table['id']}}?orderby=date" class="warning-color"><img src="/assets/images/clock.svg" /> Sort by <span>Newest</span></a>
            </div>
          </th>
          <th class="shadowcontainth"></th>
          <th>{# image #}</th>
          {% for column in tableColumns %}
            <th>{{ column.title }}</th>
          {% endfor %}
        </tr>
      </thead>
      <tbody>
        {% for row in tableContent.items %}
          <tr data-id="{{ row['id'] }}" class="list-row-tr">
            <td>
              <a href="#" class="j_listing-vote vote-link {{ row['userHasVoted'] ? 'vote-link--upvoted' : '' }}">
                <img class="vote-link__image" src="/assets/images/vote-lightning.svg" />
                <img class="vote-link__image vote-link__image--green" src="/assets/images/vote-lightning-green.svg" />
                <div>{{ row['votesCount'] }}</div>
              </a>
            </td>
            <td class="shadowcontaintd">
              <div class="shadowcontain">
                <div class="l-button" style="position: absolute;top: 0;right: 6px;pointer-events: all;cursor: pointer;"><img src="/assets/images/dotdotdot.svg" /></div>
                <div class="dropdown list-row-remove-dropdown u-flex u-flexCol u-flexJustifyCenter l-dropdown">
                  <a href="/row/{{ row['id']}}/delete"><img src="/assets/images/bin.svg" /> Request to remove</a>
                </div>
              </div>
            </td>
            <td>
              <div class="re-table__list-image" style="background: #f5f5f5 url({{ row['image'] }}) center / cover;"></div>
            </td>
            {% for cell in row['content']|json_decode %}
              {% set len = filterTableRowsContent(cell.content)|striptags|length %}
                 {% if len > 160  %}
                 {% set length = 480 %}
                 {% elseif len > 80 %}
                 {% set length = 300 %}
                 {% elseif len > 40 %}
                 {% set length = 175 %}
                 {% elseif len > 20 %}
                 {% set length = 150 %}
                 {% else %}
                 {% set length = 0 %}
                 {% endif %}
              <td style="min-width: {{ length }}px;">{{ filterTableRowsContent(cell.content) }}</td>
            {% endfor %}
          </tr>
          <tr class="re-table-space"></tr>
        {% endfor %}
        <tr class="list-row-tr">
          <td class="pagination-td">
            <div class="pagination">
              <a href="/list/{{ table['id'] }}?page=1&orderby={{orderby}}"><<</a>
              <a href="/list/{{ table['id'] }}?page={{ tableContent.before }}&orderby={{orderby}}"> <</a>
              {% if tableContent.current + 5 < tableContent.total_pages %}
              {% set endPage=tableContent.current + 5 %}
              {% else %}
              {% set endPage=tableContent.total_pages %}
              {% endif %}
              {% if tableContent.current - 5> 1 %}
              {% set startPage=tableContent.current - 5 %}
              {% else %}
              {% set startPage=1 %}
              {% endif %}
              {% for p in startPage..endPage %}
                  {% if p === tableContent.current %}
                  <a class="active" style="color:red" href="/list/{{ table['id'] }}?page={{ p }}&orderby={{orderby}}">{{ p }}</a>
                  {% else %}
                  <a href="/list/{{ table['id'] }}?page={{ p }}&orderby={{orderby}}">{{ p }}</a>
                  {% endif %}
              {% endfor %}
              <a href="/list/{{ table['id'] }}?page={{ tableContent.next }}&orderby={{orderby}}">></a>
              <a href="/list/{{ table['id'] }}?page={{ tableContent.last }}&orderby={{orderby}}">>></a>
            </div>
          </td>
          </tr>
          <tr id="addAListingRowSpace" class="re-table-space" style="display: none;"></tr>
          <tr id="addAListingRow" class="list-row-tr list-row-tr--add-row" style="display: none;">
            <td>
              <a href="#" class="vote-link">
                <img class="vote-link__image" src="/assets/images/vote-lightning.svg" />
                <div>0</div>
              </a>
            </td>
            <td class="shadowcontaintd"><div class="shadowcontain"></div></td>
            <td>
              <div class="re-table__list-image re-table__list-image--new-row" id="addRowImage"></div>
              <input type="file" name="image" id="fileUpload" style="display: none;" />
            </td>
            {% for column in tableColumns %}
              <td><textarea placeholder="{{ column.title }}" rows="1" oninput="$(this).height(5);$(this).height($(this).prop('scrollHeight'))"></textarea></td>
            {% endfor %}
          </tr>
          <tr class="re-table-space"></tr>
      </tbody>
    </table>
  </div>
  <div class="addAListingSubmitAndCancel" id="addAListingSubmitAndCancel" style="display: none;">
    <a class="re-button re-button--list-add-row" href="#" id="addAListingSubmit">Submit</a>
    <a class="re-button re-button--list-add-row re-button--grey" href="#" id="addAListingCancel">Cancel</a>
  </div>
  <a id="addAListingButton" class="re-button re-button--double-line re-button--full-width re-button--tall re-button--grey" href="#">
    Collaborate
    <div class="re-button__extra-text">And reach {{ table['subscriberCount'] }} subscribers of this list</div>
  </a>
</div>


<div class="list-page-section-label">
  ABOUT THIS LIST
</div>
<div class="about-list">
  <div class="about-list__inner">
    <div class="about-list__col">
      <div class="about-list__item">
        <div class="about-list__item__name">ACTIONS</div>
        <div class="about-list__item__content">
          <a class="about-list__action" href="subscribe/{{table['id']}}">Subscribe</a>
          <a class="about-list__action" href="#">Collaborate</a>
          <a class="about-list__action" href="/download/table/{{table['id']}}/csv">Download</a>
          <a class="about-list__action" href="#comment">Comment</a>
          <a class="about-list__action l-button" href="javascript:;" data-dropdown-placement="right">Flag</a>
          <div class="dropdown flag-dropdown u-flex u-flexCol u-flexJustifyCenter l-dropdown">
            <a href="flag/{{table['id']}}/duplicate">Duplicate</a>
            <a href="flag/{{table['id']}}/spam">Spam</a>
            <a href="flag/{{table['id']}}/copyright">Copyright</a>
            <a href="flag/{{table['id']}}/inappropriate">inappropriate</a>
            <a href="flag/{{table['id']}}/other">Other</a>
          </div>
        </div>
      </div>
      <div class="about-list__item">
        <div class="about-list__item__name">STATS</div>
        <div class="about-list__item__content">
          <div class="about-list__part"><b>{{ table['subscriberCount'] }}</b> Subscriptions</div>
          <div class="about-list__part"><b>{{ table['contributionCount'] }}</b> Collaborations</div>
          <div class="about-list__part"><b>{{ table['commentsCount'] }}</b> Comments</div>
        </div>
      </div>
      <div class="about-list__item">
        <div class="about-list__item__name">SHARE</div>
        <div class="about-list__item__content">
          <div class="about-list__part"><a href="#" id="share-twitter">Twitter</a></div>
          <div class="about-list__part"><a id="share-facebook" href="#">Facebook</a></div>
          <div class="about-list__part"><a id="share-hacker" href="#">Hacker News</a></div>
          <div class="about-list__part"><a id="share-reddit" href="#">Reddit</a></div>
        </div>
      </div>
    </div>
    <div class="about-list__col">
      <div class="about-list__item">
        <div class="about-list__item__name">CURATED BY</div>
        <div class="about-list__item__content">
          {{ partial('partials/profile-card', [
            'username': table['creatorHandle'],
            'avatar': table['creatorImage'],
            'name': table['creator'],
            'id': table['ownerUserId'],
            'type': 3
          ]) }}
        </div>
      </div>
      <div class="about-list__item">
        <div class="about-list__item__name">TAGS</div>
        <div class="about-list__item__content">
            {% for tag in tags %}
              <div class="about-list__part">{{tag['title']}}</div>
            {% else %}
              <div class="about-list__part">No Tags</div>
            {% endfor %}
        </div>
      </div>
      <div class="about-list__item">
        <div class="about-list__item__name">REGION</div>
        <div class="about-list__item__content">
          {% for tablelocation in tablemodel.tableLocations %}
            <div class="about-list__part">{{ tablelocation.locations.locationName }}</div>
          {% else %}
            <div class="about-list__part">No Region</div>
          {% endfor %}

        </div>
      </div>
    </div>
  </div>
</div>

{% if related|length %}
  <div class="list-page-section-label">
    RELATED LISTS
  </div>
  <div class="related-lists u-flex u-flexJustifyCenter">
    <div class="related-lists__inner u-flex u-flexWrap">
      {% for relatedTable in related %}
        <div class="related-lists__item">
          <a href="/list/{{ relatedTable['id'] }}"><div class="related-lists__item__name">{{ relatedTable['title'] }}{% if relatedTable['staffPick'] %} <div class="related-lists__item__staff-pick">STAFF PICK 👏</div>{% endif %}</div></a>
          <div class="related-lists__item__descr">{{ relatedTable['tagline']|truncate(42) }}</div>
        </div>
      {% endfor %}
    </div>
  </div>
{% endif %}

<div class="list-tabs">
  <div class="list-tabs__inner">
    <div class="list-tab-buttons">
      <a href="#" class="list-tab-button list-tab-button-discussion active">DISCUSSION</a>
      <a href="#" class="list-tab-button list-tab-button-activity">ACTIVITY</a>
      <a href="#" class="list-tab-button list-tab-button-subscribers">SUBSCRIBERS</a>
      <a href="#" class="list-tab-button list-tab-button-collaborators">COLLABORATORS</a>
    </div>

    <div class="list-tab-content list-tab-content-discussion j_table-discussion" id="comment">
      {% if auth.loggedIn() %}
        <div>
          <button class="re-button re-button--full-width re-button--tall re-button--list-discussion">Write a Response</button>
          <form method="POST" action="/list/{{ table['id'] }}" style="display:none;">
              <input type="hidden" name="parentId" value="" />
              <div class="discussion-textarea">
                <textarea name="comment" placeholder="Write comment here..." minlength="3" maxlength="300"></textarea>
                <button>Send</button>
              </div>
          </form>
        </div>
      {% endif %}
      {% if tableComments %}
        {% for comment in tableComments %}
          <div class="u-flex comment">
            <a href="#" class="j_comment-vote vote-link vote-link--discussion" data-id="{{ comment['id'] }}">
              <img class="vote-link__image" src="/assets/images/vote-lightning.svg" />
              <img class="vote-link__image vote-link__image--green" src="/assets/images/vote-lightning-green.svg" />
              <div>{{ comment['votesCount'] }}</div>
            </a>
            {{ partial('partials/profile-card', [
              'username': comment['creatorHandle'],
              'avatar': comment['creatorImage'],
              'name': comment['creator'],
              'bio': comment['comment'],
              'type': 9,
              'truncate': false,
              'maincomment': true,
              'subcomment': false,
              'commentId': comment['id']
            ]) }}
            <div class="comment-clock"><img src="/assets/images/comment-clock.svg" />{{ formatTimestamp(comment['createdAt']) }}</div>
          </div>
          {% for childComment in comment['childs'] %}
            <div class="u-flex comment" style="margin-left:71px;">
              <a href="#" class="j_comment-vote vote-link vote-link--discussion" data-id="{{ childComment['id'] }}">
                <img class="vote-link__image" src="/assets/images/vote-lightning.svg" />
                <img class="vote-link__image vote-link__image--green" src="/assets/images/vote-lightning-green.svg" />
                <div>{{ childComment['votesCount'] }}</div>
              </a>
              {{ partial('partials/profile-card', [
                'username': childComment['creatorHandle'],
                'avatar': childComment['creatorImage'],
                'name': childComment['creator'],
                'bio': childComment['comment'],
                'type': 9,
                'truncate': false,
                'maincomment': false,
                'subcomment': true,
                'commentId': comment['id']
              ]) }}
              <div class="comment-clock"><img src="/assets/images/comment-clock.svg" />{{ formatTimestamp(childComment['createdAt']) }}</div>
            </div>
          {% endfor %}
          {% if auth.loggedIn() %}
            <form method="POST" action="/list/{{ table['id'] }}" style="display:none;margin-left:80px;margin-top:8px;">
                <input type="hidden" name="parentId" class="commentParentId" value="" />
                <div class="discussion-textarea">
                  <textarea name="comment" class="commentTextArea" placeholder="Write comment here..." minlength="3" maxlength="300"></textarea>
                  <button>Send</button>
                </div>
            </form>
          {% endif %}
        {% endfor %}
      {% else %}
        <div class="empty-discussion">
          No Comments
        </div>
      {% endif %}
    </div>

    <div class="list-tab-content list-tab-content-activity" style="display: none;">
      <div class="empty-activity">
        No Activity
      </div>
    </div>

    <div class="list-tab-content list-tab-content-subscribers" style="display: none;">
      {% for subscriber in tablemodel.tableSubscription %}
        <div class="list-tab-content-subscribers__card">
          {{ partial('partials/profile-card', [
            'id': subscriber.user.id,
            'username': subscriber.user.handle,
            'avatar': subscriber.user.image,
            'name': subscriber.user.name,
            'bio': subscriber.user.tagline,
            'type': 10,
            'truncate': true
          ]) }}
        </div>
      {% else %}
        <div class="empty-subscribers">
          No Subscribers
        </div>
      {% endfor %}
    </div>

    <div class="list-tab-content list-tab-content-collaborators" style="display: none;">
      {% for contributor in tablemodel.contributors %}
        <div class="list-tab-content-collaborators__card">
          {{ partial('partials/profile-card', [
            'id': contributor.users.id,
            'username': contributor.users.handle,
            'avatar': contributor.users.image,
            'name': contributor.users.name,
            'bio': contributor.users.tagline,
            'type': 10,
            'truncate': true
          ]) }}
        </div>
      {% else %}
        <div class="empty-collaborators">
          No Collaborators
        </div>
      {% endfor %}
    </div>
  </div>
</div>

<form method="POST" action="/row/{{ table['id']}}/add" enctype="multipart/form-data" id="form_hidden">

</form>
{% endblock %}

{% block scripts %}
<script type="text/javascript">
  $(document).ready(function () {
    // binds

    $('.list-tab-button-discussion').on('click', function (e) {
      e.preventDefault();
      $('.list-tab-button').removeClass('active');
      $('.list-tab-button-discussion').addClass('active');
      $('.list-tab-content').hide();
      $('.list-tab-content-discussion').show();
    });

    $('.list-tab-button-activity').on('click', function (e) {
      e.preventDefault();
      $('.list-tab-button').removeClass('active');
      $('.list-tab-button-activity').addClass('active');
      $('.list-tab-content').hide();
      $('.list-tab-content-activity').show();
    });

    $('.list-tab-button-subscribers').on('click', function (e) {
      e.preventDefault();
      $('.list-tab-button').removeClass('active');
      $('.list-tab-button-subscribers').addClass('active');
      $('.list-tab-content').hide();
      $('.list-tab-content-subscribers').show();
    });

    $('.list-tab-button-collaborators').on('click', function (e) {
      e.preventDefault();
      $('.list-tab-button').removeClass('active');
      $('.list-tab-button-collaborators').addClass('active');
      $('.list-tab-content').hide();
      $('.list-tab-content-collaborators').show();
    });

    var domUpdateVote = function ($el, vote) {
      var $votesCounter = $el.find('div');
      var votes = Number($votesCounter.text());
      if (vote) {
        $votesCounter.text(votes + 1);
      } else {
        $votesCounter.text(votes - 1);
      }

      if (vote) {
        $el.addClass('vote-link--upvoted');
      } else {
        $el.removeClass('vote-link--upvoted');
      }
    };

    $('.j_listing-vote').on('click', function (e) {
      e.preventDefault();
      var $this = $(this);

      domUpdateVote($this, !$this.hasClass('vote-link--upvoted'));

      // ajax
      var tableId = $this.parents('table').data('id');
      var rowId = $this.parents('tr').data('id');

      $.ajax({
        type: "POST",
        url: '/api/v1/vote-row/' + tableId,
        data: JSON.stringify({ rowId: rowId }),
        success: function (res) {

        },
        contentType: "application/json; charset=utf-8",
        dataType: 'json'
      });
    });

    $('.j_comment-vote').on('click', function (e) {
      e.preventDefault();
      var $this = $(this);

      domUpdateVote($this, !$this.hasClass('vote-link--upvoted'));

      $.ajax({
        type: "POST",
        url: '/api/v1/vote-comment/' + $this.data('id'),
        success: function (res) {

        },
        contentType: "application/json; charset=utf-8",
        dataType: 'json'
      });
    });

    // submit table row

    document.querySelector('input[type="file"]').addEventListener('change', function () {
      if (this.files && this.files[0]) {
        var img = document.querySelector('#addRowImage');
        img.style = 'background: #f5f5f5 url(' + URL.createObjectURL(this.files[0]) + ') center / cover;';
        //img.onload = fn;
      }
    });

    document.getElementById('addRowImage').onclick = function () {
      document.getElementById('fileUpload').click();
    };

    $('#addAListingButton').on('click', function (e) {
      e.preventDefault();
      $(this).hide();
      $('#addAListingRow').show();
      $('#addAListingRowSpace').show();
      $('#addAListingSubmitAndCancel').show();
    });

    $('#addAListingCancel').on('click', function (e) {
      e.preventDefault();
      $('#addAListingButton').show();
      $('#addAListingRow').hide();
      $('#addAListingRowSpace').hide();
      $('#addAListingSubmitAndCancel').hide();
    });

    // Listing submition

    $('#addAListingSubmit').on('click', function (e) {
      e.preventDefault();

      // Clone image input to the hidden form
      var image = $('#fileUpload');
      var image_clone = image.clone();
      image.after(image_clone).appendTo('#form_hidden');

      // clone text aras
      $('#addAListingRow textarea').each(function (txt){
        $( "<input type='hidden' name='cells["+ txt + "]' value='"+ $(this).val() +"' />" ).appendTo( "#form_hidden" );
      });

      $('#form_hidden').submit();
    })

    // discussion stuff

    $('.re-button--list-discussion').on('click', function () {
      $(this).hide().next('form').show()
    });

    $('.j_table-discussion').on('click', '.reply.reply-maincomment', function (ev) {
      ev.preventDefault();
      var target = $(ev.currentTarget);
      var $form = target.parents('.comment').nextAll('form').first();

      $form.show();

      $form.find('.commentParentId').val(target.attr('data-id'));

      $form.find('.commentTextArea').focus();
    });

    $('.j_table-discussion').on('click', '.reply.reply-subcomment', function (ev) {
      ev.preventDefault();
      var target = $(ev.currentTarget);
      var $form = target.parents('.comment').nextAll('form').first();

      $form.show();

      $form.find('.commentTextArea').val('@' + target.attr('data-handle') + ' ');
      $form.find('.commentParentId').val(target.attr('data-id'));

      $form.find('.commentTextArea').focus();
    });
  });


  // Sharing

    var url = window.location.href;
    var title = "{{ table['title'] }}";

  $('#share-twitter').on('click', function (e) {
    e.preventDefault();
    var txt = 'Check this spreadsheet out! ';
    window.open('http://twitter.com/share?url='+encodeURIComponent(url
)+'&text='+encodeURIComponent(txt), '', 'left=0,top=0,width=550,height=450,personalbar=0,toolbar=0,scrollbars=0,resizable=0');
  })

  $('#share-hacker').on('click', function (e) {
    e.preventDefault();
    var txt = 'Check this spreadsheet out! ';
    window.open('https://news.ycombinator.com/submitlink?u='+encodeURIComponent(url
)+'&t='+encodeURIComponent(title), '', 'left=0,top=0,width=550,height=450,personalbar=0,toolbar=0,scrollbars=0,resizable=0');
  })

  $('#share-reddit').on('click', function (e) {
    e.preventDefault();
    var txt = 'Check this spreadsheet out! ';
    window.open('https://www.reddit.com/submit?url='+encodeURIComponent(url
), '', 'left=0,top=0,width=550,height=450,personalbar=0,toolbar=0,scrollbars=0,resizable=0');
  })

  $('#share-facebook').on('click', function (e) {
    e.preventDefault();
    FB.ui({
    method: 'share',
    display: 'popup',
    href: url,
  }, function(response){});
  })



</script>
{% endblock %}
