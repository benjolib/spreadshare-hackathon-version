// @flow
import React from "react";
import type { TableDataWrapper } from "../containers/Table/types";
// import styled from "styled-components";

type Sortings = Array<{
  by: string,
  direction: "ascending" | "descending"
}>;

type Props = {
  onApply: Sortings => void,
  data: TableDataWrapper
};

type State = {
  appliedSortings: Sortings,
  pendingSortings: Sortings
};

class TableSortingMenu extends React.Component<Props, State> {
  state: State;

  state = {
    appliedSortings: [],
    pendingSortings: []
  };

  props: Props;

  apply = () => {
    this.setState({
      appliedSortings: this.state.pendingSortings
    });
  };

  addSorting = () => {
    this.setState({
      pendingSortings: {
        by: this.props.data.columns[0],
        direction: "ascending"
      }
    });
  };

  render() {
    return (
      <div>
        {this.state.pendingSortings.map(sorting =>
          <div>
            Sort by {sorting.by} {sorting.direction}
          </div>
        )}
        <div>
          <span onClick={this.addSorting}>Add a sorting</span> <a>Delete</a>{" "}
          <button onClick={this.apply}>Apply</button>
        </div>
      </div>
    );
  }
}

export default TableSortingMenu;
