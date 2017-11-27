{% extends 'layouts/main.volt' %}

{% block content %}
{{ partial('table/detail/header') }}

<div class="tableAbout">
  <div class="tableAbout__outer">
    <div class="tableAbout__inner">
      <div class="tableAbout__info">
        <div class="tableAbout__info__content tableAbout__info__content--left">
          <div class="tableAbout__info__content__item tableAbout__info__content__item--topic">
            <div>Topic</div>
            <div>
              {% if table['topic1'] %}
              <span>{{ table['topic1'] }}</span>
              {% endif %}
              {% if table['topic2'] %}
              <span>{{ table['topic2'] }}</span>
              {% endif %}
            </div>
          </div>
          <div class="tableAbout__info__content__item tableAbout__info__content__item--created">
            <div>Created</div>
            <div>
              <span>{{ formatTimestamp(table['createdAt']) }}</span>
            </div>
          </div>
          <div class="tableAbout__info__content__item tableAbout__info__content__item--type">
            <div>Type</div>
            <div>
              <span>{{ table['typeTitle'] }}</span>
            </div>
          </div>
          <div class="tableAbout__info__content__item tableAbout__info__content__item--locations">
            <div>Locations</div>
            <div>
              <span>{{ implode('</span><span>', explode(', ', table['locations'])) }}</span>
            </div>
          </div>
          <div class="tableAbout__info__content__item tableAbout__info__content__item--creator">
            <div>Creator</div>
            <div>
              <span><img src="{{ table['creatorImage'] }}" height="20" /> <i>{{ table['creator'] }}</i></span>
            </div>
          </div>
        </div>
        <div class="tableAbout__info__content tableAbout__info__content--right">
          <div class="tableAbout__info__content__item tableAbout__info__content__item--views">
            <div>Views</div>
            <div>{{ table['viewsCount'] }}</div>
          </div>
          <div class="tableAbout__info__content__item tableAbout__info__content__item--subscribers">
            <div>Subscribers</div>
            <div>{{ table['subscriberCount'] }}</div>
          </div>
          <div class="tableAbout__info__content__item tableAbout__info__content__item--contributions">
            <div>Contributions</div>
            <div>{{ table['contributionCount'] }}</div>
          </div>
          <div class="tableAbout__info__content__item tableAbout__info__content__item--contributors">
            <div>Contributors</div>
            <div>{{ table['collaboratorCount'] }}</div>
          </div>
          <div class="tableAbout__info__content__item tableAbout__info__content__item--token">
            <div>Token</div>
            <div>{{ table['tokensCount'] }}</div>
          </div>
        </div>
      </div>
      <div class="tableAbout__sidebars">
        <p class="tableAbout__sidebars__title">Related Tables</p>
        <aside class="tableAbout__sidebar tableAbout__sidebar--related">
          <div class="tableAbout__sidebar__content">
            {% for related in relatedTables %}
            <a href="/table/{{ related['id'] }}">
              <div class="tableAbout__sidebar__content__item">
                <h5>{{ related['title'] }}</h5>
                <p>{{ related['tagline'] }}</p>
              </div>
            </a>
            {% endfor %}
          </div>
        </aside>

        <p class="tableAbout__sidebars__title">Tags</p>
        <aside class="tableAbout__sidebar tableAbout__sidebar--tags">
          <div class="tableAbout__sidebar__content">
            <span>{{ implode('</span><span>', explode(', ', table['tags'])) }}</span>
          </div>
        </aside>

        <p class="tableAbout__sidebars__title">Share</p>
        <aside class="tableAbout__sidebar tableAbout__sidebar--share">
          <div class="tableAbout__sidebar__content">
            <div class="tableAbout__sidebar__content__item tableAbout__sidebar__content__item--twitter"></div>
            <div class="tableAbout__sidebar__content__item tableAbout__sidebar__content__item--facebook"></div>
            <div class="tableAbout__sidebar__content__item tableAbout__sidebar__content__item--medium"></div>
            <div class="tableAbout__sidebar__content__item tableAbout__sidebar__content__item--linkedin"></div>
            <div class="tableAbout__sidebar__content__item tableAbout__sidebar__content__item--googleplus"></div>
            <div class="tableAbout__sidebar__content__item tableAbout__sidebar__content__item--quora"></div>
            <div class="tableAbout__sidebar__content__item tableAbout__sidebar__content__item--stackoverflow"></div>
            <div class="tableAbout__sidebar__content__item tableAbout__sidebar__content__item--github"></div>
            <div class="tableAbout__sidebar__content__item tableAbout__sidebar__content__item--ycombinator"></div>
            <div class="tableAbout__sidebar__content__item tableAbout__sidebar__content__item--angellist"></div>
          </div>
        </aside>
      </div>
    </div>

    {{ partial('table/detail/about/comments') }}
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
