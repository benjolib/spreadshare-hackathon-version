{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - About{% endblock %}

{% block header %}
{% endblock %}

{% block content %}
  <div class="re-page about-page">
    <div class="u-flex u-sm-flexCol u-md-flexRow u-flexJustifyBetween lists-page-space">
      <div>
        <h1 class="re-heading">About</h1>
        <h2 class="re-subheading re-subheading--button-below">All things Spreadshare.</h2>
      </div>
      <div>
        <a href="mailto:hi@spreadshare.co" class="re-button get-in-touch">Get in touch</a>
      </div>
    </div>

    <table class="re-table">
      <tbody>
        <tr>
          <td>
            <a href="/stream/our-team"><h3>Team</h3></a>
            <p>Co-workers / Team / Community Members</p>
          </td>

          <td></td>
        </tr>
        <tr class="re-table-space"></tr>
        <tr>
          
          <td>
            <a href="/stream/work-with-us"><h3>Work</h3></a>
            <p>Jobs, mini tasks, remote work & voluntary support options</p>
          </td>
          <td></td>
        </tr>
        <tr class="re-table-space"></tr>
        
        <td>
          <a href="/stream/our-curators"><h3>Suggest a Curators</h3></a>
          <p>Have someone in mind who should curate a Stream here? </p>
        </td>
        <td></td>
      </tr>

        <tr class="re-table-space"></tr>
        <tr>
          <td>
            <a href="/stream/blog"><h3>Blog</h3></a>
            <p>Blog posts and other recourses we value</p>
          </td>
          <td></td>
        </tr>
        <tr class="re-table-space"></tr>
        <tr class="re-table-space"></tr>
        <tr>
          <td>
            <a href="/stream/frequently-asked"><h3>FAQ</h3></a>
            <p>Frequently asked questions answered</p>
          </td>
          <td></td>
        </tr>
        <tr class="re-table-space"></tr>

        <tr>
          <td>
            <a href="/stream/terms-of-service"><h3>Terms</h3></a>
            <p>Terms & Conditions</p>
          </td>
          <td></td>
        </tr>
        <tr class="re-table-space"></tr>
        <tr>
          <td>
            <a href="/stream/privacy-policy"><h3>Privacy</h3></a>
            <p>Privacy Policy, Cookie Policy & Disclaimer</p>
          </td>
          <td></td>
        </tr>
        <tr class="re-table-space"></tr>

      </tbody>
    </table>
    <div style="margin-top: 80px;overflow-x:none;" class="u-flex u-sm-flexWrap u-md-flexNoWrap thanks-to">
      <a href="https://twitter.com/spreadshareco" target="_blank"><img src="/assets/images/about-social-twitter.png" /></a>
      <a href="https://medium.com/spreadshare" target="_blank"><img src="/assets/images/about-social-medium.png" /></a>
      <a href="https://www.producthunt.com/posts/spreadshare" target="_blank"><img src="/assets/images/about-social-producthunt.png" /></a>
      <a href="https://join.slack.com/t/spreadshare-community/shared_invite/enQtMzcwMjE1MDI4ODAyLTJjZjE5NTQ5ZGMwY2M0ZGZkYjA3YmQ4NmI1NTg5Y2E0YWFmYTNlMmM5ODJjZWY4OTNhYWMyMzkxNDI4MWYxY2M" target="_blank"><img src="/assets/images/about-social-slack.png" /></a>
      <a href="https://www.facebook.com/groups/403500643362775/" target="_blank"><img src="/assets/images/about-social-facebook.png" /></a>
      <!-- <a href="#"><img src="/assets/images/about-social-github.png" /></a> -->
      <a href="https://www.linkedin.com/company/spreadshare-inc/" target="_blank"><img src="/assets/images/about-social-linkedin.png" /></a>
      <a href="https://angel.co/spreadshare" target="_blank"><img src="/assets/images/about-social-angellist.png" /></a>
      <!-- <a href="#"><img src="/assets/images/about-social-p.png" /></a> -->
    </div>
<style>
  .nobox {
 box-shadow: 0 0px 0px 0 rgba(236, 2, 2, 0.18) !important;
 border: 0px !important;
 text-align: center !important;
  }
</style>
<table class="re-table" >
<tr class="nobox">
<td class="nobox">
<p>We thank
  <a href="https://www.toicon.com/">to [icon]</a> for using some of their icons</p>
  </td>
</tr>

    </table>

  </div>
{% endblock %}

{% block scripts %}
  <script type="text/javascript">
    $(document).ready(function () {

    });
  </script>
{% endblock %}
