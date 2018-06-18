{% for subscription in subscriptions %}
    {% switch subscription.type %}
    {% case 'D' %}
        {% set type='Daily' %}
    {% break %}
    {% case 'W' %}
        {% set type='Weekly' %}
    {% break %}
    {% case 'M' %}
        {% set type='Monthly' %}
    {% break %}
    {% default %}
        {% set type=subscription.type %}
    {% endswitch %}
    <tr>
        <td>
            {# {% if isAjax %}<input class="moreToLoad" type="hidden" value="{{ moreToLoad }}" />{% endif %} #}
            <div class="re-table-green">{{ subscription.numSubscribers }} SUBSCRIBERS</div>
            <a href="/list/{{ subscription.tableId }}"><h3>{{ subscription.title }}</h3></a>
            <p>{{ subscription.tagline }}</p>
        </td>
        <td>
            <div class="u-flex u-flexJustifyCenter u-flexAlignItemsCenter card-actions-button l-button">
                <span class="card-actions-button__text">{{ type }}</span><img src="/assets/images/arrow-down.svg"/>
            </div>
            <div class="sh-dropdown card-actions-dropdown card-actions-dropdown--tall u-flex u-flexCol u-flexJustifyCenter l-dropdown">
                <a href="javascript:;" onclick="subsFreqOnClick({{ subscription.tableId }}, 'D')">Daily</a>
                <a href="javascript:;" onclick="subsFreqOnClick({{ subscription.tableId }}, 'W')">Weekly</a>
                <a href="javascript:;" onclick="subsFreqOnClick({{ subscription.tableId }}, 'M')">Monthly</a>
                <a href="javascript:;" onclick="subsFreqOnClick({{ subscription.tableId }}, 'U')"class="warning-color">Unsubscribe</a>
            </div>
        </td>
    </tr>
    <tr class="re-table-space"></tr>
{% endfor %}
