{% if users %}
<div class="container__content container__content--users">
    <div class="tableUsers">
        {% for user in users %}
        <div class="tableUsers__item">
            <div class="tableUsers__item__avatar">
                <img src="{{ user['image'] }}" />
            </div>
            <div class="tableUsers__item__info">
                <div class="tableUsers__item__info__title">
                    <h5><a href="/user/{{ user['handle'] }}">{{ user['name'] }}</a></h5>
                </div>
                <div class="tableUsers__item__info__subtitle">
                    {% if user['location'] and user['tagline']%}
                    <p>{{ user['location'] }} ● {{ user['tagline'] }}</p>
                    {% elseif user['location'] %}
                    <p>{{ user['location'] }}</p>
                    {% elseif user['tagline'] %}
                    <p>{{ user['tagline'] }}</p>
                    {% else %}
                    <p style="visibility:hidden;">No tagline!</p>
                    {% endif %}
                </div>
            </div>
            {% if auth.loggedIn() and auth.getUserId() != user['id'] %}
            <div class="tableUsers__item__follow">
                <button class="follow-user {% if user['following'] %}following-user selected {% else %}not-following-user {% endif %}" data-id="{{ user['id'] }}" type="button"></button>
            </div>
            {% elseif auth.loggedIn() and auth.getUserId() == user['id'] %}
            <div class="tableUsers__item__follow">
                <button disabled="disabled" class="follow-user" type="button">It's you</button>
            </div>
            {% endif %}
        </div>
        {% endfor %}
    </div>
</div>
{% endif %}
