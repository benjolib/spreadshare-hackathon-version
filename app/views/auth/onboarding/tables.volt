{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
<form id="onboardingForm" method="post" action="/signup/finished">
    <div class="tables">
        <div class="tables__content">
            <div class="tables__content__wrapper">
                <div class="signup__content__form__buttons">
                    <button>Finish</button>
                </div>
                <p class="tables__content__title">Here are some <span>tables</span> you might like</p>
                <p class="tables__content__subtitle">Tell us which tables you’re most interested in. <span>Pick at least 3</span></p>

                <div class="tables__content__main">

                    {# cards #}
                    <div class="tables__content__main__cards">
                        {% for table in tables %}
                        {{ partial('partials/table') }}
                        {% endfor %}
                    </div>

                </div>
            </div>
            <aside class="tables__content__aside">
                <div class="tables__content__aside__box">
                    <a href="/signup/topics">
                        <div>Topics</div>
                    </a>
                    <a href="/signup/follow">
                        <div>People</div>
                    </a>
                    <a href="/signup/location">
                        <div>Regions</div>
                    </a>
                    <a href="/signup/tables">
                        <div class="sign-box-selected">Tables</div>
                    </a>
                </div>
            </aside>
        </div>
    </div>
</form>
{% endblock %}

{% block scripts %}
<script type="text/javascript">
  $(document).ready(function () {
    $('.tables__content__main__cards__item').on('click', '.tables__content__main__cards__item__info__upvote', function (ev) {
      ev.stopPropagation();
      var target = $(ev.currentTarget);
      var id = target.attr('data-id');

    });
  });
</script>
{% endblock %}
