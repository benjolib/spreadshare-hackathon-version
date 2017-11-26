{% extends 'layouts/main.volt' %}

{% block content %}

{{ partial('table/detail/header') }}

<div class="tableAbout">
  <div class="tableAbout__info">
    <div class="tableAbout__info__content tableAbout__info__content--left">
      <div class="tableAbout__info__content__item tableAbout__info__content__item--topic">
        <div>Topic</div>
        <span>{{ table['topic1'] }}</span>
        <span>{{ table['topic2'] }}</span>
      </div>
      <div class="tableAbout__info__content__item--created">
        <div>Created</div>
        <span>{{ formatTimestamp(table['createdAt']) }}</span>
      </div>
      <div class="tableAbout__info__content__item--type">
        <div>Type</div>
        <span>{{ table['typeTitle'] }}</span>
      </div>
      <div class="tableAbout__info__content__item--locations">
        <div>Locations</div>
        <span>{{ implode('</span><span>', explode(', ', table['locations'])) }}</span>
      </div>
      <div class="tableAbout__info__content__item--creator">
        <div>Creator</div>
        <span><img src="{{ table['creatorImage'] }}" height="20" /> {{ table['creator'] }}</span>
      </div>
    </div>
    <div class="tableAbout__info__content tableAbout__info__content--right">
      <div class="tableAbout__info__content__item tableAbout__info__content__item--views">
        <div>Views</div>
        <span>{{ table['viewsCount'] }}</span>
      </div>
      <div class="tableAbout__info__content__item tableAbout__info__content__item--subscribers">
        <div>Subscribers</div>
        <span>{{ table['subscriberCount'] }}</span>
      </div>
      <div class="tableAbout__info__content__item tableAbout__info__content__item--contributions">
        <div>Contributions</div>
        <span>{{ table['contributionCount'] }}</span>
      </div>
      <div class="tableAbout__info__content__item tableAbout__info__content__item--contributors">
        <div>Contributors</div>
        <span>{{ table['collaboratorCount'] }}</span>
      </div>
      <div class="tableAbout__info__content__item tableAbout__info__content__item--token">
        <div>Token</div>
        <span>{{ table['tokensCount'] }}</span>
      </div>
    </div>

    <aside class="tableAbout__sidebar">
      <div class="tableAbout__sidebar__content tags">
        <span>{{ implode('</span><span>', explode(', ', table['tags'])) }}</span>
      </div>
    </aside>
  </div>

  <p>Comments <span>{{ comments|length }}</span></p>
  <div class="tableAbout__comments">
    {% for comment in comments %}
      {{ partial('table/detail/comment') }}

      <div style="margin-left:20px;padding-left:20px; border-left:1px solid #f2f2f8;">
        {% for comment in comment['childs'] %}
          {{ partial('table/detail/subcomment') }}
        {% endfor %}
      </div>
    {% endfor %}

    {% if auth.loggedIn() %}
    <div>
      <form method="POST" action="/table/{{ table['id'] }}/about">
        <input type="hidden" name="parentId" id="commentParentId" value="" />
        <textarea name="comment" id="commentTextArea" placeholder="Add a comment"></textarea>
        <button>Send</button>
      </form>
    </div>
    {% endif %}
  </div>
</div>

{% endblock %}

{% block scripts %}
<script type="text/javascript">
  $(document).ready(function () {
    $('.tableAbout__comments__container').on('click', '.reply', function (ev) {
      var target = $(ev.currentTarget);

      $('#commentTextArea').val('@' + target.attr('data-handle') + ' ');
      $('#commentParentId').val(target.attr('data-id'));

      document.getElementById('commentTextArea').focus();
    });
  });
</script>
{% endblock %}
