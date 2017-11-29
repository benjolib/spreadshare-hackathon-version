<script type="text/javascript">
  $(document).ready(function () {
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
      popper.removeClass('left160');
    } else {
      referenceElement = $('.navbar__controls__notification');
      refElem = $('.navbar__search__filter');
      popper.addClass('left160');
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
          refElem = $('.navbar__search__filter');
          popper.addClass('left160');
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
        $(onPopper).toggleClass('show');
      });
      // toggle notifications
      $('#notificationButton').click(function () {
        $(popper).toggleClass('show');
      });
    }

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
    };

    $('div.upvote, button.upvote').api({
      method: 'POST',
      onSuccess: function (response, button) {
        var span = button.find('span');
        if (response.data.voted) {
          button.addClass('selected');
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
