// @flow
const cellRenderer = data => (instance, td, row, col, prop, value) => {
  td.innerHTML = value.content;
  return td;
};

export default cellRenderer;
