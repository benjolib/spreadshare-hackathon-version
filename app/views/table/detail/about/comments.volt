<p id="comments">Comments <span>{{ commentsCount }}</span></p>
<div class="tableAbout__comments">
  <div class="tableAbout__comments__content">
    {% if comments %}
      {% for comment in comments %}
        {{ partial('table/detail/comment') }}

        <div class="tableAbout__comments__content__subcomments">
          {% for comment in comment['childs'] %}
          {{ partial('table/detail/subcomment') }}
          {% endfor %}
        </div>
      {% endfor %}

    {% else %}
      <div class="center" style="padding:40px;">
        <img src="/assets/images/desktop.png" alt="" />
        <p>&nbsp;</p>
        <p>There are no comments added to this table, yet.</p>
        <p>Be the first to add a comment!</p>
      </div>
    {% endif %}

    {% if auth.loggedIn() %}
    <div class="tableAbout__comments__content__send">
      <form method="POST" action="/table/{{ table['id'] }}/about">
          <input type="hidden" name="parentId" id="commentParentId" value="" />
          <textarea name="comment" id="commentTextArea" placeholder="Add a comment" minlength="3" maxlength="300"></textarea>
          <button>Send</button>
      </form>
    </div>
    {% endif %}
  </div>
</div>
