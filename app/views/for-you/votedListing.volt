<div class="u-flex u-sm-flexCol u-md-flexRow u-flexJustifyBetween">
    <div class="collaboration-info u-flex">
        <img class="collaboration-info__image" src="{{ listing.userImage }}" />
        <div>
            <a class="collaboration-info__user-name" href="/profile/{{ listing.userHandle }}">{{ listing.userName }}</a>
            <span class="collaboration-info__text">spreaded a listing from</span>
            <a class="collaboration-info__table-name" href="/stream/{{ listing.tableSlug ? listing.tableSlug : listing.tableId }}">{{ listing.tableName }}</a>
        </div>
        <div class="collaboration-clock">
            <img src="/assets/images/comment-clock.svg" />{{ date('M jS H:i ',listing.getCreatedAt().getTimeStamp()) }}
        </div>
    </div>

</div>
<div class="table-scroll table-scroll--collaborations">
    <div class="shadowcontain"><!-- o --></div>
    <div class="scroll-wrapper">
        <table class="re-table re-table--list" data-id="{{ listing.tableId }}">
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
                <td style="text-align:left;width:85%;">
                    <strong>{{ listing.columns[0].content }}</strong>
                    {% set len = filterTableRowsContent(listing.columns[1].content)|striptags|length %}
                    {% if len > 160 %}
                        {% set length = 480 %}
                    {% elseif len > 80 %}
                        {% set length = 300 %}
                    {% elseif len > 40 %}
                        {% set length = 175 %}
                    {% elseif len > 20 %}
                        {% set length = 150 %}
                    {% else %}
                        {% set length = 0 %}
                    {% endif %}

                    <p style="min-width: {{ length }}px;">{{ filterTableRowsContent(listing.columns[1].content)|striptags }}</p>
                    <p>
                        {% if listing.columns[2].link is defined AND (listing.columns[2].link OR listing.columns[2].content) %}
                        <a class="re-table-link" target="_blank" href="{{ listing.columns[2].link }}">{{ truncate(listing.columns[2].content, 100) }}</a>
                        {% endif %}
                        <a class="re-table-link" style="color:#acb9c8;border:#acb9c8;" target="_blank" href="/profile/{{ listing.userHandle }}"><strong>Author:</strong> {{ listing.userName }}</a>
                    </p>
                </td>
            </tr>
            <tr class="re-table-space"></tr>
            </tbody>
        </table>
    </div>
</div>