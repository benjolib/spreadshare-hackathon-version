<div class="list-card {{ large ? 'list-card--large' : '' }}">
  <a href="/list/{{ slug ? slug : id }}">
    <div class="list-card__image" style="background: #f5f5f5 url({{ image }}) center / cover;">
      <div class="list-card__listingCount">{{ listingCount }} LISTINGS</div>
    </div>
  </a>
  <div class="u-flex u-flexJustifyBetween">
    <a href="/list/{{ slug ? slug : id }}"><h3 class="list-card__name">{{ name }}</h3></a>
    <a href="#" class="list-card__subscriberCount u-flex u-flexAlignItemsCenter"><img src="/assets/images/mail.svg" /> {{ subscriberCount }}</a>
  </div>
  <p class="list-card__description">{{ description }}</p>
  {{ partial('partials/profile-card', [
    'username': curatorHandle,
    'avatar': curatorAvatar,
    'name': curatorName,
    'bio': curatorBio,
    'type': 5
  ]) }}
</div>
