{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - Changelog for table {{ table['title'] }}{% endblock %}

{% block content %}

{{ partial('table/detail/header') }}

<div class="container container--changelog">
  <div class="container__content">
    <div class="addTable__content__main__options">
      <form method="POST">
        <div class="addTableEmpty__content__main__options__item">
          <div class="addTableEmpty__content__main__options__item__column">
            <div class="changelog__row">
              <div class="changelog__avatar">
                <img src="/assets/images/anakin.jpg" />
              </div>
              <div class="changelog__column changelog__column--text">
                <h5>Anakin Skywalker</h5>
                <p>COLUMN <span>Pricing</span> <i>●</i> ROW <span>Slack</span></p>
              </div>
            </div>
            <div class="changelog__row changelog__row--changes">
              <div class="changelog__column changelog__column--oldChange">
                <p>OLD</p>
                <input type="text" placeholder="Bay Area Seed-stage Business Angels" autofocus="" name="title" value="$7 per User" disabled>
              </div>
              <div class="changelog__icon">
                <img src="/assets/icons/chevron-right.svg" />
              </div>
              <div class="changelog__column changelog__column--newChange">
                <p>NEW</p>
                <input type="text" placeholder="Bay Area Seed-stage Business Angels" autofocus="" name="title" value="$9 per User" disabled>
              </div>
            </div>
            <div class="changelog__row changelog__row--notice">
              <p>"Here appears the editors comment to the admin"</p>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="changelog__row changelog__row--addComment">
      <div class="changelog__commentInput">
        <input type="text" placeholder="Add a comment" />
      </div>
      <div class="changelog__commentButtons">
        <a href="#">View Change</a>
        <button>Reject</button>
        <button>Confirm</button>
      </div>
    </div>
  </div>
  <aside class="aside aside--changelog">
    <a href="#">
      <div class="aside__item item-selected">
        <p>All</p>
      </div>
    </a>
    <a href="#">
      <div class="aside__item">
        <p>New adds</p>
      </div>
    </a>
    <a href="#">
      <div class="aside__item">
        <p>Edits</p>
      </div>
    </a>
    <a href="#">
      <div class="aside__item">
        <p>Deletes</p>
      </div>
    </a>
  </aside>
</div>

{#
{% if requests %}
<div>
    {% for request in requests %}
    <div>
        {{ request['from'] }}
        {{ request['to'] }}
        {{ request['user'] }}
        {{ request['userHandle'] }}
        {{ formatTimestamp(request['createdAt']) }}
        {% if request['status'] == 0%}
        <input type="text" name="comment" class="changelog-comment-{{ request['id'] }}" />
        <button class="review-change-request" data-id="{{ request['id'] }}" data-type="confirm">Confirm</button>
        <button class="review-change-request" data-id="{{ request['id'] }}" data-type="reject">Reject</button>
        {% elseif request['status'] == 2 %}
        <div>Change has been rejected.</div>
        <div>{{ request['comment'] }}</div>
        {% else %}
        <div>Change has been approved.</div>
        <div>{{ request['comment'] }}</div>
        {% endif %}
    </div>
    {% endfor %}
</div>

{% else %}
<div class="center">
    <img src="/assets/images/desktop.png" alt="" />
    <p>&nbsp;</p>
    <p>There are no change requests, yet.</p>

    {% if auth().getUserId() != table['ownerUserId'] %}
    <p><a href="/table/{{ table['id'] }}">Go</a> and make your first contribution to this table.</p>
    {% endif %}
</div>
{% endif %}
#}

{% endblock %}

{% block scripts %}
  {{ partial('table/detail/flag') }}
{% endblock %}
