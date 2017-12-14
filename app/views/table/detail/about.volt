{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - About table {{ table['title'] }}{% endblock %}

{% block content %}
{{ partial('table/detail/header') }}

<div class="tableAbout">
  <div class="tableAbout__outer">
    <div class="tableAbout__inner">
      <div class="tableAbout__info">
        <div class="tableAbout__info__row">
            {% if table['topic1'] and table['topic2'] %}
            <div class="tableAbout__info__content tableAbout__info__content--left" style="padding-bottom: 8px;">
            {% elseif table['topic1'] or table['topic2'] %}
            <div class="tableAbout__info__content tableAbout__info__content--left" style="padding-bottom: 20px;">
            {% endif %}
            <div class="tableAbout__info__content__item tableAbout__info__content__item--topic">
              <p>Topic</p>
              <div>
                {% if table['topic1'] %}
                <div>{{ table['topic1'] }}</div>
                {% endif %}
                {% if table['topic2'] %}
                <div>{{ table['topic2'] }}</div>
                {% endif %}
              </div>
            </div>
            <div class="tableAbout__info__content__item tableAbout__info__content__item--created">
              <p>Created</p>
              <div>
                <span>{{ formatTimestamp(table['createdAt']) }}</span>
              </div>
            </div>
            <div class="tableAbout__info__content__item tableAbout__info__content__item--type">
              <p>Type</p>
              <div>
                {% if table['typeTitle'] %}
                <span>{{ table['typeTitle'] }}</span>
                {% endif %}
              </div>
            </div>
            <div class="tableAbout__info__content__item tableAbout__info__content__item--locations">
              <p>Locations</p>
              <div>
                {% if table['locations'] %}
                    <span>{{ implode('</span>, <span>', explode(', ', table['locations'])) }}</span>
                {% else %}
                    <span>No location specified</span>
                {% endif %}
              </div>
            </div>
            <div class="tableAbout__info__content__item tableAbout__info__content__item--creator">
              <p>Creator</p>
              <div>
                <span><a href="/user/{{ table['creatorHandle'] }}"><img src="{{ table['creatorImage'] }}" height="20" /> <i>{{ table['creator'] }}</i></a></span>
              </div>
            </div>
          </div>
          <div class="tableAbout__info__content tableAbout__info__content--right">
            <div class="tableAbout__info__content__item tableAbout__info__content__item--views">
              <p>Views</p>
              <div>{{ table['viewsCount'] }}</div>
            </div>
            <div class="tableAbout__info__content__item tableAbout__info__content__item--subscribers">
              <p>Subscribers</p>
              <div>{{ table['subscriberCount'] }}</div>
            </div>
            <div class="tableAbout__info__content__item tableAbout__info__content__item--contributions">
              <p>Contributions</p>
              <div>{{ table['contributionCount'] }}</div>
            </div>
            <div class="tableAbout__info__content__item tableAbout__info__content__item--contributors">
              <p>Contributors</p>
              <div>{{ table['collaboratorCount'] }}</div>
            </div>
            <div class="tableAbout__info__content__item tableAbout__info__content__item--token">
              <p>Token</p>
              <div>{{ table['tokensCount'] }}</div>
            </div>
          </div>
        </div>
        {{ partial('table/detail/about/comments') }}
      </div>
      <div class="tableAbout__sidebars">
        <p class="tableAbout__sidebars__title">Related Tables</p>
        <aside class="tableAbout__sidebar tableAbout__sidebar--related">
          <div class="tableAbout__sidebar__content">
            {% if relatedTables %}
            {% for related in relatedTables %}
            <a href="/table/{{ related['id'] }}">
              <div class="tableAbout__sidebar__content__item">
                <h5>{{ related['title'] }}</h5>
                <p>{{ related['tagline'] }}</p>
              </div>
            </a>
            {% endfor %}
            {% else %}
            <div class="center">
              <img src="/assets/images/gameboy.png" alt="" />
              <p>&nbsp;</p>
              <p>No related tables assigned, yet.</p>
            </div>
            {% endif %}
          </div>
        </aside>

        {% if table['tags'] %}
        <p class="tableAbout__sidebars__title">Tags</p>
        <aside class="tableAbout__sidebar tableAbout__sidebar--tags">
          <div class="tableAbout__sidebar__content">
            <span>{{ implode('</span><span>', explode(', ', table['tags'])) }}</span>
          </div>
        </aside>
        {% endif %}

        <p class="tableAbout__sidebars__title">Share</p>
        <aside class="tableAbout__sidebar tableAbout__sidebar--share">
          <div class="tableAbout__sidebar__content socialshares" data-url="http://beta.spreadshare.co/table/{{ table['id'] }}" data-title="{{ table['title'] }}"
          data-description="Community curated tables!" data-size="small"
          data-theme="brand" data-icononly>
            <div class="socialshares-twitter"></div>
            <div class="socialshares-facebook"></div>
            <div class="socialshares-pinterest"></div>
            <div class="socialshares-googleplus"></div>
            <div class="socialshares-reddit"></div>
            <div class="socialshares-tumblr"></div>
            <div class="socialshares-email"></div>
            <div class="socialshares-more"></div>
          </div>
        </aside>
      </div>
    </div>

  </div>
</div>
{% endblock %}

{% block scripts %}
<script type="text/javascript">
  function linkify(inputText) {
  var replacedText, replacePattern1, replacePattern2, replacePattern3;

  //URLs starting with http://, https://
  replacePattern1 = /(\b(https?):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
  replacedText = inputText.replace(replacePattern1, '<a href="$1" target="_blank">$1</a>');

  //URLs starting with "www." (without // before it, or it'd re-link the ones done above).
  replacePattern2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
  replacedText = replacedText.replace(replacePattern2, '$1<a href="http://$2" target="_blank">$2</a>');

  //Change email addresses to mailto:: links.
  replacePattern3 = /(([a-zA-Z0-9\-\_\.])+@[a-zA-Z\_]+?(\.[a-zA-Z]{2,6})+)/gim;
  replacedText = replacedText.replace(replacePattern3, '<a href="mailto:$1">$1</a>');

  return replacedText;
  }

  $(document).ready(function () {
  $('.tableAbout__comments__container').on('click', '.reply', function (ev) {
    var target = $(ev.currentTarget);

    $('#commentTextArea').val('@' + target.attr('data-handle') + ' ');
    $('#commentParentId').val(target.attr('data-id'));

    document.getElementById('commentTextArea').focus();
  });

  $('div.tableAbout__comments__container__content p').each(function (idx, el) {
    $(el).html(linkify(el.innerHTML));
  })
  });
</script>
<script src="https://unpkg.com/socialshares@2/dist/socialshares.min.js" defer></script>
{{ partial('table/detail/flag') }}
{% endblock %}
