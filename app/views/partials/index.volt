{% extends 'layouts/main.volt' %}

{# page title #}
{% block title %}SpreadShare - Community curated Tables{% endblock %}

{# page header #}
{% block header %}{% endblock %}

{# main section #}
{% block content %}
  {# hero #}
  <div class="main__hero">
    <p>Collaborate with and get rewarded by the community</p>
    <h2>A marketplace for community-curated tables in the blockchain</h2>
  </div>
  {# content #}
  <div class="main__content">
    {{ flash.output() }}
    {# tables content #}
    <div class="main__content__tables">
      {# filters #}
      <div class="main__content__tables__filters">
        <div class="main__content__tables__filters__left">
          <li>Today</li><img src="/assets/icons/chevron-down.svg" />
        </div>
        <div class="main__content__tables__filters__right">
          <img src="/assets/icons/clock.svg" /><li>Newly Added</li>
          <img src="/assets/icons/upvote.svg" /><li>Most Upvoted</li>
          <img src="/assets/icons/eye.svg" /><li>Most Viewed</li>
          <img src="/assets/icons/comment.svg" /><li>Most Contributed</li>
        </div>
      </div>
      {# cards #}
      <div class="main__content__tables__cards">
        {# card 1 #}
        <div class="main__content__tables__cards__item">
          <div class="main__content__tables__cards__item__info">
            <div class="main__content__tables__cards__item__info__title">
              <h3>Tech Journalist Database</h3>
              <p>A list of over 300 Tech Journalists from all top publications</p>
            </div>
            <div class="main__content__tables__cards__item__info__upvote">
              <img src="/assets/icons/upvote.svg" />
              <div>2.300</div>
            </div>
          </div>
          <div class="main__content__tables__cards__item__stats">
            <div>Growth</div>
            <div>2,345 Tokens</div>
            <div>
              <img src="/assets/icons/eye.svg" /><span><i>2.300</i> Views</span>
            </div>
            <div>
              <img src="/assets/icons/comment.svg" /><span><i>23</i> Contributions</span>
            </div>
          </div>
        </div>
        {# card 2 #}
        <div class="main__content__tables__cards__item">
          <div class="main__content__tables__cards__item__info">
            <div class="main__content__tables__cards__item__info__title">
              <h3>Tech Journalist Database</h3>
              <p>A list of over 300 Tech Journalists from all top publications</p>
            </div>
            <div class="main__content__tables__cards__item__info__upvote">
              <img src="/assets/icons/upvote.svg" />
              <div>2.300</div>
            </div>
          </div>
          <div class="main__content__tables__cards__item__stats">
            <div>Growth</div>
            <div>2,345 Tokens</div>
            <div>
              <img src="/assets/icons/eye.svg" /><span><i>2.300</i> Views</span>
            </div>
            <div>
              <img src="/assets/icons/comment.svg" /><span><i>23</i> Contributions</span>
            </div>
          </div>
        </div>
        {# card 3 #}
        <div class="main__content__tables__cards__item">
          <div class="main__content__tables__cards__item__info">
            <div class="main__content__tables__cards__item__info__title">
              <h3>Tech Journalist Database</h3>
              <p>A list of over 300 Tech Journalists from all top publications</p>
            </div>
            <div class="main__content__tables__cards__item__info__upvote">
              <img src="/assets/icons/upvote.svg" />
              <div>2.300</div>
            </div>
          </div>
          <div class="main__content__tables__cards__item__stats">
            <div>Growth</div>
            <div>2,345 Tokens</div>
            <div>
              <img src="/assets/icons/eye.svg" /><span><i>2.300</i> Views</span>
            </div>
            <div>
              <img src="/assets/icons/comment.svg" /><span><i>23</i> Contributions</span>
            </div>
          </div>
        </div>
        {# card 4 #}
        <div class="main__content__tables__cards__item">
          <div class="main__content__tables__cards__item__info">
            <div class="main__content__tables__cards__item__info__title">
              <h3>Tech Journalist Database</h3>
              <p>A list of over 300 Tech Journalists from all top publications</p>
            </div>
            <div class="main__content__tables__cards__item__info__upvote">
              <img src="/assets/icons/upvote.svg" />
              <div>2.300</div>
            </div>
          </div>
          <div class="main__content__tables__cards__item__stats">
            <div>Growth</div>
            <div>2,345 Tokens</div>
            <div>
              <img src="/assets/icons/eye.svg" /><span><i>2.300</i> Views</span>
            </div>
            <div>
              <img src="/assets/icons/comment.svg" /><span><i>23</i> Contributions</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    {# sidebar #}
    <div class="main__content__sidebar">
      <div class="main__content__sidebar__option">
        <a>Categories</a><img src="/assets/icons/chevron-down.svg" />
      </div>
      <div class="main__content__sidebar__option">
        <a>Table Type</a><img src="/assets/icons/chevron-down.svg" />
      </div>
      <div class="main__content__sidebar__option">
        <a>Tags</a><img src="/assets/icons/chevron-down.svg" />
      </div>
      <div class="main__content__sidebar__option">
        <a>Geography</a><img src="/assets/icons/chevron-down.svg" />
      </div>
    </div>
  </div>
{% endblock %}
