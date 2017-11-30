// @flow
import escapeHtml from "./escapeHtml";

const cellRenderer = data => (instance, td, row, col, prop, value) => {
  if (value && value.link && value.content) {
    td.innerHTML = `<div style="padding: 8px 0;"><a href="${escapeHtml(
      value.link
    )}" target="_blank" style="color:#62b38c;text-decoration: underline;">${escapeHtml(
      value.content
    )}</a></div>`;
  } else if (value && value.content) {
    td.innerHTML = `<div style="padding: 8px 0;">${escapeHtml(
      value.content
    )}</div>`;
  } else {
    td.innerHTML = `<div style="padding: 8px 0;">&nbsp;</div>`;
  }
  return td;
};

export default cellRenderer;
