{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
<div class="re-page">
    <div class="collaborations-page-space">
        <h1 class="re-heading">For You</h1>
        <h2 class="re-subheading">Activity of users you follow and lists you subscribe.</h2>
    </div>

    {% for element in feedElements %}
        {% switch element.getType() %}
        {% case "listing" %}
            {{ partial('for-you/submittedListing', ['listing': element]) }}
        {% break %}
        {% case "newList" %}
            {{ partial('for-you/newList', ['newList': element]) }}
        {% break %}
        {% endswitch %}
    {% endfor %}
    <div class="u-flex u-flexJustifyCenter">
        <a href="#" class="re-button re-button--load-more">Load More</a>
    </div>
</div>
{% endblock %}

{% block scripts %}
    <script type="text/javascript">
        $(document).ready(function () {

        });
    </script>
{% endblock %}
