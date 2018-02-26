{% if tables %}
{% for table in tables %}
 {{ partial('partials/table') }}
{% endfor %}
{% else %}
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
