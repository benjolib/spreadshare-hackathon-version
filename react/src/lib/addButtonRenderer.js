// @flow
import React from "react";
import { renderReactCell, MemoizedReactDomContainers } from "react-lru";
import AddButtonCell from "../components/AddButtonCell";

const memoizedContainers = new MemoizedReactDomContainers(1000);

const addButtonRenderer = data => (instance, td, row, col, prop, value) => {
  renderReactCell({
    memoizedContainers,
    td,
    row,
    col,
    jsx: (
      <AddButtonCell
        colIndex={col}
        addRow={data.addRow}
        hideAdd={data.hideAdd}
      />
    )
  });

  return td;
};

export default addButtonRenderer;
