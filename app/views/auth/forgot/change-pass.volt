{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - Forgot Password{% endblock %}

{% block content %}
<div class="login">
    <div class="login__content">
        <div class="login__content__wrapper">
            <p class="login__content__title">Change password</p>
            <p class="login__content__subtitle">Please enter a new password for your account.</p>
            <form class="login__content__form" method="post">
                <input type="hidden" name="userId" value="{{ userId }}" />
                <p>Password</p>
                <input type="password" name="password" tabindex="1" autofocus />
                <p>Confirm password</p>
                <input type="password" name="password2" tabindex="2" />
                <div class="login__content__form__buttons">
                    <a href="/login">Cancel</a>
                    <button type="submit">Change Password</button>
                </div>
            </form>
        </div>
        <aside class="login__content__aside">
            <div class="login__content__aside__box">
                <a href="/signup">
                    <div>Sign up</div>
                </a>
                <a href="/login">
                    <div>Sign in</div>
                </a>
                <a href="/login/forgot">
                    <div class="sign-box-selected">Forgot password</div>
                </a>
            </div>
            <p>OR</P>
            <div class="signup__content__aside__social">
                <div class="signup__content__aside__social__facebook">
                    <img src="/assets/icons/facebook.svg" />
                    <a href="/login/facebook">connect via Facebook</a>
                </div>
                <div class="signup__content__aside__social__twitter">
                    <img src="/assets/icons/twitter.svg" />
                    <a href="/login/twitter">connect via Twitter</a>
                </div>
                <div class="login__content__aside__social__google">
                    <img src="/assets/icons/google.svg" />
                    <a href="/login/google">connect via Google</a>
                </div>
            </div>
        </aside>
    </div>
</div>
{% endblock %}
