{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare {% endblock %}

{% block content %}
{{ flash.output() }}
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
    <table class="re-table re-table--list" data-id="{{ table['id'] }}">
      <thead>
        <tr>
          <th style="width: 52px;padding-right: 7px;">VOTES</th>
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
              <a href="#" class="vote-link {{ row['userHasVoted'] ? 'vote-link--upvoted' : '' }}">
                <img class="vote-link__image" src="/assets/images/vote-lightning.svg" />
                <img class="vote-link__image vote-link__image--green" src="/assets/images/vote-lightning-green.svg" />
                <div>{{ row['votesCount'] }}</div>
              </a>
            </td>
            <td class="shadowcontaintd"><div class="shadowcontain"></div></td>
            <td>
              <div class="re-table__list-image" style="background: #f5f5f5 url(https://cdn.worldvectorlogo.com/logos/invision.svg) center / cover;"></div>
            </td>
            {% for cell in row['content']|json_decode %}
              {% set len = filterTableRowsContent(cell.content)|length %}
                 {% if len > 160  %}
                 {% set length = 500 %}
                 {% elseif len > 80 %}
                 {% set length = 200 %}
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
      </tbody>
    </table>
  </div>
  <div class="pagination">
    <a href="/list/{{ table['id'] }}?page=1"><<</a>
    <a href="/list/{{ table['id'] }}?page={{ tableContent.before }}"><</a>
    {% if tableContent.current + 5 < tableContent.total_pages %}
      {% set endPage = tableContent.current + 5 %}
    {% else %}
     {% set endPage = tableContent.total_pages %}
    {% endif %}
    {% if tableContent.current - 5 > 1 %} 
      {% set startPage=tableContent.current - 5 %} 
    {% else %} 
      {% set startPage=1 %} 
    {% endif%}

    {% for p in startPage..endPage %}
       {% if p === tableContent.current %}
      <a class="active" style="color:red" href="/list/{{ table['id'] }}?page={{ p }}">{{ p }}</a>
      {% else %}
      <a href="/list/{{ table['id'] }}?page={{ p }}">{{ p }}</a>
      {% endif %}
    {% endfor %}
    <a href="/list/{{ table['id'] }}?page={{ tableContent.next }}">></a>
    <a href="/list/{{ table['id'] }}?page={{ tableContent.last }}">>></a>
  </div>
  <a class="re-button re-button--double-line re-button--full-width re-button--tall re-button--grey" href="#">
    Add a Listing
    <div class="re-button__extra-text">And reach 534 subscribers of this list</div>
  </a>
</div>


<div class="list-page-section-label">
  ABOUT THIS LIST
</div>


{{ dump(table) }}

{# {{ dump(tableStats) }} #}

{{ dump(tableContent) }}

{{ dump(tableComments) }}
{% endblock %}

{% block scripts %}
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
</script>
{% endblock %}
