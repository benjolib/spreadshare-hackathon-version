// @flow
import React from "react";
import { renderReactCell, MemoizedReactDomContainers } from "react-lru";
import AddInputCell from "../components/AddInputCell";

const memoizedContainers = new MemoizedReactDomContainers(1000);

const addInputRenderer = data => (instance, td, row, col, prop, value) => {
  renderReactCell({
    memoizedContainers,
    td,
    row,
    col,
    jsx: (
      <AddInputCell
        colIndex={col}
        setupDataGetter={data.setupDataGetter}
        value={value}
      />
    )
  });

  return td;
};

export default addInputRenderer;
