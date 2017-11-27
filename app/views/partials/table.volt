<div class="tables__content__main__cards__item">
  <div class="tables__content__main__cards__item__info">
    <div class="tables__content__main__cards__item__info__title">
      <h3><a href="/table/{{ table['id'] }}" }>{{ table['title'] }}</a></h3>
      <p>{{ table['tagline'] }}</p>
    </div>
    {% if table['ownerUserId'] != auth().getUserId() %}
    <div class="tables__content__main__cards__item__info__upvote upvote {% if table['userHasVoted'] %}selected{% endif %}" data-action="upvote" data-id="{{ table['id'] }}" onclick="var event = arguments[0] || window.event; event.stopPropagation();">
      <img src="/assets/icons/upvote.svg" />
      <span>{{ table['votesCount'] +0 }}</span>
    </div>
    {% endif %}
  </div>
  <div class="tables__content__main__cards__item__stats">
    {% if table['typeTitle'] %}
    <div>{{ table['typeTitle'] }}</div>
    {% endif %}
    {# {% if table['tags'] %}<span>{{ table['tags'] }}</span>{% endif %} #}
    <div>{{ table['tokensCount'] +0 }} Tokens</div>
    <div>
      <img src="/assets/icons/eye.svg" /><span><i>{{ table['viewsCount'] +0 }}</i> Views</span>
    </div>
    <a href="/table/{{ table['id'] }}/about">
      <img src="/assets/icons/comment.svg" /><span><i>{{ table['commentsCount'] +0 }}</i> Comments</span>
    </a>
  </div>
</div>