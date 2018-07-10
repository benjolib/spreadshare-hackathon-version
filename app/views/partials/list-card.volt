<div class="list-card {{ large ? 'list-card--large' : '' }} {{ half ? 'list-card--half' : '' }} {{ small is not empty and small  ? 'list-card--small' : '' }}">
<a href="/stream/{{ slug ? slug : id }}">
    <div class="list-card__image" style="background: #f5f5f5 url({{ image ? image : '' }}) center / cover;">
      {# <div class="list-card__listingCount">{{ listingCount }} LISTINGS</div> #}
    </div>
  </a>
  <div class="u-flex u-flexJustifyBetween">
<a href="/stream/{{ slug ? slug : id }}">
  <h3 class="list-card__name">{{ name }}</h3>
</a>
<a href="/stream/{{ slug ? slug : id }}" class="list-card__subscriberCount u-flex u-flexAlignItemsStart">
  <img src="/assets/images/9-0/list-card-subscriber-bird.svg" /> {{ subscriberCount }}</a>
  </div>
  <p class="list-card__description">{{ description }}{% if showCurator %}, curated by <a href="/profile/{{ curatorHandle }}">{{ curatorName }}</a>{% endif %}</p>
  {# {% if showCurator %}
    {{ partial('partials/profile-card', [
      'username': curatorHandle,
      'avatar': curatorAvatar,
      'name': curatorName,
      'bio': curatorBio,
      'type': 5
    ]) }}
  {% endif %} #}
</div>
