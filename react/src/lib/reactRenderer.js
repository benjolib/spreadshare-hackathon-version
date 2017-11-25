// @flow
import React from "react";
import { renderReactCell, MemoizedReactDomContainers } from "react-lru";
import ReactCell from "../components/ReactCell";

const memoizedContainers = new MemoizedReactDomContainers(20);

function reactRenderer(instance, td, row, col, prop, value) {
  renderReactCell({
    memoizedContainers,
    td,
    row,
    col,
    jsx: <ReactCell row={row} />
  });

  return td;
}

export default reactRenderer;
