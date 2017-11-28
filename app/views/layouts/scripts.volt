<script type="text/javascript">
  $(document).ready(function () {
    /* Popper */
    var referenceElement;
    var onPopper = $('.profile-menu');

    // initial state
    if (window.innerWidth < 1024) {
      referenceElement = $('.navbar__controls__add');
    } else {
      referenceElement = $('.navbar__controls__notification');
    }
    new Popper(referenceElement, onPopper, {
      placement: 'bottom',
    });

    // event listener
    $(window).resize(function () {
      if (window.innerWidth < 1024) {
        referenceElement = $('.navbar__controls__add');
      } else {
        referenceElement = $('.navbar__controls__notification');
      }
      new Popper(referenceElement, onPopper, {
        placement: 'bottom',
      });
    });

    //toggle menu
    $('#profileImage').click(function () {
      $(onPopper).toggleClass('show');
    });

    // flash messages timeout
    var $flash = $('.flash');
    if ($flash.length > 0) {
      setTimeout(function () {
        $flash.css('display', 'none');
      }, 3800);
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
        if (response.data.subscribed) {
          button.addClass('subscribed');
        } else {
          button.removeClass('subscribed');
        }
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