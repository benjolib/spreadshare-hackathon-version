{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - Settings for table {{ table['title'] }}{% endblock %}

{% block content %}

{{ partial('table/detail/header') }}

{{ flash.output() }}

<form method="POST" enctype="multipart/form-data">
    <div class="container container--tableDetails">
        <div class="container__content">
            <div class="addTable__content__main__options">
                {% if page == "related" %}
                {{ partial('table/detail/settings/related') }}
                {% endif %}

                {% if page == "options" %}
                {{ partial('table/detail/settings/options') }}
                {% endif %}

                {% if page == "details" %}
                {{ partial('table/detail/settings/details') }}
                {% endif %}
            </div>
            {# buttons #}
            <div class="addTableEmpty__content__main__buttons">
                <div class="" style="position: absolute;left: 20px;top: 20px;">
                    <button name="action" value="delete" class="button red">Delete Table</button>
                </div>
                <a href="/table/add">Cancel</a>
                <button type="submit">Save Changes</button>
            </div>
        </div>

        <aside class="aside aside--tableDetails">
            <a href="/table/{{ table['id'] }}/settings/details">
                <div class="aside__item {% if page == 'details' %}item-selected{% endif %}"><p>Table Details</p></div>
            </a>
            <a href="/table/{{ table['id'] }}/settings/options">
                <div class="aside__item {% if page == 'options' %}item-selected{% endif %}"><p>Table Options</p></div>
            </a>
            <a href="/table/{{ table['id'] }}/settings/related">
                <div class="aside__item {% if page == 'related' %}item-selected{% endif %}"><p>Related Table</p></div>
            </a>
        </aside>
    </div>
</form>
{% endblock %}

{% block scripts %}
{{ partial('table/detail/flag') }}
{% endblock %}
