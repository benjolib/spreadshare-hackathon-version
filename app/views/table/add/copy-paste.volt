{# flash messages #}
{{ flash.output() }}
<div class="addTableCopyPaste__content__main__options">
  {# title #}
  <div class="addTableCopyPaste__content__main__options__item">
  <div class="addTableCopyPaste__content__main__options__item__column">
    <div class="addTableCopyPaste__content__main__options__item__row addTableCopyPaste__content__main__options__item__row--divided">
    <input id="separator" type="hidden" name="separator" value="tab" />
    <p>Paste table content here</p>
    <p id="separator-container">Separate by <span id="separator-select">tab</span><i id="separator-icon"></i></p>
    <div class="dropdown" id="separator-popper">
      <ul>
        <li class="separator-option">Tab</li>
        <li class="separator-option">Comma</li>
        <li class="separator-option">Space</li>
        <li class="separator-option">Semicolon</li>
      </ul>
    </div>
    </div>
    <textarea rows="20" name="data" autofocus></textarea>
    <br />
    <br />
    <div class="layout__content__main__personal__switch">
    <div class="layout__content__main__personal__column">
      <div class="layout__content__main__personal__switch__text">
      <p>Headers included?</p>
      </div>
      <div class="switch">
      <input type="hidden" name="hasHeaders" value="0" />
      <button type="button" class="switch switch--left YSwitch"
        data-name="hasHeaders" value="1">
        Y
      </button>
      <button type="button" class="switch switch--right NSwitch active"
        data-name="hasHeaders" value="0">
        N
      </button>
      </div>
    </div>
    </div>
  </div>
  </div>
</div>
{# buttons #}
<div class="addTableCopyPaste__content__main__buttons">
  <a href="/table/add">Cancel</a>
  <button type="submit">Import pasted Data</button>
</div>

<script type="text/javascript">
  window.addEventListener('load', function () {
  window.initOnOffSwitches();
  });

  document.addEventListener('DOMContentLoaded', function() {
    var showOptions = function(reference, popper, visible='show') {
      if (visible === 'show') {
        popper.classList.add('show');
      } else {
        popper.classList.remove('show');
      }

      new Popper(reference, popper, {
        placement: 'bottom'
      });
    }

    var separatorInput = document.getElementById('separator');
    var separatorText = document.getElementById('separator-select');
    var reference = document.getElementById('separator-container');
    var popper = document.getElementById('separator-popper');
    var options = document.getElementsByClassName('separator-option');

    separatorText.addEventListener('click', function() {
      if (popper.classList.contains('show')) {
        showOptions(reference, popper, 'hide');
      } else {
        showOptions(reference, popper);
      }
    });

    for (var i = 0; i < options.length; i++) {
      options[i].addEventListener('click', function(ev) {
        separatorText.innerText = ev.target.innerText;
        separatorInput.value = ev.target.innerText.toLowerCase();
        popper.classList.remove('show');
      });
    }
  });
</script>
