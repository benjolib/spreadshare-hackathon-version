{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
<div class="profile">
  {{ flash.output() }}
  <div class="profile__hero">
    <div class="profile__row">
      <div class="profile__hero__avatar">
        <img src="/assets/images/eleven.png" />
      </div>
      <div class="profile__hero__info">
        <div class="profile__hero__info__name"><h3>Jane Ives (Eleven)</h3></div>
        <div class="profile__hero__info__tagline">
          <p>I got superpowers, do not mess with me. Waffle lover.</p>
        </div>
        <div class="profile__row profile__row">
          <div class="profile__hero__info__location">
            <p>Hawkins, Indiana</p>
          </div>
          <div class="profile__hero__info__website">
            <span>●</span>
            <a href="https://netflix.com/" target="_blank">netflix.com</a>
          </div>
          <div class="profile__hero__info__mobile">
            <div class="profile__hero__info__mobile__website">
              <a href="https://netflix.com/" target="_blank">netflix.com</a>
              <span>●</span>
            </div>
            <div class="profile__hero__info__mobile__social">
              <ul>
              <li><a href="#"><img src="/assets/icons/twitter.svg" /></a></li>
              <li><a href="#"><img src="/assets/icons/facebook.svg" /></a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="profile__row profile__row--pushToBottom">
          <div class="profile__hero__info__edit">
            <button>Edit</button>
          </div>
          <div class="profile__hero__info__social">
            <ul>
            <li><a href="#"><img src="/assets/icons/twitter.svg" /></a></li>
            <li><a href="#"><img src="/assets/icons/facebook.svg" /></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="profile__content">
    <div class="profile__content__wrapper">
      <div class="profile__content__tables">
        <div class="profile__content__tables__cards">
          {# card 1 #}
          <div class="profile__content__tables__cards__item">
            <div class="profile__content__tables__cards__item__info">
              <div class="profile__content__tables__cards__item__info__title">
                <h3>Tech Journalist Database</h3>
                <p>A list of over 300 Tech Journalists from all top publications</p>
              </div>
              <div class="profile__content__tables__cards__item__info__upvote table-card-upvoted">
                <img src="/assets/icons/upvoted.svg" />
                <div>2.300</div>
              </div>
            </div>
            <div class="profile__content__tables__cards__item__stats">
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
          <div class="profile__content__tables__cards__item">
            <div class="profile__content__tables__cards__item__info">
              <div class="profile__content__tables__cards__item__info__title">
                <h3>Tech Journalist Database</h3>
                <p>A list of over 300 Tech Journalists from all top publications</p>
              </div>
              <div class="profile__content__tables__cards__item__info__upvote table-card-upvoted">
                <img src="/assets/icons/upvoted.svg" />
                <div>2.300</div>
              </div>
            </div>
            <div class="profile__content__tables__cards__item__stats">
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
          <div class="profile__content__tables__cards__item">
            <div class="profile__content__tables__cards__item__info">
              <div class="profile__content__tables__cards__item__info__title">
                <h3>Tech Journalist Database</h3>
                <p>A list of over 300 Tech Journalists from all top publications</p>
              </div>
              <div class="profile__content__tables__cards__item__info__upvote table-card-upvoted">
                <img src="/assets/icons/upvoted.svg" />
                <div>2.300</div>
              </div>
            </div>
            <div class="profile__content__tables__cards__item__stats">
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
          <div class="profile__content__tables__cards__item">
            <div class="profile__content__tables__cards__item__info">
              <div class="profile__content__tables__cards__item__info__title">
                <h3>Tech Journalist Database</h3>
                <p>A list of over 300 Tech Journalists from all top publications</p>
              </div>
              <div class="profile__content__tables__cards__item__info__upvote table-card-upvoted">
                <img src="/assets/icons/upvoted.svg" />
                <div>2.300</div>
              </div>
            </div>
            <div class="profile__content__tables__cards__item__stats">
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
          {# card 5 #}
          <div class="profile__content__tables__cards__item">
            <div class="profile__content__tables__cards__item__info">
              <div class="profile__content__tables__cards__item__info__title">
                <h3>Tech Journalist Database</h3>
                <p>A list of over 300 Tech Journalists from all top publications</p>
              </div>
              <div class="profile__content__tables__cards__item__info__upvote table-card-upvoted">
                <img src="/assets/icons/upvoted.svg" />
                <div>2.300</div>
              </div>
            </div>
            <div class="profile__content__tables__cards__item__stats">
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
          {# card 6 #}
          <div class="profile__content__tables__cards__item">
            <div class="profile__content__tables__cards__item__info">
              <div class="profile__content__tables__cards__item__info__title">
                <h3>Tech Journalist Database</h3>
                <p>A list of over 300 Tech Journalists from all top publications</p>
              </div>
              <div class="profile__content__tables__cards__item__info__upvote table-card-upvoted">
                <img src="/assets/icons/upvoted.svg" />
                <div>2.300</div>
              </div>
            </div>
            <div class="profile__content__tables__cards__item__stats">
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
      <aside class="profile__content__aside">
        <div class="profile__content__aside__box">
          <a href="#">
            <div class="sign-box-selected">Upvoted</div>
          </a>
          <a href="#">
            <div>Subscribed</div>
          </a>
          <a href="#">
            <div>Owned</div>
          </a>
          <a href="#">
            <div>Contributed</div>
          </a>
          <a href="#">
            <div>History</div>
          </a>
        </div>
        <div class="profile__content__aside__box">
          <a href="#">
            <div>Followers</div>
          </a>
          <a href="#">
            <div>Following</div>
          </a>
        </div>
      </aside>
    </div>
  </div>
</div>
{% endblock %}
