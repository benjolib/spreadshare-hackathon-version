{% extends 'layouts/main.volt' %} 


{% block title %}{{ table['title'] }}{% endblock %}

{% block header %}
<meta property="og:title" content="{{ table['title'] }} " /> {# TODO: It's not taking block title the second time #}
<meta property="og:type" content="website" />
<meta property="og:description" content="{{ table['tagline'] }}" />
<meta property="og:url" content="http://{{ config.domain }}/stream/{{ table['slug'] }}" />
<meta property="og:image" content="{% if table['image'] %} table['image'] {% else %} http://{{ config.domain }}/assets/images/logo_big.png {% endif %}" />

{% endblock %}

{% block content %}

<div class="re-page re-page--list">
  <div class="list-page-space">
    <div class="re-image" style="background: #f5f5f5 url({{ table['image'] ? table['image'] : '' }}) center / cover;">
      <div class="re-image__upload-button"></div>
      <div class="re-image__delete-button"></div>
    </div>
    <input type="file" name="image" id="re-image-fileUpload" style="display: none;" /> {#
    <div class="re-pre-heading-info">
      <div>{{ table['topic1'] }}</div>
      <div class="re-green">{{ table['subscriberCount'] }} SUBSCRIBERS</div>
      <div class="re-lighten">{{ date("d.m.Y", table['createdAt']) }}</div>
    </div> #}
    <h1 class="re-heading re-heading--list">{{ table['title'] }}</h1>
    <h2 class="re-subheading re-subheading--list">
      <span class="actual-tagline parselinks">{{ table['tagline'] }}</span>, curated by
      <a href="/profile/{{ table['creatorHandle'] }}">{{ table['creator'] }}</a>
    </h2>
    <p class="re-para parselinks">{{ table['description'] }}</p>
    <div class="u-flex u-flexAlignItemsCenter">
      {% if !amISubscribed(table['id']) %}

      <div class="list-actions u-sm-flexCol u-md-flexRow">
        <div class="button-container button-container__orange l-button" data-dropdown-placement="center" data-dropdown-offset="0">

          <a class="re-button re-button--list-subscribe" href="javascript:;" onclick="subsFreqOnClick({{ table['id'] }}, 'W')">
            <img src="/assets/images/9-0/bird-orange.svg" /> Subscribe
          </a>



          <div class="info">
            Keep track of new content that gets added
          </div>

        </div>
        <div class="sh-dropdown card-subscribe-dropdown card-actions-dropdown--tall u-flex u-flexCol l-dropdown"
          style="padding-left: -100px;display:none;visibility: hidden">
          <a href="javascript:;" onclick="subsFreqOnClick({{ table['id'] }}, 'D')">Daily</a>
          <a href="javascript:;" onclick="subsFreqOnClick({{ table['id'] }}, 'W')">Weekly</a>
          <a href="javascript:;" onclick="subsFreqOnClick({{ table['id'] }}, 'M')">Monthly</a>
        </div>

        <div class="button-container button-container__blue">
          <div class="but">
            <a class="re-button re-button--list-collaborate addAListingButton0" id="addAListingButton0" href="#">
              <img src="/assets/images/9-0/octopus-blue.svg" /> Collaborate

            </a>


          </div>
          <div class="info">
            Reach the subscribers by suggesting new content
          </div>
        </div>
      </div>
      {% else %}


      <div class="list-actions u-sm-flexCol u-md-flexRow u-sm-flexAlignItemsCenter">
        <div class="button-container button-container__white" data-dropdown-placement="center" data-dropdown-offset="0">

          <a class="re-button re-button--list-subscribe" href="javascript:;">
            <img src="/assets/images/9-0/bird-orange.svg" /> Subscribed
          </a>



          <div class="info">
            Manage your subscriptions
            <u>
              <b>
                <a href="/subscriptions">here</a>
            </u>
            </b>
          </div>

        </div>
        <div class="sh-dropdown card-subscribe-dropdown card-actions-dropdown--tall u-flex u-flexCol l-dropdown"
          style="padding-left: -100px;display:none;visibility: hidden">
          <a href="javascript:;" onclick="subsFreqOnClick({{ table['id'] }}, 'D')">Daily</a>
          <a href="javascript:;" onclick="subsFreqOnClick({{ table['id'] }}, 'W')">Weekly</a>
          <a href="javascript:;" onclick="subsFreqOnClick({{ table['id'] }}, 'M')">Monthly</a>
        </div>

        <div class="button-container button-container__blue">
          <div class="but">
            <a class="re-button re-button--list-collaborate addAListingButton0" id="addAListingButton0" href=" # ">
              <img src="/assets/images/9-0/octopus-blue.svg" /> Collaborate

            </a>


          </div>
          <div class="info">
            Reach the subscribers by suggesting new content
          </div>
        </div>
      </div>




      {% endif %}



    </div>
    {#
    <a class="re-button list-edit-button" href="#" style="margin-left:8px">
      Edit
    </a> #}
  </div>

  <div class="table-list-container">
  <div class="table-scroll absolute-containers">
    <table class="re-table re-table--list" data-id="{{ table['id'] }}">
      <thead>
        <tr>
          <th>
            <div class="l-button">VOTES
              <img src="/assets/images/updown.svg" class="updown" />
            </div>
            <div class="sh-dropdown sort-dropdown u-flex u-flexCol u-flexJustifyCenter l-dropdown">


                {%if (orderby) ==="date"%}
                <a href="?orderby=date" class="sort-selected">
                  <img src="/assets/images/clock-green.svg" />
                  {%else%}
                  <a href="?orderby=date">
                      <img src="/assets/images/clock.svg" />
                  {%endif%}
                  Sort by
                  <span>Newest</span>
                </a>

                  {%if (orderby) ==="popularity"%}
                  <a href="?orderby=popularity" class="sort-selected">
                  <img src="/assets/images/vote-lightning-green.svg" />
                  {%else%}
                  <a href="?orderby=popularity" >
                  <img src="/assets/images/vote-lightning.svg" />
                  {%endif%}
                Sort by
                <span>Popularity</span>
                </a>




            </div>
          </th>
          <th class="shadowcontainth"></th>
          <th>{# image #}</th>
          {% for column in tableColumns %}

          <th>{{ column.title }}</th>
          {% endfor %}
        </tr>
      </thead>
      <tbody>
        {% if tableContent is not empty and tableContent %} {% for index, row in tableContent.items %}

        <tr data-id="{{ row['id'] }}" class="list-row-tr">
          <td>
            <a href="#" class="j_listing-vote vote-link {{ row['userHasVoted'] ? 'vote-link--upvoted' : '' }}">
              <img class="vote-link__image" src="/assets/images/vote-lightning.svg" />
              <img class="vote-link__image vote-link__image--green" src="/assets/images/vote-lightning-green.svg" />
              <div>{{ row['votesCount'] }}</div>
            </a>
          </td>
          <td class="shadowcontaintd">
          <div class="shadowcontain dropright">
              <div class="l-button" style="position: absolute;top: 0px;right: 6px;pointer-events: all;cursor: pointer;" data-dropdown-placement="top-start" data-dropdown-offset="0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <img src="/assets/images/9-0/listing-info.svg" />
              </div>
          <div class="sh-dropdown list-row-remove-dropdown u-flex u-flexCol  l-dropdown addedby " >





                <div class="u-flex u-flexCol header">
                  {% if row['userId'] == null %}

                  ADDED BY
                  <div class="u-flex u-flexCol content">

                    <div class="content">
                      <img src="{{ table['creatorImage'] }}" /> {{ table['creatorHandle'] }}
                    </div>
                  </div>

                  {% else %}
                  ADDED BY
                <div class="u-flex u-sm-flexCol u-md-flexRow u-md-flexAlignItemsCenter content">
                    {% if row['userId'] == table['ownerUserId'] %}
                    <img src="{{ table['creatorImage'] }}" /> {% else %}
                    <img src="/userimages/{{row['userId']}}.jpg" /> {% endif %}

                    <a href="/profile/{{userHandleFromId(row['userId'])}}">{{ userHandleFromId(row[ 'userId']) }}</a>
                </div>
                  {% endif %}
                </div>

                <div class="u-flex u-flexCol header" style="margin-top:15px">
                  DATE
                  <div class="u-flex content date">
                    {{ date('M jS H:i ',row['createdAt']) }}
                  </div>




                  </div>

                <a href="/row/{{ row['id']}}/delete" class="action-button">Request to remove</a>
          </div>

          </div>
          </td>

          <td>

            <div class="l-button re-table__list-image {{ row['image'] ? '' : 're-table__list-image--empty' }}" style="background: #f5f5f5 url({{ row['image'] }}) center / cover;">
              <img data-name="{{ row['content']|json_decode[0].content }}" class="{{ row['image'] ? '' : 'empty' }}" />
              <div class="re-table__list-image__upload-button"></div>
              <!--<div class="re-table__list-image__delete-button"></div>-->
            </div>
            <div class="addedby sh-dropdown  u-flex  u-flexJustifyBetween l-dropdown">
              <div class="u-flex u-flexCol header">
                {% if row['userId'] == null %} ADDED BY
                <div class="u-flex creator">

                  <div class="content">
                    <img src="{{ table['creatorImage'] }}" /> {{ table['creatorHandle'] }}
                  </div>
                </div>

                {% else %} ADDED BY
                <div class="content">
                  {% if row['userId'] == table['ownerUserId'] %}
                  <img src="{{ table['creatorImage'] }}" /> {% else %}
                  <img src="/userimages/{{row['userId']}}.jpg" /> {% endif %}

                  <a href="/profile/{{userHandleFromId(row['userId'])}}">{{ userHandleFromId(row[ 'userId']) }}</a>
                </div>
                {% endif %}
              </div>

              <div class="u-flex u-flexCol header" style="margin-left:10px;">
                DATE
                <div class="u-flex content date" style="margin-right:10px;">
                  {{ date('M jS H:i ',row['createdAt']) }}</div>
              </div>
              <input type="file" name="image" class="re-table__list-image-fileUpload" style="display: none;" />
              <a href="#" class="action-button">Request to remove</a>
          </td>


          {% for i,cell in row['content']|json_decode %} {% set len = filterTableRowsContent(cell.content)|striptags|length %} {% if
          len > 160 %} {% set length = 480 %} {% elseif len > 80 %} {% set length = 300 %} {% elseif len > 40 %} {% set length
          = 175 %} {% elseif len > 20 %} {% set length = 150 %} {% else %} {% set length = 0 %} {% endif %}

          <td style="min-width: {{ length }}px;">
            {{ filterTableRowsContent(cell.content) }}

          </td>
          {% endfor %}
        </tr>
        <tr class="re-table-space"></tr>
        {% endfor %} {% else %}
        <tr>
          <td>No listings yet</td>
        </tr>
        {% endif %}
        <tr class="list-row-tr">
          <td class="pagination-td">
            <div class="pagination">
              <a href="?page=1&orderby={{orderby}}">
                <<</a>
                  <a href="?page={{ tableContent.before }}&orderby={{orderby}}">
                    <</a>
                      {% if tableContent.current + 5
                      < tableContent.total_pages %} {% set endPage=tableContent.current + 5 %} {% else %} {% set endPage=tableContent.total_pages
                        %} {% endif %} {% if tableContent.current - 5> 1 %} {% set startPage=tableContent.current - 5 %} {% else %} {% set startPage=1 %} {% endif %} {% for
                        p in startPage..endPage %} {% if p === tableContent.current %}
                        <a class="active" style="color:red" href="?page={{ p }}&orderby={{orderby}}">{{ p }}</a>
                        {% else %}
                        <a href="?page={{ p }}&orderby={{orderby}}">{{ p }}</a>
                        {% endif %} {% endfor %}
                        <a href="?page={{ tableContent.next }}&orderby={{orderby}}">></a>
                        <a href="?page={{ tableContent.last }}&orderby={{orderby}}">>></a>
            </div>
          </td>
        </tr>

        <tr class="re-table-space"></tr>
        <tr class="re-table-space"></tr>
      </tbody>
    </table>
    <table class="re-table re-table--list addAListingRow"  style="margin-left:21px;width:100%;">
      <tr id="addAListingRowSpace" class="re-table-space" style="display: none;"></tr>
      <tr id="addAListingRow" class="list-row-tr list-row-tr--add-row" style="display: none;">
        <td>

        </td>
        <td class="shadowcontaintd">
          <div class="shadowcontain"></div>
        </td>
        <td>
          <div class="re-table__list-image__upload-button"></div>
          <div class="re-table__list-image re-table__list-image--new-row" id="addRowImage"></div>

          <!-- <div class="re-table__list-image re-table__list-image--editing" style="background: #f5f5f5 center / cover;">

            <div class="re-table__list-image__upload-button"></div>

            <div class="re-table__list-image__upload-button"></div>
              <div class="re-table__list-image__delete-button"></div>
            </div> -->


          <input type="file" name="image" id="new-row-fileUpload" style="display: none;" />

        </td>
        {% for index,column in tableColumns %}
        <td>
          <div style="display:flex;">

            <textarea style="min-width: {{ column.title|length*16 }}px !important;" onmouseover="javascript:$('.e{{i}}{{index}}').css('visibility','visible');" ; onmouseout="javascript:$('.e{{i}}{{index}}').css('visibility', 'hidden');"
              id="{{i}}" placeholder="{{ column.title|ucfirst }}" rows="1" class="edit icon cell-input-sizing d{{i}}{{index}}"></textarea>
            <i id="{{i}}" class="pencil icon blue e{{i}}{{index}}" style="margin-top:38px;cursor: pointer;visibility: hidden;" onclick="console.log($(this).prev().prev());javascript:$('#d{{i}}{{index}}').focus();"></i>
          </div>
        </td>

        {% endfor %}
      </tr>
      <tr class="re-table-space"></tr>
        <tr class="re-table-space"></tr>
    </table>
    </div>



    <div class="addAListingSubmitAndCancel" id="addAListingSubmitAndCancel" style="display: none;">
      <a class="re-button re-button--list-add-row" href="#" id="addAListingSubmit">
        <img src="/assets/images/9-0/list-collaborate-button-octopus.svg" />Submit</a>
      <a style="width:140px" class="re-button re-button--list-add-row-cancel re-button--grey small-cancel-button" href="#" id="addAListingCancel">Cancel</a>
    </div>




    {% if !amISubscribed(table['id']) %}

  <div class="list-actions bottom u-sm-flexCol u-md-flexRow u-md-flexRow">
    <div class="button-container button-container__orange l-button" data-dropdown-placement="center" data-dropdown-offset="0">

        <a class="re-button re-button--list-subscribe" href="javascript:;" onclick="subsFreqOnClick({{ table['id'] }}, 'W')">
          <img src="/assets/images/9-0/bird-orange.svg" /> Subscribe
        </a>



        <div class="info">
          Keep track of new content that gets added
        </div>

      </div>
      <div class="sh-dropdown card-subscribe-dropdown card-actions-dropdown--tall u-flex u-flexCol l-dropdown"
        style="padding-left: -100px;display:none;visibility: hidden">
        <a href="javascript:;" onclick="subsFreqOnClick({{ table['id'] }}, 'D')">Daily</a>
        <a href="javascript:;" onclick="subsFreqOnClick({{ table['id'] }}, 'W')">Weekly</a>
        <a href="javascript:;" onclick="subsFreqOnClick({{ table['id'] }}, 'M')">Monthly</a>
      </div>

      <div class="button-container button-container__blue">
        <div class="but">
          <a class="re-button re-button--list-collaborate addAListingButton1" href=" # ">
            <img src="/assets/images/9-0/octopus-blue.svg" /> Collaborate

          </a>


        </div>
        <div class="info">
          Reach the subscribers by suggesting new content
        </div>
      </div>
    </div>
    {% else %}


  <div class="list-actions bottom u-sm-flexCol u-md-flexRow u-sm-flexAlignItemsCenter">
    <div class="button-container button-container__white" data-dropdown-placement="center" data-dropdown-offset="0">

        <a class="re-button re-button--list-subscribe" href="javascript:;">
          <img src="/assets/images/9-0/bird-orange.svg" /> Subscribed
        </a>



        <div class="info">
          Manage your subscriptions
          <u>
            <b>
              <a href="/subscriptions">here</a>
          </u>
          </b>
        </div>

      </div>
      <div class="sh-dropdown card-subscribe-dropdown card-actions-dropdown--tall u-flex u-flexCol l-dropdown"
        style="padding-left: -100px;display:none;visibility: hidden">
        <a href="javascript:;" onclick="subsFreqOnClick({{ table['id'] }}, 'D')">Daily</a>
        <a href="javascript:;" onclick="subsFreqOnClick({{ table['id'] }}, 'W')">Weekly</a>
        <a href="javascript:;" onclick="subsFreqOnClick({{ table['id'] }}, 'M')">Monthly</a>
      </div>

      <div class="button-container button-container__blue">
        <div class="but">
          <a class="re-button re-button--list-collaborate addAListingButton1" id="addAListingButton1" href="#">
            <img src="/assets/images/9-0/octopus-blue.svg" /> Collaborate

          </a>


        </div>
        <div class="info">
          Reach the subscribers by suggesting new content
        </div>
      </div>
    </div>




    {% endif %} {#
    <a id="addAListingButton" class="re-button re-button--list-collaborate" href="#">
      Collaborate
    </a> #}
    <div class="related-lists-new-heading" style="{{ related|length === 0 ? 'display:none;' : '' }}">
      You might also like
    </div>
    <div class="related-lists-new med-gutter">
      {{ partial('list/related-lists') }}
    </div>
    </div>
  </div>
    <input type="text" id="related-lists-edit" class="related-lists-edit" value="" style="display:none;" /> {#
    <div class="list-page-section-label">
      RELATED STREAMS
    </div>
    <div class="related-lists u-flex u-flexJustifyCenter">
      <div class="related-lists__inner u-flex u-flexWrap">
        {% for relatedTable in related %}
        <div class="related-lists__item">
          <a href="/stream/{{ relatedTable['id'] }}">
            <div class="related-lists__item__name">{{ relatedTable['title'] }}{% if relatedTable['staffPick'] %}
              <div class="related-lists__item__staff-pick">STAFF PICK 👏</div>{% endif %}</div>
          </a>
          <div class="related-lists__item__descr">{{ relatedTable['tagline']|truncate(42) }}</div>
        </div>
        {% endfor %}
      </div>
    </div> #}

    <div class="list-tabs">
      <div class="list-tab-buttons">
        <div class="list-tabs__inner">
          <a href="#" class="list-tab-button list-tab-button-about active">About</a>
          <a href="#" class="list-tab-button list-tab-button-discussion">Discussion</a>
          <a href="#" class="list-tab-button list-tab-button-subscribers">Subscribers</a>
          <a href="#" class="list-tab-button list-tab-button-collaborators">Collaborators</a>
          <a href="#" class="list-tab-button list-tab-button-activity">History</a>
        </div>
      </div>

      <div class="list-tab-content list-tab-content-about">
        <div class="list-tabs__inner-padded">
          <div class="about-list__item">
            <div class="about-list__item__name">CURATOR</div>
            <div class="about-list__item__content">
              <div id="curators">
                {{ partial('partials/profile-card', [ 'username': table['creatorHandle'], 'avatar': table['creatorImage'], 'name': table['creator'],
                'id': table['ownerUserId'], 'bio': table['creatorBio'] , 'type': 11 ]) }}

              </div>
              <input type="text" id="curators-edit" class="curators-edit" value="{{ table['creatorHandle'] }}" style="display:none;" />
            </div>
          </div>
          <div class="about-list__item">
            <div class="about-list__item__name">TAGS</div>
            <div class="about-list__item__content">
              <div class="tags" id="tags">
                {% for i, tag in tags %}
                 <a style="color:#2a1e3e" href="/tag/{{tag['id']}}">{{tag['title']}}</a>
                {{ i + 1
                < tags|length ? ', ' : '' }} {% endfor %} </div>
              </div>
            </div>
            <div class="about-list__item">
              <div class="about-list__item__name">STATS</div>
              <div class="about-list__item__content">
                <div class="about-list__part">
                  <b>{{ table['subscriberCount'] }}</b> Subscriptions </div>
                <div class="about-list__part">
                  <b>{{ table['contributionCount'] }}</b> Collaborations </div>
                <div class="about-list__part">
                  <b>{{ table['commentsCount'] }}</b> Comments</div>
              </div>
            </div>
          </div>
        </div>

        <div class="list-tab-content list-tab-content-discussion j_table-discussion" id="comment" style="display: none;">
          <div class="list-tabs__inner-padded">
            {% if auth.loggedIn() %}
            <div>
              <button class="re-button re-button--full-width re-button--tall re-button--list-discussion" style="display:none;">Write a Response</button>
              <form method="POST" action="/stream/{{ table['id'] }}">
                <input type="hidden" name="parentId" value="" />
                <div class="discussion-textarea">
                  <textarea id="textareac" name="comment" placeholder=" Write a response"></textarea>
                  <button>Send</button>
                </div>
              </form>
            </div>
            {% endif %} {% if tableComments %} {% for comment in tableComments %}
            <div class="u-flex comment">
              <a href="#" class="j_comment-vote vote-link vote-link--discussion" data-id="{{ comment['id'] }}">
                <img class="vote-link__image" src="/assets/images/vote-lightning.svg" />
                <img class="vote-link__image vote-link__image--green" src="/assets/images/vote-lightning-green.svg" />
                <div>{{ comment['votesCount'] }}</div>
              </a>
              {{ partial('partials/profile-card', [ 'username': comment['creatorHandle'], 'avatar': comment['creatorImage'], 'name': comment['creator'],
              'bio': comment['comment'], 'type': 9, 'truncate': false, 'maincomment': true, 'subcomment': false, 'commentId':
              comment['id'] ]) }}
              <div class="comment-clock">
                <img src="/assets/images/comment-clock.svg" />{{ formatTimestamp(comment['createdAt']) }}</div>
            </div>
            {% for childComment in comment['childs'] %}
            <div class="u-flex comment" style="margin-left:71px;">
              <a href="#" class="j_comment-vote vote-link vote-link--discussion" data-id="{{ childComment['id'] }}">
                <img class="vote-link__image" src="/assets/images/vote-lightning.svg" />
                <img class="vote-link__image vote-link__image--green" src="/assets/images/vote-lightning-green.svg" />
                <div>{{ childComment['votesCount'] }}</div>
              </a>
              {{ partial('partials/profile-card', [ 'username': childComment['creatorHandle'], 'avatar': childComment['creatorImage'],
              'name': childComment['creator'], 'bio': childComment['comment'], 'type': 9, 'truncate': false, 'maincomment':
              false, 'subcomment': true, 'commentId': comment['id'] ]) }}
              <div class="comment-clock">
                <img src="/assets/images/comment-clock.svg" />{{ formatTimestamp(childComment['createdAt']) }}</div>
            </div>
            {% endfor %} {% if auth.loggedIn() %}
            <form method="POST" action="/stream/{{ table['id'] }}" style="display:none;margin-left:80px;margin-top:8px;">
              <input type="hidden" name="parentId" class="commentParentId" value="" />
              <div class="discussion-textarea">
                <textarea name="comment" class="commentTextArea" placeholder="Write a comment"></textarea>
                <button>Send</button>
              </div>
            </form>
            {% endif %} {% endfor %} {% else %}
            <div class="empty-discussion">
              <div class="nocomments">
                <div class="image">
                  <img src="/assets/images/9-0/cat.png" />
                </div>
                <div class="info">
                  <div class="header">Nothing here yer. Pioneers wanted!</div>
                  <div class="subheader">The person who follows the crowd will usually go no further than the crowd. The person who walks alone
                    is likely to find himself in places no one has ever seen before (A. Einstein)
                  </div>
                </div>
              </div>
            </div>
            {% endif %}
          </div>
        </div>

        <div class="list-tab-content list-tab-content-subscribers" style="display: none;">
          <div class="list-tabs__inner-padded">
            <div class="list-tab-subscriber-collaborator-wrap">
              {% for subscriber in tablemodel.tableSubscription %}
              <div class="list-tab-content-subscribers__card">
                {{ partial('partials/profile-card', [ 'id': subscriber.user.id, 'username': subscriber.user.handle, 'avatar': subscriber.user.image,
                'name': subscriber.user.name, 'bio': subscriber.user.tagline, 'type': 10]) }}
              </div>
              {% else %}
              <div class="empty-discussion">
                <div class="nocomments">
                  <div class="image">
                    <img src="/assets/images/9-0/cat.png" />
                  </div>
                  <div class="info">
                    <div class="header">Nothing here yer. Pioneers wanted!</div>
                    <div class="subheader">The person who follows the crowd will usually go no further than the crowd. The person who walks alone
                      is likely to find himself in places no one has ever seen before (A. Einstein)
                    </div>
                  </div>
                </div>
              </div>
              {% endfor %}
            </div>
          </div>
        </div>

        <div class="list-tab-content list-tab-content-collaborators" style="display: none;">
          <div class="list-tabs__inner-padded">
            {% for contributor in tablemodel.contributors %}

            <div class="list-tab-content-collaborators__card">
              {{ partial('partials/profile-card', [ 'id': contributor.users.id, 'username': contributor.users.handle, 'avatar': contributor.users.image,
              'name': contributor.users.name, 'bio': contributor.users.tagline, 'type': 10, 'truncate': true ]) }}
            </div>
            {% else %}
            <div class="empty-discussion">
              <div class="nocomments">
                <div class="image">
                  <img src="/assets/images/9-0/cat.png" />
                </div>
                <div class="info">
                  <div class="header">Nothing here yer. Pioneers wanted!</div>
                  <div class="subheader">The person who follows the crowd will usually go no further than the crowd. The person who walks alone
                    is likely to find himself in places no one has ever seen before (A. Einstein)
                  </div>
                </div>
              </div>
            </div>
            {% endfor %}
          </div>
        </div>

        <div class="list-tab-content list-tab-content-activity" style="display: none;">
          <div class="list-tabs__inner-padded">
            <div class="empty-discussion">
              <div class="nocomments">
                <div class="image">
                  <img src="/assets/images/9-0/cat.png" />
                </div>
                <div class="info">
                  <div class="header">Nothing here yer. Pioneers wanted!</div>
                  <div class="subheader">The person who follows the crowd will usually go no further than the crowd. The person who walks alone
                    is likely to find himself in places no one has ever seen before (A. Einstein)
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- <div id="list-context-menu" class="list-context-menu">
    <a href="javascript:;" class="edit-column-name">
      <img src="/assets/images/9-0/list-edit-column-name.svg" /> Edit Column Name</a>
    <a href="javascript:;" class="add-column-left">
      <img src="/assets/images/9-0/list-add-column-left.svg" /> Add Column Left</a>
    <a href="javascript:;" class="add-column-right">
      <img src="/assets/images/9-0/list-add-column-right.svg" /> Add Column Right</a>
    <a href="javascript:;" class="remove-column">
      <img src="/assets/images/9-0/list-remove-column.svg" /> Remove Column</a>
  </div> -->

      <form method="POST" action="/row/{{ table['id']}}/add" enctype="multipart/form-data" id="form_hidden">

      </form>

      <form method="POST" action="/stream/{{ table['id']}}/edit" enctype='multipart/form-data' id="edit-list-form">
        <input type="hidden" id="list-image" name="list-image" value="" />
        <input type="hidden" id="list-name" name="list-name" value="" />
        <input type="hidden" id="list-tagline" name="list-tagline" value="" />
        <input type="hidden" id="list-description" name="list-description" value="" />
        <input type="hidden" id="list-columns" name="list-columns" value="" />
        <input type="hidden" id="list-rows" name="list-rows" value="" />
        <input type="hidden" id="list-tags" name="list-tags" value="" />
        <input type="hidden" id="list-related" name="list-related" value="" />
        <input type="hidden" id="list-curators" name="list-curators" value="" />
      </form>

      <form id="subscriptions_form" method="post" action="/subscriptions">
        <input type="hidden" name="table_id" value="" />
        <input type="hidden" name="subscription_freq" value="" />
      </form>
      {% endblock %} {% block scripts %}
      <script type="text/javascript">
        function subsFreqOnClick(id, freq) {
          $('[name="table_id"]').val(id);
          $('[name="subscription_freq"]').val(freq);
          $('#subscriptions_form').submit();
        }
        var x, y, top, left, down, moving;
        var $tableScrolls = $(".table-scroll .re-table--list:not('.addAListingRow')")

        $tableScrolls.on('mousedown touchstart', function (e) {
          if(e.target.className == "table-cell-show-more-button l-button"){
            console.log("yes")
            $('.table-cell-show-more-button').click();
            return
          }
           // console.log("Target", e)
          //e.preventDefault();
          $(e.target).closest(".table-scroll").addClass("moving");
          moving = $(e.target).closest(".table-scroll");
          down = true;
          x = e.pageX;
          y = e.pageY;
          top = $(this).scrollTop();
          left = $(this).scrollLeft();
        });

        $tableScrolls.on('mousemove touchmove', function (e) {
          if (down) {

            var newX = e.pageX;
            var newY = e.pageY;

            $(".moving").scrollTop(top - newY + y);
            $(".moving").scrollLeft(left - newX + x);
          }
        });

        $tableScrolls.on('mouseup touchend', function (e) {
            down = false;
            $(moving).removeClass("moving");
        });


        $(document).ready(function () {

            $('.parselinks').each(function(){
              // Get the content
              var str = $(this).html();
              // Set the regex string
              var regex = /(https?:\/\/[^\s]+)/g
              // Replace plain text links by hyperlinks
              var replaced_text = str.replace(regex, "<a href='$1' target='_blank'>$1</a>");
              // Echo link
              $(this).html(replaced_text);
          });

          // var mouse = {
          //   pageX: 0,
          //   pageY: 0
          // };
          // var ref = {
          //   getBoundingClientRect: () => ({
          //     top: mouse.pageY,
          //     right: mouse.pageX,
          //     bottom: mouse.pageY,
          //     left: mouse.pageX,
          //     width: 0,
          //     height: 0,
          //   }),
          //   clientWidth: 0,
          //   clientHeight: 0,
          // }

          // var pop = $('.list-context-menu');

          // var popInstance;
          // new Popper(ref, pop, {
          //   placement: 'right-start',
          //   onCreate({
          //     instance
          //   }) {
          //     popInstance = instance;
          //   }
          // });

          $('#textareac').keyup(function (e) {
            console.log("keyup")
            e.target.style.height = "73px";
            e.target.style.height = (e.target.scrollHeight) + "px";
          })

          $('.commentTextArea').keyup(function (e) {
            console.log("keyup")
            e.target.style.height = "73px";
            e.target.style.height = (e.target.scrollHeight) + "px";
          })

          $('.empty ').initial({
            height: 82,
            width: 82
          });
          $('.empty ').css('border-radius', "6px")

          function listCellInputSizing() {
            var $this = $(this);
            $this.height(5);
            var len = $this.val().length;

            var prevHeight = prevHeight ? prevHeight : $this.height;
            var prevWidth = prevWidth ? prevWidth : $this.width;

            var minWidth = 0;
            if (len > 0) {
              height = 39
              minWidth = 480;
              $this.attr('style', 'margin-top: 14px !important;');
              $this.next().attr('style', 'margin-top: 14px !important;');

            } else {
              $this.attr('style', 'margin-top: 37px !important;');
              $this.next().attr('style', 'margin-top: 38px !important;');
            }
            $this.height(height);


            $this.parents('td').attr('style', 'min-width:' + minWidth + 'px !important;');
          }

          $('.cell-input-sizing').on('input', listCellInputSizing);

          function listCellEditableSizing() {
            var $this = $(this);

            var len = $this.text().length;
            var minWidth = 0;
            if (len > 160) {
              minWidth = 480;
            } else if (len > 80) {
              minWidth = 300;
            } else if (len > 40) {
              minWidth = 175;
            } else if (len <= 20) {
              minWidth = 100;
            }

            $this.parents('td').attr('style', 'min-width:' + minWidth + 'px;');
          }

          function bindListCellEditableSizing() {
            console.log('blon');
            $('.re-table tr.list-row-tr:not(.list-row-tr--add-row) td:nth-of-type(1n+4) div').on('input',
              listCellEditableSizing);
          }

          function unbindListCellEditableSizing() {
            console.log('bloff');
            $('.re-table tr.list-row-tr:not(.list-row-tr--add-row) td:nth-of-type(1n+4) div').off('input',
              listCellEditableSizing);
          }
          // binds

          $('.list-tab-button-about').on('click', function (e) {
            e.preventDefault();
            $('.list-tab-button').removeClass('active');
            $('.list-tab-button-about').addClass('active');
            $('.list-tab-content').hide();
            $('.list-tab-content-about').show();
          });

          if (window.location.href.indexOf("#discussion") !== -1) {
            $('.list-tab-button').removeClass('active');
            $("html, body").animate({
              scrollTop: $(document).height()
            }, "slow");
            $('.list-tab-button-discussion').addClass('active');
            $('.list-tab-content').hide();
            $('.list-tab-content-discussion').show();
          }
          $('.list-tab-button-discussion').on('click', function (e) {
            e.preventDefault();
            $('.list-tab-button').removeClass('active');
            $('.list-tab-button-discussion').addClass('active');
            $('.list-tab-content').hide();
            $('.list-tab-content-discussion').show();
          });

          $('.list-tab-button-activity').on('click', function (e) {
            e.preventDefault();
            $('.list-tab-button').removeClass('active');
            $('.list-tab-button-activity').addClass('active');
            $('.list-tab-content').hide();
            $('.list-tab-content-activity').show();
          });

          $('.list-tab-button-subscribers').on('click', function (e) {
            e.preventDefault();
            $('.list-tab-button').removeClass('active');
            $('.list-tab-button-subscribers').addClass('active');
            $('.list-tab-content').hide();
            $('.list-tab-content-subscribers').show();
          });

          $('.list-tab-button-collaborators').on('click', function (e) {
            e.preventDefault();
            $('.list-tab-button').removeClass('active');
            $('.list-tab-button-collaborators').addClass('active');
            $('.list-tab-content').hide();
            $('.list-tab-content-collaborators').show();
          });

          var domUpdateVote = function ($el, vote) {
            var $votesCounter = $el.find('div');
            var votes = Number($votesCounter.text());
            if (vote) {
              $votesCounter.text(votes + 1);
            } else {
              $votesCounter.text(votes - 1);
            }

            if (vote) {
              $el.addClass('vote-link--upvoted');
            } else {
              $el.removeClass('vote-link--upvoted');
            }
          };

          $('.j_listing-vote').on('click', function (e) {
            e.preventDefault();
            var $this = $(this);


            domUpdateVote($this, !$this.hasClass('vote-link--upvoted'));

            // ajax
            var tableId = $this.parents('table').data('id');
            var rowId = $this.parents('tr').data('id');

            $.ajax({
              type: "POST",
              url: '/api/v1/vote-row/' + tableId,
              data: JSON.stringify({
                rowId: rowId
              }),
              success: function (res) {

              },
              contentType: "application/json; charset=utf-8",
              dataType: 'json'
            });
          });

          $('.j_comment-vote').on('click', function (e) {
            e.preventDefault();
            var $this = $(this);

            domUpdateVote($this, !$this.hasClass('vote-link--upvoted'));

            $.ajax({
              type: "POST",
              url: '/api/v1/vote-comment/' + $this.data('id'),
              success: function (res) {

              },
              contentType: "application/json; charset=utf-8",
              dataType: 'json'
            });
          });

          // submit table row

          document.querySelector('#new-row-fileUpload').addEventListener('change', function () {
            if (this.files && this.files[0]) {
              var img = document.querySelector('#addRowImage');
              img.style = 'background: #f5f5f5 url(' + URL.createObjectURL(this.files[0]) + ') center / cover;';
              $('.re-table__list-image--new-row').css("height", "84px")
              $('.re-table__list-image--new-row').css("width", "84px")
              //img.onload = fn;
            }
          });


          document.getElementById('addRowImage').onclick = function () {
            document.getElementById('new-row-fileUpload').click();
          };

          $('.addAListingButton1').on('click', function (e) {
            e.preventDefault();
            $('#addAListingButton').css("visibility", "hidden")
            //TODO hide() doesnt work ?
            $('#addAListingRow').show();
            $('#addAListingRowSpace').show();
            $('#addAListingSubmitAndCancel').show();
            $(".bottom").css("visibility", "hidden")

          });

          $('.addAListingButton0').on('click', function (e) {
            e.preventDefault();
            $('#addAListingButton').css("visibility", "hidden")
            //TODO hide() doesnt work ?
            $('#addAListingRow').show();

            $('#addAListingRowSpace').show();
            $('#addAListingSubmitAndCancel').show();
            $(".bottom").css("visibility", "hidden")
            $("html, body").animate({
              scrollTop: ($(".addAListingRow").offset().top-600)
            }, "slow");
          });



          $('#addAListingCancel').on('click', function (e) {
            e.preventDefault();
            $(this).show();
            $('#addAListingButton').css("visibility", "visible")
            $('#addAListingButton').show();
            $('#addAListingRow').hide();
            $('#addAListingRowSpace').hide();
            $('#addAListingSubmitAndCancel').hide();
            $('#addAListingButton').show();
            $('.bottom').css("visibility", "visible")
          });

          // Listing submition

          $('#addAListingSubmit').on('click', function (e) {
            e.preventDefault();

            // Clone image input to the hidden form
            var image = $('#new-row-fileUpload');
            var image_clone = image.clone();
            image.after(image_clone).appendTo('#form_hidden');

            // clone text aras
            $('#addAListingRow textarea').each(function (txt) {
              $("<input type='hidden' name='cells[" + txt + "]' value='" + $(this).val() + "' />").appendTo(
                "#form_hidden");
            });

            $('#form_hidden').submit();
          })

          // discussion stuff

          $('.re-button--list-discussion').on('click', function () {
            $(this).hide().next('form').show()
          });

          $('.j_table-discussion').on('click', '.reply.reply-maincomment', function (ev) {
            ev.preventDefault();
            var target = $(ev.currentTarget);
            var $form = target.parents('.comment').nextAll('form').first();

            $form.show();

            $form.find('.commentParentId').val(target.attr('data-id'));

            $form.find('.commentTextArea').focus();
          });

          $('.j_table-discussion').on('click', '.reply.reply-subcomment', function (ev) {
            ev.preventDefault();
            var target = $(ev.currentTarget);
            var $form = target.parents('.comment').nextAll('form').first();

            $form.show();

            $form.find('.commentTextArea').val('@' + target.attr('data-handle') + ' ');
            $form.find('.commentParentId').val(target.attr('data-id'));

            $form.find('.commentTextArea').focus();
          });


          // list edit stuff

          function linkifyAndDropdownifyCells() {
            console.log("asdsad")
            $('.re-table tr.list-row-tr:not(.list-row-tr--add-row)').each(function () {
              $(this).find('td:nth-of-type(1n+4) div').each(function () {
                var $this = $(this);
                var maxPos = 161;
                var rawText = $this.text();
                var text = '';
                var linkStrippedText = rawText.replace(
                  /((http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?)/g,
                  function (match) {
                    return (new URL(match))['host'].replace('www.', '');
                  });
                if (linkStrippedText.length > maxPos) {
                  var lastPos = maxPos - 3;
                  text = rawText.substr(0, lastPos);
                  text = text.substr(0, Math.min(text.length, text.lastIndexOf(" "))) + '...';
                  text +=
                    '<a href="javascript:;" class="table-cell-show-more-button l-button" data-dropdown-placement="bottom">More!</a>';
                  text += '<div class="l-dropdown sh-dropdown table-cell-show-more-dropdown">' + rawText +
                    '</div>';
                } else {
                  text = rawText;
                }
                text = text.replace(
                  /((http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?)/g,
                  function (match) {
                    return '<a class="re-table-link" target="_blank" title="' + match + '" href="' +
                      match +
                      '">' + (new URL(match))['host'].replace('www.', '') + '</a>';
                  })
                $this.html(text);
              });
              window.bindPops();
            });
          }

          function unlinkifyAndUnDropdownifyCells() {
            $('.re-table').find('.re-table-link').replaceWith($('.re-table').find('.re-table-link').attr('href'));
            $('.table-cell-show-more-dropdown').each(function () {
              var $this = $(this);
              $this.parents('td').html('<div>' + $this.text() + '</div>');
            });
          }

          var listImage;
          var listName;
          var listTagline;
          var listDescription;
          var listColumns;
          var listRows;
          var listTags;
          var listRelated;
          var listCurators;

          document.querySelector('#re-image-fileUpload').addEventListener('change', function () {
            if (this.files && this.files[0]) {
              var img = $('.re-image');
              img.attr('style', 'background: #f5f5f5 url(' + URL.createObjectURL(this.files[0]) +
                ') center / cover;');
              //img.onload = fn;
            }
          });
          document.querySelector('.re-image__upload-button').onclick = function () {
            document.getElementById('re-image-fileUpload').click();
          };
          document.querySelector('.re-image__delete-button').onclick = function () {

            document.getElementById('re-image-fileUpload').value = "";
            var img = $('.re-image');
            img.attr('style', 'background: #f5f5f5 url() center / cover;');
          };

          $('.re-table__list-image-fileUpload').on('change', function () {
            if (this.files && this.files[0]) {
              var img = $(this).parents('td').find('.re-table__list-image');
              img.removeClass('re-table__list-image--empty');
              img.attr('style', 'background: #f5f5f5 url(' + URL.createObjectURL(this.files[0]) +
                ') center / cover;');

              //img.onload = fn;
            }
          });

          $('.re-table__list-image--editing').on('change', function () {
            // if (this.files && this.files[0]) {
            //   var img = $(this).parents('td').find('.re-table__list-image');
            //   img.removeClass('re-table__list-image--empty');
            //   img.attr('style', 'background: #f5f5f5 url(' + URL.createObjectURL(this.files[0]) +
            //     ') center / cover;');

            //   //img.onload = fn;
            // }
          });
          $('.re-table__list-image__upload-button').on('click', function () {
            $(this).parents('td').find('.re-table__list-image-fileUpload').click();
          });
          $('.re-table__list-image__delete-button').on('click', function () {
            $(this).parents('td').find('.re-table__list-image-fileUpload').val('');
            var img = $(this).parents('td').find('.re-table__list-image');
            img.addClass('re-table__list-image--empty');
            img.attr('style', 'background: #f5f5f5 url() center / cover;');
          });


          function startEditList() {
            unlinkifyAndUnDropdownifyCells();

            listImage = $('.re-image').attr('style');
            listName = $('.re-heading').text();
            listTagline = $('.re-subheading .actual-tagline').text();
            listDescription = $('.re-para').text();
            listColumns = $('.re-table th:nth-of-type(1n+4)').map(function () {
              return this.innerText
            });
            listRows = $('.re-table tr.list-row-tr:not(.list-row-tr--add-row)').map(function () {
              var $this = $(this);
              return {
                id: $this.data('id'),
                image: $this.find('.re-table__list-image').attr('style'),
                content: $this.find('td:nth-of-type(1n+4) div').map(function () {
                  return this.innerText;
                }),
              }
            });
            listTags = $('#tags').text();
            listRelated = $('#related-lists-edit').val();
            listCurators = $('#curators-edit').val();

            $('.re-header').addClass('re-header--editing');
            $('.re-image').addClass('re-image--editing');
            $('.re-heading').attr('contenteditable', 'true');
            $('.re-subheading .actual-tagline').attr('contenteditable', 'true');
            $('.re-para').attr('contenteditable', 'true');
            $('.re-table th:nth-of-type(1n+4)').attr('contenteditable', 'true');
            $('#tags').attr('contenteditable', 'true');
            $('.related-lists-new').hide();
            $('#related-lists-edit').show();
            $('#curators').hide();
            $('#curators-edit').show();
            $('.re-table tr.list-row-tr:not(.list-row-tr--add-row) td:nth-of-type(1n+4) div').attr(
              'contenteditable',
              'true');
            $('.re-table__list-image').addClass('re-table__list-image--editing');
            $('.related-lists-new-heading').show();
            bindListCellEditableSizing();
          }

          /* $('.list-edit-button').on('click', function (e) {
            e.preventDefault();


          }); */

          function leaveEditUrl() {
            var url = window.location.pathname;
            url = url.replace(url.match(/([^\/]*)\/*$/)[1], '').replace('//', '/');
            history.pushState(null, null, url);
          }

          $('.re-header .cancel-button').on('click', function (e) {
            e.preventDefault();
            $('.re-header').removeClass('re-header--editing');
            $('.re-image').removeClass('re-image--editing');
            $('.re-heading').attr('contenteditable', 'false');
            $('.re-subheading .actual-tagline').attr('contenteditable', 'false');
            $('.re-para').attr('contenteditable', 'false');
            $('.re-table th:nth-of-type(1n+4)').attr('contenteditable', 'false');
            $('.re-table tr.list-row-tr:not(.list-row-tr--add-row) td:nth-of-type(1n+4) div').attr(
              'contenteditable', 'false');
            $('#tags').attr('contenteditable', 'false');
            unbindListCellEditableSizing();

            $('.re-image').attr('style', listImage);
            $('.re-heading').text(listName);
            $('.re-subheading .actual-tagline').text(listTagline);
            $('.re-para').text(listDescription);
            $('.re-table th:nth-of-type(1n+4)').each(function (i) {
              $(this).text(listColumns[i]);
            });
            $('.re-table tr.list-row-tr:not(.list-row-tr--add-row)').each(function (i) {
              var $this = $(this);
              $this.find('.re-table__list-image').attr('style', listRows[i].image);
              $this.find('td:nth-of-type(1n+4) div').each(function (ii) {
                $(this).text(listRows[i].content[ii]);
              });
            });
            $('#related-lists-edit').val(listRelated);
            $('.re-table__list-image').removeClass('re-table__list-image--editing');
            $('#tags').text(listTags);
            $('#curators').text(listCurators);
            $('.related-lists-new').show();
            $('#related-lists-edit').hide();
            $('#curators').show();
            $('#curators-edit').hide();
            if (!listRelated.length) {
              $('.related-lists-new-heading').hide();
            }

            linkifyAndDropdownifyCells();
            leaveEditUrl();
          });

          $('.re-header .save-button').on('click', function (e) {
            e.preventDefault();

            listImage = $('.re-image').attr('style');
            listName = $('.re-heading').text();
            listTagline = $('.re-subheading .actual-tagline').text();
            listDescription = $('.re-para').text();
            listColumns = $('.re-table th:nth-of-type(1n+4)').map(function () {
              return this.innerText
            });
            listRows = $('.re-table tr.list-row-tr:not(.list-row-tr--add-row)').map(function () {
              var $this = $(this);
              return {
                id: $this.data('id'),
                image: $this.find('.re-table__list-image').attr('style'),
                content: $this.find('td:nth-of-type(1n+4) div').map(function () {
                  return this.innerText;
                }).get(),
              }
            });
            listTags = $('#tags').text();
            listRelated = $('#related-lists-edit').val();
            listCurators = $('#curators-edit').val();

            $('#list-image').val(listImage.replace('background: #f5f5f5 url(', '').replace(') center / cover;',
              ''));
            $('#list-name').val(listName);
            $('#list-tagline').val(listTagline);
            $('#list-description').val(listDescription);
            $('#list-columns').val(JSON.stringify(listColumns.get()));
            $('#list-rows').val(JSON.stringify(listRows.get().map(function (row) {
              return {
                id: row.id,
                content: row.content,
                image: row.image.replace('background: #f5f5f5 url(', '').replace(') center / cover;',
                  '')
              };
            })));
            $('#list-tags').val(listTags);
            $('#list-related').val(listRelated);
            $('#list-curators').val(listCurators);

            $('#edit-list-form').submit();
          });

          var href = location.href;
          var lastUrlPathSegment = href.match(/([^\/]*)\/*$/)[1];
          console.log(lastUrlPathSegment);
          if (lastUrlPathSegment === 'edit') {
            startEditList();
          }



          // $('.re-table tr').on('contextmenu', function (e) {
          //   e.preventDefault();
          //   mouse = { pageX: e.clientX, pageY: e.clientY };
          //   popInstance.scheduleUpdate();
          //   $('#list-context-menu').addClass('show');
          // });


          var permission = "2";

          $('.edit-column-name').on('click', function () {

          });

          $('.add-column-left').on('click', function () {
            swal({
                title: "What is the title of the new column?",
                input: "text",
                text: "Please type the new column title.",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                preConfirm: newValue => {
                  if (typeof newValue !== "string") {
                    return;
                  }

                  return addCol(
                    $('.re-table').data('id'),
                    newValue,
                    permission
                  );
                }
              })
              .then(result => {
                if (!result.value) {
                  return;
                }
                if (permission === "1") {
                  swal(
                    "Success!",
                    "The request to add this column is awaiting approval.",
                    "success"
                  );
                } else if (permission === "2") {
                  swal({
                    title: "Success!",
                    type: "success",
                    timer: 650,
                    showConfirmButton: false
                  });
                }
              })
              .catch(() => {
                swal("Oops", "Something has gone wrong!", "error");
              });
          });

          $('.add-column-right').on('click', function () {

          });

          $('.remove-column').on('click', function () {

          });

          var tableShadowElementsContainer = $('.absolute-containers');
          var tableShadowElements = tableShadowElementsContainer.find('.re-table:not(.addAListingRow) tbody .shadowcontain');
          if (tableShadowElements.length > 0) {
              $.each(tableShadowElements, function(i, element) {
                  $element = $(element);
                  var offset = $element.position();
                  var mirrorContent = $element.html();
                  var newElement = $('<div/>')
                      .addClass('shadowcontain cloned-item')
                      .html(mirrorContent)
                      .offset(offset);

                  $('.table-list-container').append(newElement);
                  $element.hide();
              });
          }
        });


        // Sharing

        var url = window.location.href;
        var title = "{{ table['title'] }}";

        $('#share-twitter').on('click', function (e) {
          e.preventDefault();
          var txt = 'Check this spreadsheet out! ';
          window.open('http://twitter.com/share?url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(txt),
            '', 'left=0,top=0,width=550,height=450,personalbar=0,toolbar=0,scrollbars=0,resizable=0');
        })

        $('#share-hacker').on('click', function (e) {
          e.preventDefault();
          var txt = 'Check this spreadsheet out! ';
          window.open('https://news.ycombinator.com/submitlink?u=' + encodeURIComponent(url) + '&t=' +
            encodeURIComponent(title), '',
            'left=0,top=0,width=550,height=450,personalbar=0,toolbar=0,scrollbars=0,resizable=0');
        })

        $('#share-reddit').on('click', function (e) {
          e.preventDefault();
          var txt = 'Check this spreadsheet out! ';
          window.open('https://www.reddit.com/submit?url=' + encodeURIComponent(url), '',
            'left=0,top=0,width=550,height=450,personalbar=0,toolbar=0,scrollbars=0,resizable=0');
        })

        $('#share-facebook').on('click', function (e) {
          e.preventDefault();
          FB.ui({
            method: 'share',
            display: 'popup',
            href: url,
          }, function (response) {});
        })
      </script>
      {% endblock %}
