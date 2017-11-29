// @flow
const cellRenderer = data => (instance, td, row, col, prop, value) => {
  if (value && value.content) {
    td.innerHTML = value.content;
  }
  return td;
};

export default cellRenderer;
