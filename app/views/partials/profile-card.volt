<div class="profile-card u-flex {{ type != 9 ? 'u-flexAlignItemsCenter' : '' }} {{ type == 3 ? 'profile-card--type3' : '' }} {{ type == 4 ? 'profile-card--type4' : '' }} {{ type == 9 ? 'profile-card--type9' : '' }} {{ type == 10 ? 'profile-card--type10' : '' }}">
  <a href="/user/{{ username }}"><img class="profile-card__avatar" src="{{ avatar }}" onerror="this.onerror=null;this.src='http://beta.spreadshare.co/assets/images/eleven.png';" /></a>
  <div>
    <a href="/user/{{ username }}"><span class="profile-card__name">{{ name }}</span></a> {% if type == 9 %}<a href="#" class="profile-card__follow reply {{ maincomment is not empty and maincomment ? 'reply-maincomment' : ' '}} {{ subcomment is not empty and subcomment ? 'reply-subcomment' : ''}}" data-handle="{{ username }}" data-id="{{ commentId is not empty ? commentId : '' }}">Reply</a>{% else %}<a href="/user/follow/{{id}}" class="profile-card__follow">Follow</a>{% endif %}
    {% if type !== 3 %}<p class="profile-card__bio">{{ truncate is not empty and truncate ? bio|truncate(type == 4 or type == 10 ? 74 : 43) : bio }}</p>{% endif %}
  </div>
</div>
