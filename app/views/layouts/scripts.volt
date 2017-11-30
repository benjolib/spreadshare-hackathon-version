<script type="text/javascript">
  $(document).ready(function () {

    var timer;
    var delay = 600; // 0.6 seconds delay after last input
    // autoCompleteHandler to handle response
    function autoCompleteHandler(response) {

      // search item list selector
      var searchItems = $('#search-items');
      // hits object
      var hits = response.data.hits.hits;
      // Insert total results value
      $('.result-count').html(hits.length + " RESULTS");
      // create item array
      var items = [];
      // empty the existing list
      $(searchItems).empty();
      // foreach array
      $.each(hits, function (key, val) {
        // item
        items.push("<a href='/table/" + val._source.id + "'><div class='item'><div class='title'>" + val._source.title + "</div><div class='tagline'>" + val._source.tagline + "</div></div></a>");
      });
      // append list to array
      $(searchItems).append(items.join(''));

    }

    var searchFieldEl = $("input.navbar__search__field");
    var onSearchPopper = $('.search-autocomplete');
    // On change of the field

    $(searchFieldEl).on("change paste keyup", function() {

     /* Popper */
     var searchReferenceElement = $(this);

     var searchEl = $(this).val();
     // When the search query is greater than 3
     if (searchEl.length > 3) {

       window.clearTimeout(timer);
       timer = window.setTimeout(function(){
       // AJAX Query
       $.ajax({
         url: "/api/v1/search/",
         method: "GET",
         crossDomain: true,
         dataType: "JSON",
         data: {"query":  (searchEl + '*')},
         success: function(response) { autoCompleteHandler(response) }
       });

       }, delay);


       onSearchPopper.addClass('show');

       new Popper(searchReferenceElement, onSearchPopper, {
         placement: 'bottom',
       });
     }

    });

    //$('.navbar__search').focusout(function() { // if(!flag) onSearchPopper.removeClass('show') });

    /* Profile Menu Popper */
    var referenceElement;
    var onPopper = $('.profile-menu');

    /* Notifications Popper */
    var refElem;
    var popper = $('.dropdown--notifications');

    // initial state
    if (window.innerWidth < 1024) {
      referenceElement = $('.navbar__controls__add--menu');
      refElem = $('.navbar__controls__add--notification');
    } else {
      referenceElement = $('.navbar__controls__notification');
      refElem = $('.navbar__controls__add--notification');
    }

    if (onPopper.length > 0 && popper.length > 0) {
      // create poppers
      new Popper(referenceElement, onPopper, {
        placement: 'bottom'
      });
      new Popper(refElem, popper, {
        placement: 'bottom'
      });

      // event listener
      $(window).resize(function () {
        if (window.innerWidth < 1024) {
          referenceElement = $('.navbar__controls__add--menu');
          refElem = $('.navbar__controls__add--notification');
          popper.removeClass('left160');
        } else {
          referenceElement = $('.navbar__controls__notification');
          refElem = $('.navbar__controls__add--notification');
        }
        new Popper(referenceElement, onPopper, {
          placement: 'bottom'
        });
        new Popper(refElem, popper, {
          placement: 'bottom'
        });
      });

      //toggle menu
      $('#profileImage').click(function () {
        popper.removeClass('show');
        $(onPopper).toggleClass('show');
      });
      // toggle notifications
      $('#notificationButton').click(function () {
        onPopper.removeClass('show');
        $(popper).toggleClass('show');

        $.get("/api/v1/notifications?p=" + 0, function (data) {
          $(popper).html(data);
        });
      });
    }

    $(document).bind('click', function (e) {
      var closestSearch = $(e.target).closest('.navbar__search');
      var closestControl = $(e.target).closest('.navbar__controls');
      // If not closest hide popper for search
      if (!closestSearch.length) {
        onSearchPopper.removeClass('show');
      }
      //console.log("closestControl", closestControl.length);
      if (!closestControl.length) {
        onPopper.removeClass('show');
      }

    });

    // flash messages timeout
    var $flash = $('.flash');
    if ($flash.length > 0) {
      setTimeout(function () {
        $flash.css('display', 'none');
      }, 7000);
    }

    /* Define API endpoints once and globally */
    $.fn.api.settings.api = {
      'upvote': '/api/v1/vote/{id}',
      'subscribe': '/api/v1/subscribe/{id}',
      'flag': '/table/{id}/flag/{flag}',
      'follow-user': '/api/v1/follow-user/{id}',
      'comment-upvote': '/api/v1/vote-comment/{id}',
    };

    $('a.comment-upvote').api({
      method: 'POST',
      onSuccess: function (response, button) {
        var span = button.find('span');
        if (response.data.voted) {
          span.text(parseInt(parseInt(span.text()) + 1));
        } else {
          span.text(parseInt(parseInt(span.text()) - 1));
        }
      },
    });

    $('div.upvote, button.upvote').api({
      method: 'POST',
      onSuccess: function (response, button) {
        var span = button.find('span');
        if (response.data.voted) {
          button.addClass('selected');
          button.find('.chevronUp').find('svg').find('.fillColor').addClass('white');
          span.text(parseInt(parseInt(span.text()) + 1));
        } else {
          button.removeClass('selected');
          span.text(parseInt(parseInt(span.text()) - 1));
        }
      },
    });
    $('button.subscribe').api({
      method: 'POST',
      onSuccess: function (response, button) {
        button.toggleClass('subscribed');
      },
    });
    $('button.follow-user').api({
      method: 'POST',
      action: 'follow-user',
      onSuccess: function (response, button) {
        $(button).toggleClass('selected').toggleClass('following-user').toggleClass('not-following-user');
      },
    });
  });
</script>
