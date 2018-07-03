{% if feedElements  %}
{% for element in feedElements %} 

{% if element %}

{% if element.getType() == "submittedListing" %}
{{ partial('for-you/submittedListing', ['listing': element]) }} 
{% endif %}

{% if element.getType() == "newList" %}
{{ partial('for-you/newList', ['newList': element]) }}
{% endif %}

{% if element.getType() == "subscribedList" %}
{{ partial('for-you/subscribedList', ['newList': element]) }}
{% endif %}

{% if element.getType() == "votedListing" %}
{{ partial('for-you/votedListing', ['listing': element]) }}
{% endif %}

{% if element.getType() == "collabListing" %}
{{ partial('for-you/collabListing', ['listing': element]) }}
{% endif %}

{% endif %}
{% endfor %}
{% else %}
{% if page is 0 %}

<div class="info-box">
    <div class="info">
        <div class="heading"> Nothing here </div>
        <div class="subheading"> Subscribe Streams to active your feed. </div>
    </div>
    <div class="action">
        <button onclick="window.location.href='/'" :> Explore Streams </button>
    </div>
</div>

{% endif %}
{% endif %}

