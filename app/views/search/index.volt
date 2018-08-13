{% extends 'layouts/main.volt' %} {# page title #} {% block title %}SpreadShare - Search{% endblock %}
{# page header #} {% block header %}{% endblock %} {# main section #} {% block content %}

<div class="re-page">
    <input type="hidden" id="search" value="{{query}}"/>
  <table class="re-table">
    <tbody id="hits-container">



    </tbody>
  </table>
</div>
{% endblock %} {% block scripts %}
<script src="https://cdn.jsdelivr.net/npm/instantsearch.js@2.3/dist/instantsearch.min.js">
</script>
<script type="text/javascript">
  const search = instantsearch({
    appId: '{{ config["algolia"]["app-id"] }}',
    apiKey: '{{ config["algolia"]["api-key"] }}',
    indexName: 'spreadshare-stream-{{ config["mode"] }}',
    routing: true,
    paginationLimitedTo: 0,
    query: '{{query}}'
  });

 
  var readyToFetchMore = true;

  var hitsContainer = $('#hits-container');
  search.addWidget(
    instantsearch.widgets.searchBox({
      container: '#search'
    })
  );
  search.addWidget({
    init: function (params) {
      params.helper.setQueryParameter('hitsPerPage', 10);

      function scrollhandler() {

        var isAtBottomOfPage = $(window).scrollTop() + $(window).height() >
          $(document).height() - 500;

        if (readyToFetchMore && isAtBottomOfPage) {
          readyToFetchMore = false;
          params.helper.nextPage().search();
        }
      }

      $(window).bind("scroll", scrollhandler);
    },

    render: function (params) {

      readyToFetchMore = true;

      var hits = params.results.hits;


      if (params.state.page === 0) { 
        hitsContainer.html('');
      }

      var html = '';

      if (params.results.nbHits > 0) {

        html = hits.map(function (hit) {

          return `<tr>
                  <td>
                  
                <a class="" href="/stream/${ hit.objectId }">
                      <h3>${hit.title} &nbsp;&nbsp;
                <img src="/assets/images/9-0/list-card-subscriber-bird.svg">
                <span class="list-card__subscriberCount">${ hit.subscribers } </span>
                </h3>
                      <p>${ hit.tagline } </p>
                  </td>
                </tr>
                <tr class="re-table-space"></tr>`

        });

      } else {
        html = [`<div class="re-page">
                  </div>
                  <div class="info-box">
                    <div class="info">
                      <div class="heading"> We're sorry </div>
                      <div class="subheading"> There are no results for your search. </div>
                    </div>
                    <div class="action">
                      <button onclick="window.location.href='/'" :> Back to Home </button>
                    </div>

                  </div>`];
      }

      hitsContainer.append(html.join(''));
    }
  });

  search.start();
</script>
{% endblock %}