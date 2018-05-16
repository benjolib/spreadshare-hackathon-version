{% extends 'layouts/main.volt' %}

{% block header %}
{% endblock %}

{% block content %}
  <div class="re-page re-page--create-list">
    <div class="re-image re-image--create-list">
      <div class="re-image__upload-button"></div>
      <div class="re-image__delete-button"></div>
    </div>
    <div class="re-heading-input">
      <img class="re-heading-input__tick" src="/assets/images/input-tick.svg" />
      <img class="re-heading-input__tick-green" src="/assets/images/input-tick-green.svg" />
      <input type="text" placeholder="Your publication's title" />
    </div>
    <div class="re-subheading-input">
      <img class="re-heading-input__tick" src="/assets/images/input-tick.svg" />
      <img class="re-heading-input__tick-green" src="/assets/images/input-tick-green.svg" />
      <input type="text" placeholder="Write a tagline for your publication" />
    </div>
    <div class="re-para-input">
      <img class="re-heading-input__tick" src="/assets/images/input-tick.svg" />
      <img class="re-heading-input__tick-green" src="/assets/images/input-tick-green.svg" />
      <input type="text" placeholder="Write a short desciption text" />
    </div>

    <div class="create-list-add-tags">
      <img class="re-heading-input__tick" src="/assets/images/input-tick.svg" />
      <img class="re-heading-input__tick-green" src="/assets/images/input-tick-green.svg" />
      <p>Add at least 3 tags: <span>Add Tags</span></p>
    </div>
    <div class="create-list-has-thumbnails">
      <img class="re-heading-input__tick" src="/assets/images/input-tick.svg" />
      <img class="re-heading-input__tick-green" src="/assets/images/input-tick-green.svg" />
      <p>Do your posts have thumbnails? <span class="create-list-has-thumbnails-selected">Yes</span> <span>No</span></p>
    </div>
    <div class="create-list-add-curator">
      <p>If there are other curators than you? <span>Add a Curator</span></p>
    </div>
    <div class="create-list-add-related">
      <p>If this publication is related to an existing publication on our site: <span>Add a Publication</span></p>
    </div>

    <div class="create-create-list-tabs">
      <div class="create-create-list-tabs__inner">
        <div class="create-list-tab-buttons u-flex extra-small-gutter">
          <a href="#" class="re-button re-button--full-width extra-small-margin create-list-tab-button create-list-tab-button-new active">Start from scratch</a>
          <a href="#" class="re-button re-button--grey re-button--full-width extra-small-margin create-list-tab-button create-list-tab-button-import">Import Publication (CSV)</a>
          <a href="#" class="re-button re-button--grey re-button--full-width extra-small-margin create-list-tab-button create-list-tab-button-copy">Copy from Google Sheet</a>
        </div>

        <div class="create-list-tab-content create-list-tab-content-new">
          <div class="table-scroll">
            <table class="re-table re-table--list">
              <thead>
                <tr>
                  <th class="shadowcontainth" style="min-width: 0;width: 0;"></th>
                  <th>
                    THUMBNAIL
                  </th>
                  <th>COLUMN TITLE <img src="/assets/images/create-list-edit-column-title.svg" /></th>
                  <th>COLUMN TITLE <img src="/assets/images/create-list-edit-column-title.svg" /></th>
                  <th>COLUMN TITLE <img src="/assets/images/create-list-edit-column-title.svg" /></th>
                  <th>COLUMN TITLE <img src="/assets/images/create-list-edit-column-title.svg" /></th>
                </tr>
              </thead>
              <tbody>
                <tr id="addAListingRow" class="list-row-tr list-row-tr--add-row">
                  <td class="shadowcontaintd"><div class="shadowcontain shadowcontain--no-votes"></div></td>
                  <td>
                    <div class="re-table__list-image re-table__list-image--new-row re-table__list-image--new-row-type2" id="addRowImage">
                      <div class="re-table__list-image__upload-button"></div>
                      <div class="re-table__list-image__delete-button"></div>
                    </div>
                    <input type="file" name="image" id="fileUpload" style="display: none;" />
                  </td>
                  <td><textarea placeholder="insert content" rows="1" oninput="$(this).height(5);$(this).height($(this).prop('scrollHeight'))"></textarea></td>
                  <td><textarea placeholder="insert content" rows="1" oninput="$(this).height(5);$(this).height($(this).prop('scrollHeight'))"></textarea></td>
                  <td><textarea placeholder="insert content" rows="1" oninput="$(this).height(5);$(this).height($(this).prop('scrollHeight'))"></textarea></td>
                  <td><textarea placeholder="insert content" rows="1" oninput="$(this).height(5);$(this).height($(this).prop('scrollHeight'))"></textarea></td>
                </tr>
                <tr class="re-table-space"></tr>
              </tbody>
            </table>
          </div>
          <div class="u-flex small-gutter" style="margin-top: 40px;">
            <a href="#" class="re-button re-button--full-width re-button--grey small-margin">Add another Post</a>
            <a href="#" class="re-button re-button--full-width re-button--grey small-margin">Add another Column</a>
          </div>
        </div>

        <div class="create-list-tab-content create-list-tab-content-import" style="display: none;">
          <div class="u-flex small-gutter">
            <div class="small-margin" style="width: 100%;"></div>
            <a href="#" class="re-button re-button--full-width small-margin"><img class="re-button__icon" src="/assets/images/create-list-import-browse-file.svg" /> Browse File</a>
            <div class="small-margin" style="width: 100%;"></div>
          </div>
        </div>

        <div class="create-list-tab-content create-list-tab-content-copy" style="display: none;">
          <textarea class="create-list-copy-textarea" placeholder="Paste here"></textarea>
          <div class="l-button create-list-copy-seperator-chooser" data-dropdown-placement="bottom-start">
            SEPERATE BY
            <div class="create-list-copy-seperator-chooser__seperator">COMMA <img src="/assets/images/create-list-copy-dropdown-arrow.svg" /></div>
          </div>
          <div class="dropdown seperator-dropdown u-flex u-flexCol u-flexJustifyCenter l-dropdown">
            <a href="#" class="active">Comma</a>
            <a href="#">Semicolon</a>
            <a href="#">Space</a>
            <a href="#">Tab</a>
          </div>
        </div>
      </div>
    </div>
  </div>
{% endblock %}

{% block scripts %}
  <script type="text/javascript">
    $(document).ready(function () {
      $('.create-list-tab-button-new').on('click', function (e) {
        e.preventDefault();
        $('.create-list-tab-button').addClass('re-button--grey');
        $('.create-list-tab-button-new').removeClass('re-button--grey');
        $('.create-list-tab-content').hide();
        $('.create-list-tab-content-new').show();
      });

      $('.create-list-tab-button-import').on('click', function (e) {
        e.preventDefault();
        $('.create-list-tab-button').addClass('re-button--grey');
        $('.create-list-tab-button-import').removeClass('re-button--grey');
        $('.create-list-tab-content').hide();
        $('.create-list-tab-content-import').show();
      });

      $('.create-list-tab-button-copy').on('click', function (e) {
        e.preventDefault();
        $('.create-list-tab-button').addClass('re-button--grey');
        $('.create-list-tab-button-copy').removeClass('re-button--grey');
        $('.create-list-tab-content').hide();
        $('.create-list-tab-content-copy').show();
      });
    });
  </script>
{% endblock %}
