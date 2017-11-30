// @flow
const cellRenderer = data => (instance, td, row, col, prop, value) => {
  if (value && value.link && value.content) {
    td.innerHTML = `<div style="padding: 8px 0;text-decoration: underline;color:#62b38c;cursor: pointer;">${value.content}</div>`;
  } else if (value && value.content) {
    td.innerHTML = `<div style="padding: 8px 0;">${value.content}</div>`;
  } else {
    td.innerHTML = `<div style="padding: 8px 0;">&nbsp;</div>`;
  }
  return td;
};

export default cellRenderer;
