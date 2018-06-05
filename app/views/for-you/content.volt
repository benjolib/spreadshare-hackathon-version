{% for element in feedElements %}
    {% switch element.getType() %}
    {% case "submittedListing" %}
        {{ partial('for-you/submittedListing', ['listing': element]) }}
    {% break %}
    {% case "newList" %}
        {{ partial('for-you/newList', ['newList': element]) }}
    {% break %}
    {% case "subscribedList" %}
        {{ partial('for-you/subscribedList', ['newList': element]) }}
    {% break %}
    {% case "votedListing" %}
        {{ partial('for-you/votedListing', ['listing': element]) }}
    {% break %}
    {% case "collabListing" %}
        {{ partial('for-you/collabListing', ['listing': element]) }}
    {% break %}
    {% endswitch %}
{% endfor %}
