{% extends 'layouts/main.volt' %}

{% block content %}

{{ partial('table/detail/header') }}

<div class="tableAbout">
  <div class="tableAbout__info">
    <div class="tableAbout__info__content tableAbout__info__content--left">
      <div class="tableAbout__info__content__item tableAbout__info__content__item--topic">
        <div>Topic</div>
        <span>Growth</span>
        <span>Design</span>
      </div>
      <div class="tableAbout__info__content__item--created">
        <div>Created</div>
        <span>20 Jul 2017</span>
      </div>
      <div class="tableAbout__info__content__item--type">
        <div>Type</div>
        <span>People & Contacts</span>
      </div>
      <div class="tableAbout__info__content__item--locations">
        <div>Locations</div>
        <span>Europe</span>
      </div>
      <div class="tableAbout__info__content__item--creator">
        <div>Creator</div>
        <span>Benjamin Libor</span>
      </div>
    </div>
    <div class="tableAbout__info__content tableAbout__info__content--right">
      <div class="tableAbout__info__content__item tableAbout__info__content__item--views">
        <div>Views</div>
        <span>10,200</span>
      </div>
      <div class="tableAbout__info__content__item tableAbout__info__content__item--subscribers">
        <div>Subscribers</div>
        <span>58</span>
      </div>
      <div class="tableAbout__info__content__item tableAbout__info__content__item--contributions">
        <div>Contributions</div>
        <span>435</span>
      </div>
      <div class="tableAbout__info__content__item tableAbout__info__content__item--contributors">
        <div>Contributors</div>
        <span>33</span>
      </div>
      <div class="tableAbout__info__content__item tableAbout__info__content__item--token">
        <div>Token</div>
        <span>324</span>
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
