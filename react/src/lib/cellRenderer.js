// @flow
const cellRenderer = data => (instance, td, row, col, prop, value) => {
  if (value && value.content) {
    td.innerHTML = `<div style="padding: 8px 0;">${value.content}</div>`;
  } else {
    td.innerHTML = `<div style="padding: 8px 0;">&nbsp;</div>`;
  }
  return td;
};

export default cellRenderer;
