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
      <div class="tableAbout__comments__container__content__stats__item">
        <div class="icon"></div>
        <span>{{ comment['votesCount'] }}</span>
      </div>
      {% if auth.loggedIn() %}
      <div class="tableAbout__comments__container__content__stats__item">
        <div class="icon"></div>
        <a class="reply" data-id="{{ comment['parentId'] }}" data-handle="{{ comment['creatorHandle'] }}">Reply</a>
      </div>
      <div class="tableAbout__comments__container__content__stats__item">
        <div class="icon"></div>
        <a class="reply" data-id="{{ comment['id'] }}">Report</a>
      </div>
      {% endif %}
    </div>
  </div>

</div>