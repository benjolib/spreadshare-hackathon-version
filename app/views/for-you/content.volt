{% if feedElements  %}
{% for element in feedElements %} 
{% switch element.getType() %} 
{% case "submittedListing"%} 
{{ partial('for-you/submittedListing', ['listing': element]) }} 
{% break %} 
{% case "newList" %} 
{{ partial('for-you/newList',['newList': element]) }} 
{% break %} 
{% case "subscribedList" %} 
{{ partial('for-you/subscribedList', ['newList': element])
}} {% break %} 
{% case "votedListing" %} 
{{ partial('for-you/votedListing', ['listing': element]) }} 
{% break %} 
{% case"collabListing" %} 
{{ partial('for-you/collabListing', ['listing': element]) }} 
{% break %} 
{% endswitch %} 
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