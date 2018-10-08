<script type="text/javascript">
    var dropdownSelectors = [
        '.notification-dropdown',
        '.user-dropdown2',
        '.search__dropdown'
    ];

    function haltScroll() {
        haveVisible = dropdownSelectors.filter(element => isVisible(element) == true).length > 0;

        if (haveVisible) {
            $('body').addClass("turn-scroll-off");
        } else {
            $('body').removeClass("turn-scroll-off");
        }
    }

    haltScroll();

    // check if visible
    function isVisible(element) {
        var element = $(element);
        return (element.length > 0 && element.css('display') !== 'none' && element.css('visibility') !== 'hidden' && element.css('opacity') !== 0);
    }

    window.initOnOffSwitches = function () {
        var $NoSwitch = $('.NSwitch');
        var $YesSwitch = $('.YSwitch');

        $NoSwitch.click(function () {
            var $this = $(this);

            if (!$this.hasClass('active')) {
                $this.toggleClass('active');
                $this.toggleClass('animated bounceIn');
                $this.prev().removeClass('active animated bounceIn');
                //$this.prop('disabled', true);
                //$this.prev().prop('disabled', false);
                $('input[name="' + $this.attr('data-name') + '"]').prop('value', '0');
            }
        });

        $YesSwitch.click(function () {
            var $this = $(this);

            if (!$this.hasClass('active')) {
                $this.toggleClass('active');
                $this.toggleClass('animated bounceIn');
                $this.next().removeClass('active animated bounceIn');
                //$this.prop('disabled', true);
                //$this.next().prop('disabled', false);
                $('input[name="' + $this.attr('data-name') + '"]').prop('value', '1');
            }
        });
    }

    $(document).ready(function () {
        $('.__page__sidebar').stickySidebar({
            topSpacing: 60,
            bottomSpacing: 60
        });

        $(".__page__sidebar ul li").click(function () {
            $(".__page__sidebar ul li").removeClass('active');
            $(this).addClass('active');
        });

        //////////////////////////
        //
        // Search Results Handlers
        //
        //////////////////////////

        var timer;
        var delay = 0; // 0.6 seconds delay after last input

        /**
         * Stream search
         */
        function autoCompleteStreams(response) {
            // search item list selector for div id="streams-search-items"
            var streamsSearchItemsElem = $('#streams-search-items');

            // Insert total results value
            $('.streams-result-count').html(response.length + " RESULTS");

            // items array
            var items = [];
            // empty the existing list
            $(streamsSearchItemsElem).empty();

            // foreach array
            let i = 0
            $.each(response, function (key, val) {
                i++
                if (i > 5) {
                    // display N first results only
                    return;
                }
                // add display item to the list of items
                items.push( "<a href='/stream/" + val.objectID + "'>" +
                                "<div class='item'>" +
                                    "<div class='title'>" + val.title + "</div>" +
                                    "<div class='tagline'>" + val.tagline + "</div>" +
                                "</div>" +
                            "</a>"
                );
            });
            // append items list to <div>
            $(streamsSearchItemsElem).append(items.join(''));

            if (response.length > 5) {
                // show 'more results' link
                $('.all-results').css("display", "block")
            } else {
                // hide 'more results' link
                $('.all-results').css("display", "none")
            }
        }

        /**
         * User search
         */
        function autoCompleteUsers(response) {
            // search item list selector for div id="users-search-items"
            var usersSearchItemsElem = $('#users-search-items');

            // Insert total results value
            $('.users-result-count').html(response.length + " RESULTS");

            // items array
            var items = [];
            // empty the existing list
            $(usersSearchItemsElem).empty();

            // foreach array
            let i = 0
            $.each(response, function (key, val) {
                i++
                if (i > 5) {
                    // display N first results only
                    return;
                }
                // add display item to the list of items
                items.push( "<a href='/profile/" + val.handle + "'>" +
                                "<div class='item'>" +
                                    "<div class='title'>" + val.name + "</div>" +
                                    "<div class='tagline'>" + val.tagline + "</div>" +
                                "</div>" +
                            "</a>"
                );
            });
            // append items list to <div>
            $(usersSearchItemsElem).append(items.join(''));
        }

        var searchFieldElem = $('input.navbar__search__field');
        var searchPopupElem = $('.search-autocomplete');

        var prevSearchValue = '';

        $(searchFieldElem).on("change keyup paste", function () {
            setTimeout(function () {
                    haltScroll();
                },
                10
            );

            var searchReferenceElem = $(this);
            var searchValue = $(this).val();

            if (searchValue !== prevSearchValue) {
                // searching for new value

                prevSearchValue = searchValue;
                if (searchValue.length > 0) {
                    // modify 'More results' links to search for current content
                    $(".all-results").attr('href', '/search?query=' + searchValue + '')

                    window.clearTimeout(timer);
                    timer = window.setTimeout(function () {
                            // AJAX Query
                            // $.ajax({
                            //   url: "/api/v1/search/",
                            //   method: "GET",
                            //   crossDomain: true,
                            //   dataType: "JSON",
                            //   data: {
                            //     "query": searchEl.trim()
                            //   },
                            //   success: function (response) {
                            //     autoCompleteStreams(response)
                            //   }
                            // });
                            document.searchstream.search({query: searchValue, hitsPerPage: 500}, function(err, content) {
                                autoCompleteStreams(content.hits)
                            });

                            document.searchusers.search({query: searchValue, hitsPerPage: 500}, function(err, content) {
                                autoCompleteUsers(content.hits)
                            });
                        },
                        delay
                    );
                    searchPopupElem.addClass('show');

                    new Popper(searchReferenceElem, searchPopupElem, {
                        placement: 'bottom',
                        modifiers: {
                            offset: {
                                offset: '0 20'
                            },
                            flip: {
                                enabled: false
                            }
                        }
                    });
                }
            }
        });

        //$('.navbar__search').focusout(function() { // if(!flag) onSearchPopper.removeClass('show') });

        $('.re-header__bell').click(function (ev) {
            $.get("/api/v1/notifications?p=" + 0, function (data) {
                haltScroll();
                $('.notification-dropdown').html(data);
            });
        });

        $(document).bind('click', function (e) {
            var closestSearch = $(e.target).closest('.navbar__search');
            var closestControl = $(e.target).closest('.navbar__controls');
            // If not closest hide popper for search
            if (!closestSearch.length) {
                searchPopupElem.removeClass('show');
            }
            //console.log("closestControl", closestControl.length);
        });

        // flash messages timeout
        var time = 150;
        var $flashes = $('.flash__message');
        setTimeout(function () {
                $flashes.each(function (index, item) {
                    var $flash = $(item);
                    setTimeout(function () {
                            $flash.addClass('flash__message--hide');
                        },
                        time * index
                    )
                });
            },
            7000
        );

        // search bar shadow
        var $searchBar = $('.navbar__search');
        $searchBar.on('focusin', function () {
            $(this).addClass('navbar__search--active');
        });
        $searchBar.on('focusout', function () {
            $(this).removeClass('navbar__search--active');
        });

        /* Define API endpoints once and globally */
        $.fn.api.settings.api = {
            'upvote': '/api/v1/vote/{id}',
            'subscribe': '/api/v1/subscribe/{id}',
            'flag': '/table/{id}/flag/{flag}',
            'follow-user': '/api/v1/follow-user/{id}',
            'comment-upvote': '/api/v1/vote-comment/{id}',
            'change-request': '/api/v1/change-request/{id}',
            'staff-pick': '/api/v1/staff-pick/{id}',
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
                    button.find('.chevronUp').find('svg').find('.fillColor').removeClass('white');
                    span.text(parseInt(parseInt(span.text()) - 1));
                }
            },
        });

        $('button.subscribe').api({
            method: 'POST',
            action: 'subscribe',
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

        $('button.review-change-request').api({
            method: 'POST',
            action: 'change-request',
            beforeSend: function (settings) {
                settings.data = {
                    comment: $('.changelog-comment-' + $(this).data('id')).val(),
                    type: $(this).data('type')
                };
                return settings;
            },
            onSuccess: function (response, button) {
                location.reload();
            },
        });

        $('button.staff-pick').api({
            method: 'POST',
            action: 'staff-pick',
            onSuccess: function (response, button) {
                location.reload();
            },
        });
    });

    $(document).ready(function () {
        // pops

        // var finterval = setInterval(function () {
        //   $(".feedback").css("display", "none")
        // }, 5000)

        window.bindPops = function () {
            $('.l-button:not(.bound)').each(function () {
                var $button = $(this);
                // default select l-dropdown under button
                var $dropdown = $button.next('.l-dropdown');
                // if specified use the target dropdown instead
                if ($button.data('dropdown-target')) {
                    $dropdown = $($button.data('dropdown-target'));
                }

                new Popper(
                    $button,    // reference
                    $dropdown,  // popper
                    {
                        placement: $button.data('dropdown-placement') || 'bottom-end',
                        modifiers: {
                            offset: {
                                offset: Number($button.data('dropdown-offset')) || 0
                            },
                            flip: {
                                enabled: false,
                                behavior: ['bottom', 'top', 'bottom']
                            }
                        }
                    }
                );

                $button.click(function () {
                    if ($dropdown.hasClass("show") || $('.l-dropdown').hasClass("show")) {
                        $('.l-dropdown').removeClass('show');
                        $dropdown.removeClass("show");
                        // TODO remove number on close
                        $(".numberCircle").before('<img src="/assets/images/9-0/header-notifications.svg" />');
                        $(".numberCircle").remove();
                    } else {
                        $dropdown.addClass('show');
                    }

                    if ($button.data('dropdown-active-class')) {
                        $button.addClass($button.data('dropdown-active-class'));
                    }
                });

                // $button.mouseover(function () {
                //   if(!$button.hasClass("mouseover")) return;
                //   if($dropdown.hasClass("show") || $('.l-dropdown').hasClass("show")) {

                //     $('.l-dropdown').removeClass('show');
                //     $dropdown.removeClass("show");
                //   }else {
                //     $dropdown.addClass('show');
                //   }

                //   if ($button.data('dropdown-active-class')) {
                //     $button.addClass($button.data('dropdown-active-class'));
                //   }
                // });

                //$button.addClass('bound');
            });
        };

        window.bindPops();

        var hidePopover = function (element, e) {
            if (!$(element).is(e.target) && $(element).has(e.target).length === 0 && !$('.l-button').is(e.target) && $('.l-button').has(e.target).length === 0) {
                $(element).removeClass('show');
            }
        }

        $('body').on('click', function (e) {
            $('.l-dropdown').each(function (index, el) {
                hidePopover(el, e);
            });

            hidePopover($('#list-context-menu'), e);
            $('.l-button').each(function (index, item) {
                var $item = $(item);
                if (!$item.is(e.target) && $item.has(e.target).length === 0 && !$('.l-dropdown').is(e.target) && $('.l-dropdown').has(e.target).length === 0) {
                    if ($item.data('dropdown-active-class') && $item.hasClass($item.data('dropdown-active-class'))) {
                        $item.removeClass($item.data('dropdown-active-class'));
                    }
                }
            });
        });

        $('.re-header__search').on('click', function (e) {
            e.preventDefault();
            $('.re-header__search-open').show();
            $('.re-header__search').attr('style', 'opacity:0;pointer-events:none;');
            $("input.navbar__search__field").focus();
        });

        $('.search-close').on('click', function (e) {
            e.preventDefault();
            $('.re-header__search-open').hide();
            $('.re-header__search').attr('style', 'opacity:1;pointer-events:auto;');
            $("input.navbar__search__field").val("");
        });

        window.createAlert = function (type, heading, text, timeout) {
            if (type !== 'notice' && type !== 'warning' && type !== 'success' && type !== 'error') {
                console.error('createAlert fail: use a type (arg 0) of notice, warning, success or error');
                return;
            }

            if (!heading) {
                console.error('createAlert fail: supply a heading (arg 1)');
                return;
            }

            if (!text) {
                console.error('createAlert fail: supply text (arg 2)');
                return;
            }

            timeout = timeout || 5000;

            var $flashMessage = $(
                '<div class="flash__message flash__message--' + type + ' flash__message--hide">' +
                    '<div class="flash__message__heading">' + heading + '</div>' +
                    '<div class="flash__message__text">' + text + '</div>' +
                '</div>'
            );

            $('.flash').prepend($flashMessage);
            setTimeout(function () {
                    $flashMessage.removeClass('flash__message--hide');
                },
                0
            );

            setTimeout(function () {
                    $flashMessage.addClass('flash__message--hide');
                    setTimeout(function () {
                            $flashMessage.remove();
                        },
                        500
                    );
                },
                timeout
            );
        };

        new ModalVideo($(".feedback"));

        $('.re-header__user').click(function () {
            setTimeout(function () {
                    haltScroll();
                },
                10
            );
        });

        $('html').click(function(e) {
            // if clicked element is not your element and parents aren't your div
            if (e.target.id.indexOf(dropdownSelectors) === -1 && $(e.target).parents(dropdownSelectors.join(',')).length == 0) {
                $('body').removeClass("turn-scroll-off");
            }
        });

    });

</script>