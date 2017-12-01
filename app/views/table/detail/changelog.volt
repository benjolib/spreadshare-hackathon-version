{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - Changelog for table {{ table['title'] }}{% endblock %}

{% block content %}

{{ partial('table/detail/header') }}

{% if requests %}
<div class="container container--changelog">
    <div class="container__content container__content--column">
    {% for request in requests %}
    <form method="POST">
        <div class="container__content">
            <div class="addTable__content__main__options">
                <div class="addTableEmpty__content__main__options__item">
                    <div class="addTableEmpty__content__main__options__item__column">
                        <div class="changelog__row">
                            <div class="changelog__avatar">
                                <img src="{{ request['userImage'] }}" />
                            </div>
                            <div class="changelog__column changelog__column--text">
                                <h5><a href="/user/{{ request['userHandle'] }}">{{ request['user'] }}</a></h5>
                                <!--<p>COLUMN <span>Pricing</span> <i>●</i> ROW <span>Slack</span></p>-->
                            </div>
                        </div>
                        <div class="changelog__row changelog__row--changes">
                            <div class="changelog__column changelog__column--oldChange">
                                <p>OLD</p>
                                <input type="text" placeholder="Empty" autofocus="" name="title" value="{{ request['from'] }}" disabled>
                            </div>
                            <div class="changelog__icon">
                                <img src="/assets/icons/chevron-right.svg" />
                            </div>
                            <div class="changelog__column changelog__column--newChange">
                                <p>NEW</p>
                                <input type="text" placeholder="Empty" autofocus="" name="title" value="{{ request['to'] }}" disabled>
                            </div>
                        </div>
                        <div class="changelog__row changelog__row--notice">
                            <p>{{ formatTimestamp(request['createdAt']) }}</p>
                            {#<p>"Here appears the editors comment to the admin"</p>#}
                        </div>
                    </div>
                </div>

            </div>
            <div class="changelog__row changelog__row--addComment">
                {% if request['status'] == 0%}
                <div class="changelog__commentInput">
                    <input type="text" name="comment" class="changelog-comment-{{ request['id'] }}" placeholder="Add a comment" />
                </div>

                <div class="changelog__commentButtons">
                    {#<a href="#">View Change</a>#}
                    <button class="review-change-request" data-id="{{ request['id'] }}" data-type="reject">Reject</button>
                    <button class="review-change-request" data-id="{{ request['id'] }}" data-type="confirm">Confirm</button>
                </div>
                {% elseif request['status'] == 2 %}
                <div class="changelog__commentInput">
                    <input type="text" name="comment" placeholder="No comment given" value="{{ request['comment'] }}" disabled="disabled" />
                </div>
                <div class="changelog__commentButtons">
                    <p>Change has been rejected.</p>
                </div>
                {% else %}
                <div class="changelog__commentInput">
                    <input type="text" name="comment" placeholder="No comment given" value="{{ request['comment'] }}" disabled="disabled" />
                </div>
                <div class="changelog__commentButtons">
                    <p>Change has been approved.</p>
                </div>
                {% endif %}

            </div>
        </div>
    </form>
    {% endfor %}
    </div>

    {% else %}
    <div class="container container--changelog">
        <div class="container__content container__content--row">
        <div class="center" style="background:white;-webkit-border-radius: 8px;-moz-border-radius: 8px;border-radius: 8px;padding:50px;">
            <img src="/assets/images/desktop.png" alt="" />
            <p>&nbsp;</p>
            <p>There are no change requests yet or no one is matching your filter "{{ page }}".</p>

            {% if auth().getUserId() != table['ownerUserId'] %}
                <p><a href="/table/{{ table['id'] }}">Go</a> and make your first contribution to this table.</p>
            {% endif %}
        </div>
    </div>
    {% endif %}
    <aside class="aside aside--changelog">
        <a href="/table/{{ table['id'] }}/changelog">
            <div class="aside__item {% if page == '' %}item-selected{% endif %}">
                <p>All</p>
            </div>
        </a>
        <a href="/table/{{ table['id'] }}/changelog/new">
            <div class="aside__item {% if page == 'new' %}item-selected{% endif %}">
                <p>New adds</p>
            </div>
        </a>
        <a href="/table/{{ table['id'] }}/changelog/edits">
            <div class="aside__item {% if page == 'edits' %}item-selected{% endif %}">
                <p>Edits</p>
            </div>
        </a>
        <a href="/table/{{ table['id'] }}/changelog/deletes">
            <div class="aside__item {% if page == 'deletes' %}item-selected{% endif %}">
                <p>Deletes</p>
            </div>
        </a>
        <a href="/table/{{ table['id'] }}/changelog/confirmed">
            <div class="aside__item {% if page == 'confirmed' %}item-selected{% endif %}">
                <p>Confirmed</p>
            </div>
        </a>
        <a href="/table/{{ table['id'] }}/changelog/rejected">
            <div class="aside__item {% if page == 'rejected' %}item-selected{% endif %}">
                <p>Rejected</p>
            </div>
        </a>
    </aside>
</div>

{% endblock %}

{% block scripts %}
{{ partial('table/detail/flag') }}
{% endblock %}
