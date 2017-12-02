{% extends 'layouts/main.volt' %}

{# page title #}
{% block title %}SpreadShare - Community curated Tables{% endblock %}

{# page header #}
{% block header %}{% endblock %}

{# main section #}
{% block content %}

<form method="GET" id="searchSidebarForm">
{# content #}
<input type="hidden" name="query" value="{{ query }}" />

<div class="container container--home">
    {# tables content #}
    <div class="container__content">

			{# cards #}
			<div class="tables__content__main__cards">
				{% if tables %}
					{% for table in tables %}
						{{ partial('partials/table') }}
					{% endfor %}
				{% else %}


					<div class="tables__content__main__cards__item center" style="padding:40px;">
						<div>
							<img src="/assets/images/desktop.png" alt="" />
							<p>&nbsp;</p>
							<p>We couldn't find any tables matching your search.</p>
						</div>
					</div>
				{% endif %}
			</div>
    </div>

	{# sidebar wrapper #}
	<div class="aside__wrapper">

  {# sidebar 1 #}
  <aside class="aside aside--home" id="filterByEntity">
    <div class="main__content__sidebar__option" id="topicFilter">
      <span>Filter Search Results</span>
    </div>
    <ul class="filter open filter--entity">
      <li>
      <label class="selected">
       <input type="radio" name="entity" checked="checked"  value="">All</input>
      </label>
      </li>
    </ul>

  </aside>


		{# sidebar 2 #}
		<aside class="aside aside--home" id="filterByTopic">
			<div class="main__content__sidebar__option" id="topicFilter">
				<span>Filter by Topic</span>
			</div>
				<ul class="filter open filter--topic {% if sidebarFilter.topic %}open{% endif %}">
					<li>
						<label {% if sidebarFilter.topic== "" %}class="selected"{% endif %}>
							<input type="radio" name="topic" {% if sidebarFilter.topic== "" %}checked="checked"{% endif %} value="" /> All
						</label>
					</li>
					{% for topic in topics %}
						<li>
							<label {% if sidebarFilter.topic== topic.id %}class="selected" {% endif %} title="{{ topic.title|e }}">
								<input type="radio" name="topic" {% if sidebarFilter.topic== topic.id %}checked="checked" {% endif %} value="{{ topic.id }}" /> {{ topic.title|e }}
							</label>
						</li>
					{% endfor %}
				</ul>
		</aside>

		{# sidebar 3 #}
		<aside class="aside aside--home" id="filterByType">
			<div class="main__content__sidebar__option" id="typeFilter">
				<span>Filter by Table Type</span>
			</div>
            <ul class="filter open filter--type {% if sidebarFilter.type %}open{% endif %}">
                <li>
                    <label {% if sidebarFilter.type== "" %}class="selected"{% endif %}>
                    <input type="radio" name="type" {% if sidebarFilter.type== "" %}checked="checked"{% endif %} value="" />All</label>
                </li>
                {% for type in types %}
                    <li>
                        <label {% if sidebarFilter.type== type.id %}class="selected" {% endif %} title="{{ type.title|e }}">
                            <input type="radio" name="type" {% if sidebarFilter.type== type.id %}checked="checked" {% endif %} value="{{ type.id }}" /> {{ type.title|e }}
                        </label>
                    </li>
                {% endfor %}
            </ul>
		</aside>

		{# sidebar 4 #}
		<aside class="aside aside--home" id="filterByTags">
			<div class="main__content__sidebar__option" id="tagFilter">
				<span>Filter by Tags</span>
			</div>
			<div id="TagsSelect" data-name="tags[]" data-value="{{ reactArray(filteredTags) }}" data-submit-form-on-change="searchSidebarForm" data-placeholder="" class="react-component"></div>
		</aside>

		{# sidebar 5 #}
		<aside class="aside aside--home" id="filterByLocation">
			<div class="main__content__sidebar__option" id="locationFilter">
				<span>Filter by location</span>
			</div>
            <div id="LocationSelect" data-name="locations[]" data-value="{{ reactArray(filteredLocations) }}" data-submit-form-on-change="searchSidebarForm" data-placeholder="" class="react-component"></div>
		</aside>
	</div>
</div>
</form>
{% endblock %}

{% block scripts %}
	<script type="text/javascript">
		$(document).ready(function () {


			$('#searchSidebarForm ul.filter > li > label').on('change', function (ev) {
				document.getElementById('searchSidebarForm').submit();
			});
		});

		// $('.navbar__search__filter').on('click', function () {
		// 	$('.filter').toggleClass('open');
		// 	window.location.hash = "#filters";
		// });

		// $('#topicFilter').on('click', function () {
		// 	$('.filter--topic').toggleClass('open');
		// });

		// $('#typeFilter').on('click', function () {
		// 	$('.filter--type').toggleClass('open');
		// });


	</script>
{% endblock %}
