<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,800" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
  <link rel="stylesheet" href="/css/styles.css">
  <link href="/css/main.508c7389.css" rel="stylesheet">
  {% block header %}{% endblock %}
  <title>{% block title %}{% endblock %}</title>
</head>
<body>
{# navbar #}
{{ partial('layouts/navbar') }}

{# main section #}
<section class="main">
  {{ flash.output() }}

  {# content #}
  {% block content %}{% endblock %}

  {# footer #}
  {{ partial('layouts/footer') }}
</section>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script>
<script type="text/javascript" src="/js/api.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
     // autoCompleteHandler to handle response
     function autoCompleteHandler(response){

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
       $.each(hits, function(key,val) {
          // item
          items.push("<a href='/table/" +  val._source.id + "'><div class='item'><div class='title'>" + val._source.title + "</div><div class='tagline'>" + val._source.tagline + "</div></div></a>");
       });
      // append list to array
       $(searchItems).append(items.join(''));


     }

     var searchFieldEl = $("input.navbar__search__field");
     // On change of the field
     $(searchFieldEl).on("change paste keyup", function() {
      /* Popper */
      var searchReferenceElement = $(this);
      var onSearchPopper = $('.search-autocomplete');
      var searchEl = $(this).val();
      // When the search query is greater than 3
      if (searchEl.length > 3) {
        // AJAX Query
        $.ajax({
          url: "/api/v1/search/",
          method: "GET",
          crossDomain: true,
          dataType: "JSON",
          data: {"query":  searchEl},
          success: function(response) { autoCompleteHandler(response) }
        });

        onSearchPopper.addClass('show');

        new Popper(searchReferenceElement, onSearchPopper, {
          placement: 'bottom',
        });
      }



    });


  });
</script>
{{ partial('layouts/scripts') }}

<script type="text/javascript" src="/js/react/main.5d352c3b.js"></script>
{% block scripts %}{% endblock %}
</body>
</html>
