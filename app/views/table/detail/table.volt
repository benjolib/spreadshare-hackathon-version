{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - {{ table['title'] }} - {{ table['topic1'] }}{% endblock %}

{% block content %}
<div class="re-page re-page--list">
  <div style="margin-bottom: 118px;">
    <div class="re-image" style="background: #f5f5f5 url({{ table['image'] }}) center / cover;"></div>
    <div class="re-pre-heading-info">
      <div>{{ table['topic1'] }}</div>
      <div class="re-green">{{ table['tokensCount'] }} TOKEN</div>
      <div class="re-lighten">{{ date("d.m.Y", table['createdAt']) }}</div>
    </div>
    <h1 class="re-heading re-heading--list">{{ table['title'] }}</h1>
    <h2 class="re-subheading re-subheading--list">{{ table['tagline'] }}</h2>
    <p class="re-para">We've asked some of the world's best designers to help us curate the best and most useful blogs, books, games, videos, and tutorials that helped them learn critical elements of design. We're organizing them all into a digestible and iterative lesson plan so you can apply this knowledge to your own projects.</p>
    <a class="re-button re-button--double-line" href="#">
      Subscribe
      <div class="re-button__extra-text">Get new listings to your inbox</div>
    <a>
  </div>

  <div class="table-scroll">
    <div class="shadowcontain"><!-- o --></div>
    <div class="scroll-wrapper">
      <table class="re-table re-table--list" data-id="{{ table['id'] }}">
        <thead>
          <tr>
            <th style="width: 52px;padding-right: 7px;">VOTES</th>
            <th class="shadowcontainth"></th>
            <th>{# image #}</th>
            {% for column in tableContent['columns'] %}
              <th>{{ column['title'] }}</th>
            {% endfor %}
          </tr>
        </thead>
        <tbody>
          {% for row in tableRows %}
            <tr data-id="{{ row['id'] }}">
              <td>
                <a href="#" class="vote-link {{ row['upvoted'] ? 'vote-link--upvoted' : '' }}">
                  <img class="vote-link__image" src="/assets/images/vote-lightning.svg" />
                  <img class="vote-link__image vote-link__image--green" src="/assets/images/vote-lightning-green.svg" />
                  <div>{{ row['votes'] }}</div>
                </a>
              </td>
              <td class="shadowcontaintd"><div class="shadowcontain"></div></td>
              <td>
                <div class="re-table__list-image" style="background: #f5f5f5 url(https://cdn.worldvectorlogo.com/logos/invision.svg) center / cover;"></div>
              </td>
              {% for cell in row['content'] %}
                <td style="min-width: {{ cell['minWidth'] }}px;">{{ cell['content'] }}</td>
              {% endfor %}
            </tr>
            <tr class="re-table-space"></tr>
          {% endfor %}
        </tbody>
      </table>
    </div>
  </div>
  <a class="re-button re-button--double-line re-button--full-width re-button--tall re-button--grey" href="#">
    Add a Listing
    <div class="re-button__extra-text">And reach 534 subscribers of this list</div>
  </a>
</div>


<div class="list-page-section-label">
  ABOUT THIS STREAM
</div>
<div class="about-list">
  <div class="about-list__inner">
    <div class="about-list__col">
      <div class="about-list__item">
        <div class="about-list__item__name">ACTIONS</div>
        <div class="about-list__item__content">
          <a class="about-list__action" href="#">Subscribe</a>
          <a class="about-list__action" href="#">Collaborate</a>
          <a class="about-list__action" href="#">Download</a>
          <a class="about-list__action" href="#">Comment</a>
          <a class="about-list__action" href="#">Flag</a>
        </div>
      </div>
      <div class="about-list__item">
        <div class="about-list__item__name">STATS</div>
        <div class="about-list__item__content">
          <div class="about-list__part"><b>546</b> Tokens</div>
          <div class="about-list__part"><b>345</b> Subscriptions</div>
          <div class="about-list__part"><b>50</b> Collaborations</div>
          <div class="about-list__part"><b>5</b> Comments</div>
        </div>
      </div>
      <div class="about-list__item">
        <div class="about-list__item__name">SHARE</div>
        <div class="about-list__item__content">
          <div class="about-list__part">Twitter</div>
          <div class="about-list__part">Facebook</div>
          <div class="about-list__part">Hacker News</div>
          <div class="about-list__part">Reddit</div>
        </div>
      </div>
    </div>
    <div class="about-list__col">
      <div class="about-list__item">
        <div class="about-list__item__name">CURATOR</div>
        <div class="about-list__item__content">
          {{ partial('partials/profile-card', [
            'username': 'andewcoyle',
            'avatar': 'https://cdn-images-1.medium.com/fit/c/100/100/1*iRHlXdQhKPpyNJ0w6f7ijw.jpeg',
            'name': 'Andrew Coyle',
            'type': 3
          ]) }}
        </div>
      </div>
      <div class="about-list__item">
        <div class="about-list__item__name">TAGS</div>
        <div class="about-list__item__content">
          <div class="about-list__part">Design Tools</div>
          <div class="about-list__part">UI & UX Design</div>
          <div class="about-list__part">Graphic Design</div>
          <div class="about-list__part">Prototyping</div>
          <div class="about-list__part">Click Dummies</div>
        </div>
      </div>
      <div class="about-list__item">
        <div class="about-list__item__name">REGION</div>
        <div class="about-list__item__content">
          <div class="about-list__part">All Regions</div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="list-page-section-label">
  RELATED STREAMS
</div>
<div class="related-lists u-flex u-flexJustifyCenter">
  <div class="related-lists__inner u-flex u-flexWrap">
    <div class="related-lists__item">
      <div class="related-lists__item__name">Wireframing Resources</div>
      <div class="related-lists__item__descr">Tools, articles, tutorials and people to f…</div>
    </div>
    <div class="related-lists__item">
      <div class="related-lists__item__name">Prototyping Tools</div>
      <div class="related-lists__item__descr">Tools to build click dummies and prototypes</div>
    </div>
    <div class="related-lists__item">
      <div class="related-lists__item__name">Sketch Plugins</div>
      <div class="related-lists__item__descr">A list of Sketch plugin’s to upgrade your...</div>
    </div>
    <div class="related-lists__item">
      <div class="related-lists__item__name">Awesome Click Dummies <div class="related-lists__item__staff-pick">STAFF PICK 👏</div></div>
      <div class="related-lists__item__descr">I am curating the most awesome click dumm…</div>
    </div>
  </div>
</div>

<div class="list-tabs">
  <div class="list-tabs__inner">
    <div class="list-tab-buttons">
      <a href="#" class="list-tab-button list-tab-button-discussion active">DISCUSSION</a>
      <a href="#" class="list-tab-button list-tab-button-activity">ACTIVITY</a>
      <a href="#" class="list-tab-button list-tab-button-audience">AUDIENCE</a>
    </div>

    <div class="list-tab-content list-tab-content-discussion j_table-discussion">
      {% if auth.loggedIn() %}
        <div>
          <button class="re-button re-button--full-width re-button--tall re-button--list-discussion" style="display:none;">Write a Response</button>
          <form method="POST" action="/table/{{ table['id'] }}">
              <input type="hidden" name="parentId" id="commentParentId" value="" />
              <div class="discussion-textarea">
                <textarea name="comment" id="commentTextArea" placeholder="Write comment here..." minlength="3" maxlength="300"></textarea>
                <button>Send</button>
              </div>
          </form>
        </div>
      {% endif %}
      {% if tableComments %}
        {% for comment in tableComments %}
          <div class="u-flex u-flexAlignItemsCenter">
            <a href="#" class="vote-link vote-link--discussion vote-link--upvoted">
              <img class="vote-link__image vote-link__image--green" src="/assets/images/vote-lightning-green.svg" />
              <div>{{ comment['votesCount'] }}</div>
            </a>
            {{ partial('partials/profile-card', [
              'username': comment['creatorHandle'],
              'avatar': comment['creatorImage'],
              'name': comment['creator'],
              'bio': comment['comment'],
              'type': 9,
              'truncate': false
            ]) }}
          </div>
          {% for comment in comment['childs'] %}
            {{ partial('partials/profile-card', [
              'username': comment['creatorHandle'],
              'avatar': comment['creatorImage'],
              'name': comment['creator'],
              'bio': comment['comment'],
              'type': 9,
              'truncate': false
            ]) }}
          {% endfor %}

          {# <div class="tableAbout__comments__content__subcomments">
            {% for comment in comment['childs'] %}
            {{ partial('table/detail/subcomment') }}
            {% endfor %}
          </div> #}
        {% endfor %}
      {% endif %}
    </div>

    <div class="list-tab-content list-tab-content-activity" style="display: none;">
      list activity
    </div>

    <div class="list-tab-content list-tab-content-audience" style="display: none;">
      <div class="list-tab-content-audience__card">
        {{ partial('partials/profile-card', [
          'username': 'andewcoyle',
          'avatar': 'https://cdn-images-1.medium.com/fit/c/100/100/1*iRHlXdQhKPpyNJ0w6f7ijw.jpeg',
          'name': 'Andrew Coyle',
          'bio': 'Designing the future of global trade @Flexport. Curating lists at Spreadshare.',
          'type': 4
        ]) }}
      </div>
      <div class="list-tab-content-audience__card">
        {{ partial('partials/profile-card', [
          'username': 'andewcoyle',
          'avatar': 'https://cdn-images-1.medium.com/fit/c/100/100/1*iRHlXdQhKPpyNJ0w6f7ijw.jpeg',
          'name': 'Andrew Coyle',
          'bio': 'Designing the future of global trade @Flexport. Curating lists at Spreadshare.',
          'type': 4
        ]) }}
      </div>
      <div class="list-tab-content-audience__card">
        {{ partial('partials/profile-card', [
          'username': 'andewcoyle',
          'avatar': 'https://cdn-images-1.medium.com/fit/c/100/100/1*iRHlXdQhKPpyNJ0w6f7ijw.jpeg',
          'name': 'Andrew Coyle',
          'bio': 'Designing the future of global trade @Flexport. Curating lists at Spreadshare.',
          'type': 4
        ]) }}
      </div>
      <div class="list-tab-content-audience__card">
        {{ partial('partials/profile-card', [
          'username': 'andewcoyle',
          'avatar': 'https://cdn-images-1.medium.com/fit/c/100/100/1*iRHlXdQhKPpyNJ0w6f7ijw.jpeg',
          'name': 'Andrew Coyle',
          'bio': 'Designing the future of global trade @Flexport. Curating lists at Spreadshare.',
          'type': 4
        ]) }}
      </div>
    </div>
  </div>
</div>

{{ dump(table) }}

{# {{ dump(tableStats) }} #}

{{ dump(tableContent) }}

{# {{ dump(tableContent['votes']) }} #}

{# {{ dump(tableContent['rows']) }} #}

{{ dump(tableContent['columns']) }}

{{ dump(tableRows) }}

{{ dump(tableComments) }}


{# {{ dump(tableContentRowsWithVotes) }} #}


{# <div class="table">
  {{ partial('table/detail/header') }}

  {{ dump(table) }}

  <div id="tableContainer">
    <div id="Table" data-id="{{ table['id'] }}" data-permission="{% if auth.getUserId() == table['ownerUserId'] %}2{% elseif auth.loggedIn() %}1{% else %}0{% endif %}" class="react-component">
        <br/>
        <br/>
        <div class="loading"></div>
        <br/>
        <br/>
    </div>
  </div>
</div> #}
{% endblock %}


{% block scripts %}
{# {{ partial('table/detail/flag') }}


<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Table",
  "about": "{{ table['title'] }}"
  "description": "{{ table['tagline'] }}",
  "keywords": "{{ table['tags'] }}",
  "dateCreated": " {{ table['createdAt'] }}",
  "author": {
    "@type": "Person",
    "image": "{{ table['creatorImage'] }}",
    "name": "{{ table['creator'] }}",
    "sameAs": "/user/{{ table['creatorHandle'] }}"
  }
}
</script> #}

<script type="text/javascript">
  $(document).ready(function () {
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

    $('.list-tab-button-audience').on('click', function (e) {
      e.preventDefault();
      $('.list-tab-button').removeClass('active');
      $('.list-tab-button-audience').addClass('active');
      $('.list-tab-content').hide();
      $('.list-tab-content-audience').show();
    });

    $('.shadowcontain').each(function () {
      var $this = $(this);
      $this.height($this.parents('tr').height() - 3);
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

    $('.vote-link').on('click', function (e) {
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

    // discussion stuff

    $('.j_table-discussion').on('click', '.reply', function (ev) {
      ev.preventDefault();
      var target = $(ev.currentTarget);

      $('#commentTextArea').val('@' + target.attr('data-handle') + ' ');
      $('#commentParentId').val(target.attr('data-id'));

      document.getElementById('commentTextArea').focus();
    });
  });
</script>
{% endblock %}
