<div class="tables">
    {% if tables %}
        <div class="main__content__tables__filters">
            <div class="main__content__tables__filters__left">
                <span class="text-green text-uppercase">{{ dateRangeString }}</span>
            </div>
            {% if !isAjax %}
            <div class="main__content__tables__filters__right">
                <li class="{% if order is 'newest' %}link-active{% endif %}"><a href="/tables/newest">Newest</a></li>
                <li class="{% if order is 'most-upvoted' %}link-active{% endif %}"><a href="/tables/most-upvoted">Upvotes</a></li>
                <li class="{% if order is 'most-viewed' %}link-active{% endif %}"><a href="/tables/most-viewed">Views</a></li>
                <li class="{% if order is 'most-contributed' %}link-active{% endif %}"><a href="/tables/most-contributed">Contributions</a></li>
            </div>
            {% endif %}
        </div>

        <div class="tables__content__main__cards">
            {% for table in tables %}
            {{ partial('partials/table') }}
            {% endfor %}
        </div>
    {% else %}
        {% if !isAjax %}
            <div class="tables__content__main__cards__item center" id="no-results" style="padding:40px;">
                <div>
                    <img src="/assets/images/desktop.png" alt="" />
                    <p>&nbsp;</p>
                    <p>We couldn't find any tables matching your search.</p>
                    <p>&nbsp;</p>
                    <p><a class="button bold" href="/table/add">Create Table</a></p>
                </div>
            </div>
        {% endif %}
    {% endif %}

    {% if isAjax %}
        <script type="text/javascript">
            $('.tables__content__main__cards').data('infiniteScroll').pageIndex = parseInt('{{ loadedUntilPage }}');
        </script>
    {% endif %}
</div>