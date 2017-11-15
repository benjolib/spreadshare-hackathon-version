{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
  <div class="tables">
    <div class="tables__content">
      <div class="tables__content__wrapper" style="position:relative;">
        <div class="signup__content__form__buttons" style="position:absolute;top:-50px;right:180px;">
          <a href="/" class="button">CONTINUE</a>
        </div>
        <p class="tables__content__title">Here are some <span>tables</span> you might like</p>
        <p class="tables__content__subtitle">Tell us which tables you’re most interested in. <span>Pick at least 3</span></p>

        <div class="tables__content__main">

          <div class="tables__content__main__cards">

            {% for table in tables %}
            <div class="tables__content__main__cards__item">
              <div class="tables__content__main__cards__item__info">
                <div class="tables__content__main__cards__item__info__title">
                  <h3><a href="/table/{{ table['id'] }}" target="_new" }>{{ table['title'] }}</a></h3>
                  <p>{{ table['tagline'] }}</p>
                </div>
                <div class="tables__content__main__cards__item__info__upvote upvote {% if table['userHasVoted'] %}selected{% endif %}" data-action="upvote" data-id="{{ table['id'] }}" onclick="var event = arguments[0] || window.event; event.stopPropagation();">
                  <img src="/assets/icons/upvote.svg" />
                  <span>{{ table['votesCount'] +0 }}</span>
                </div>
              </div>
              <div class="tables__content__main__cards__item__stats">
                <div>{{ table['tags'] }}</div>
                <div>{{ table['tokensCount'] +0 }} Tokens</div>
                <div>
                  <img src="/assets/icons/eye.svg" /><span><i>{{ table['viewsCount'] +0 }}</i> Views</span>
                </div>
                <div>
                  <img src="/assets/icons/comment.svg" /><span><i>{{ table['commentsCount'] +0 }}</i> Comments</span>
                </div>
              </div>
            </div>
            {% endfor %}

          </div>
        </div>
      </div>
      <aside class="tables__content__aside">
        <div class="tables__content__aside__box">
          <a href="/signup/topics">
            <div>Topics</div>
          </a>
          <a href="/signup/follow">
            <div>People</div>
          </a>
          <a href="/signup/location">
            <div>Regions</div>
          </a>
          <a href="/signup/tables">
            <div class="sign-box-selected">Tables</div>
          </a>
        </div>
      </aside>
    </div>
  </div>
{% endblock %}

{% block scripts %}
<script type="text/javascript">
  $(document).ready(function () {
    $('.tables__content__main__cards__item').on('click', '.tables__content__main__cards__item__info__upvote', function (ev) {
      ev.stopPropagation();
      var target = $(ev.currentTarget);
      var id = target.attr('data-id');

    });
  });
</script>
{% endblock %}
