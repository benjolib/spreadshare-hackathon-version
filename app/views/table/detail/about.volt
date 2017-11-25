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
      <!--<div class="tableAbout__info__content__item tableAbout__info__content__item--subscribers">
        <div>Subscribers</div>
        <span></span>
      </div>-->
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
      <div class="tableAbout__sidebar__content">
        <p>Sidebar</p>
      </div>
    </aside>
  </div>

  <p>Comments <span>13</span></p>
  <div class="tableAbout__comments">
    <div class="tableAbout__comments__container">
      <div class="tableAbout__comments__container__avatar">
      <img src="/assets/images/jim_hopper.png" />
      </div>
      <div class="tableAbout__comments__container__content">
        <h4>Jim Hopper</h4>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sodales et leo eu cursus. Proin nec augue sed ante gravida aliquet vitae a libero. Cras id metus et dui aliquam dapibus. Integer eu iaculis lacus. In laoreet sem at ipsum convallis elementum. Phasellus eu facilisis justo, eget hendrerit elit. Mauris consectetur luctus arcu, non porta lorem
        </p>
        {#
        <div class="tableAbout__comments__container__content__stats">
          <div class="tableAbout__comments__container__content__stats__item">
            <div class="icon"></div>
            <div>23</div>
          </div>
          <div class="tableAbout__comments__container__content__stats__item">
            <div class="icon"></div>
            <div>Reply</div>
          </div>
          <div class="tableAbout__comments__container__content__stats__item">
            <div class="icon"></div>
            <div>Report</div>
          </div>
        </div>
        #}
      </div>
      </div>
    </div>
  </div>
</div>

{% endblock %}
