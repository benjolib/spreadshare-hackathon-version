<div class="tableAbout__comments__container">
  <div class="tableAbout__comments__container__avatar">
    <img src="{{ comment['creatorImage'] }}" />
  </div>
  <div class="tableAbout__comments__container__content">
    <h4>{{ comment['creator'] }}</h4>
    <p>
      {{ comment['comment'] }}
    </p>
    <div class="tableAbout__comments__container__content__stats">
      <a href="javascript:;" class="comment-upvote" data-action="comment-upvote" data-id="{{ comment['id'] }}">
        <div class="tableAbout__comments__container__content__stats__item">
          <div class="tableAbout__comments__container__content__stats__item__icon tableAbout__comments__container__content__stats__item__icon--vote"></div>
          <span>{{ comment['votesCount'] }}</span>
        </div>
      </a>
      {% if auth.loggedIn() %}
        <a href="javascript:;" class="reply" data-id="{{ comment['id'] }}" data-handle="{{ comment['creatorHandle'] }}">
          <div class="tableAbout__comments__container__content__stats__item">
            <div class="tableAbout__comments__container__content__stats__item__icon tableAbout__comments__container__content__stats__item__icon--reply"></div>
            <span>Reply</span>
          </div>
        </a>
        <!--
        <a href="javascript:;">
          <div class="tableAbout__comments__container__content__stats__item">
            <div class="tableAbout__comments__container__content__stats__item__icon tableAbout__comments__container__content__stats__item__icon--report"></div>
            <span>Report</span>
          </div>
        </a>
        -->
      {% endif %}
    </div>
  </div>
</div>
