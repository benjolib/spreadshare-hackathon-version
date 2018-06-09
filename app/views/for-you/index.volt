{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
<div class="re-page">
    <div class="collaborations-page-space">
        <h1 class="re-heading">Feed</h1>
        <h2 class="re-subheading">Updates from publications and people you follow</h2>
    </div>
    <div id="elements">
        {{ partial('for-you/content') }}
    </div>
    <div class="u-flex u-flexJustifyCenter">
        <a href="#" class="re-button re-button--load-more">Load More</a>
    </div>
</div>
{% endblock %}

{% block scripts %}
    <script type="text/javascript">
        $(document).ready(function () {
            var pageNumber = {{ page }}+1;
            var feedDate = {{ feedDate }};
            $('.re-button--load-more').on('click', function (e) {
                e.preventDefault();
                $.ajax(window.location.pathname + '?page=' + pageNumber +'&date='+ feedDate)
                    .done(function (response) {
                        if (response) {
                            $('#elements').append(response);
                            pageNumber += 1;
                        }
                    });
            });
        });
    </script>
{% endblock %}
