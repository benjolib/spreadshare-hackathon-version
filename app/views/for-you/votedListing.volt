<div class="u-flex u-sm-flexCol u-md-flexRow">
    <div class="collaboration-info u-flex">
        <img class="collaboration-info__image" src="{{ listing.userImage }}" />
        <div>
            <a class="collaboration-info__user-name" href="/profile/{{ listing.userHandle }}">{{ listing.userName }}</a>
            <span class="collaboration-info__text">spreaded a listing from</span>
<a class="collaboration-info__table-name" href="/stream/{{ listing.tableSlug ? listing.tableSlug : listing.tableId }}">{{ listing.tableName }}</a>
        </div>
    </div>
    <div class="collaboration-clock"><img src="/assets/images/comment-clock.svg" />{{ date('M jS H:i ',listing.getCreatedAt().getTimeStamp()) }}</div>
</div>
<div class="table-scroll table-scroll--collaborations">
    <table class="re-table re-table--list" data-id="{{ listing.tableId }}">
        <thead>
        <tr>
            <th>
                VOTES
            </th>
            <th class="shadowcontainth"></th>
            <th>{# image #}</th>
            {% set columns = listing.columns %}
            {% for column in columns %}
                <th>{{ column.name }}</th>
            {% endfor %}
        </tr>
        </thead>
        <tbody>
        <tr>
        <tr data-id="{{ listing.id }}" class="list-row-tr">
            <td>
<a href="#" class="vote-link j_listing-vote {{ userHasVotedRow(listing.id, auth.getUserId()) ? 'vote-link--upvoted' : '' }}">
                    
<img class="vote-link__image" src="/assets/images/vote-lightning.svg" />
<img class="vote-link__image vote-link__image--green" src="/assets/images/vote-lightning-green.svg" />
                    <div>{{ listing.postNumVotes }}</div>
                </a>
            </td>
            <td class="shadowcontaintd">
                <div class="shadowcontain">
                </div>
            </td>
            <td>
                <div class="re-table__list-image" style="background: #f5f5f5 url({{ listing.postImage }}) center / cover;"></div>
            </td>
            {% for column in columns %}
                <td style="min-width: 0px;">{{ filterTableRowsContent(column.content) }}</td>
            {% endfor %}
        </tr>
        <tr class="re-table-space"></tr>
        </tbody>
    </table>
</div>