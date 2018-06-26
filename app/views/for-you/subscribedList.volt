<div class="u-flex u-sm-flexCol u-md-flexRow">
    <div class="collaboration-info u-flex">
        <img class="collaboration-info__image"
             src="{{ newList.userImage }}"/>
        <div>
            <a class="collaboration-info__user-name" href="/profile/{{ newList.userHandle }}">{{ newList.userName }}</a>
            <span class="collaboration-info__text">subscribed to a Stream</span>
            <a class="collaboration-info__table-name" href="/list/{{ newList.tableId }}">{{ newList.tableName }}</a>
        </div>
    </div>
    <div class="collaboration-clock"><img src="/assets/images/comment-clock.svg"/>{{ date('M jS H:i ',newList.getCreatedAt().getTimeStamp()) }}</div>
</div>
<div class="for-you-table u-flex u-flexCol">
    <div class="for-you-table__image"
         style="background: #f5f5f5 url({{ newList.tableImage }}) center / cover;">
        <div class="for-you-table__listingCount">{{ newList.tableNumRows }}</div>
    </div>
    <div class="for-you-table__bottom u-flex u-flexJustifyBetween u-flexAlignItemsCenter">
        <div class="u-flex u-flexCol">
            <h3 class="for-you-table__heading">{{ newList.tableName }}</h3>
            <p class="for-you-table__tagline">{{ newList.tableTagline }}</p>
        </div>
        <div class="for-you-table__subscriberCount"><img src="/assets/images/mail.svg"/>{{ newList.tableSubscriberCount }}</div>
    </div>
</div>