<div class="profile-card u-flex u-flexAlignItemsCenter {{ type == 4 ? 'profile-card--type4' : '' }}">
  <a href="/user/{{ username }}"><img class="profile-card__avatar" src="{{ avatar }}" /></a>
  <div>
    <a href="/user/{{ username }}"><span class="profile-card__name">{{ name }}</span></a> <a href="#" class="profile-card__follow">Follow</a>
    <p class="profile-card__bio">{{ bio|truncate(type == 4 ? 74 : 43) }}</p>
  </div>
</div>
