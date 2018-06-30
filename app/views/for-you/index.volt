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
        {% if feedElements|length is 0 %}  {% else %} <a href="#" class="re-button re-button--load-more">Load More</a> {%endif%}
    </div>
</div>
{% endblock %}

{% block scripts %}
    <script type="text/javascript">
    var x,y,top,left,down;

$(".table-scroll").mousedown(function(e){
    e.preventDefault();
    down = true;
    x = e.pageX;
    y = e.pageY;
    top = $(this).scrollTop();
    left = $(this).scrollLeft();
});

$("body").mousemove(function(e){
    if(down){
        var newX = e.pageX;
        var newY = e.pageY;

 $(".table-scroll").scrollTop(top - newY + y);
 $(".table-scroll").scrollLeft(left - newX + x);
    }
});

$("body").mouseup(function(e){down = false;});
        $(document).ready(function () {
            var pageNumber = {{ page }}+1;
            var feedDate = {{ feedDate }};
            //TODO [improve] do not use class as element pointer
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
                    console.log("click upvote");
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
        
        
        });
    </script>
{% endblock %}
