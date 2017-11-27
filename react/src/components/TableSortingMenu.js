// @flow
import React from "react";
// import styled from "styled-components";

export type Sortings = Array<{
  by: string,
  direction: "ascending" | "descending"
}>;

type Props = {
  onApply: Sortings => void,
  colHeaders: Array<string>
  // appliedSortings: Sortings
};

type State = {
  sortings: Sortings
};

class TableSortingMenu extends React.Component<Props, State> {
  state: State;

  state = {
    sortings: []
  };

  props: Props;

  applySortings = () => {
    this.props.onApply(this.state.sortings);
  };

  deleteSortings = () => {
    this.props.onApply([]);
  };

  addSorting = () => {
    this.setState({
      sortings: [
        ...this.state.sortings,
        {
          by: this.props.colHeaders[0],
          direction: "ascending"
        }
      ]
    });
  };

  removeSorting = i => {
    this.setState({
      sortings: [
        ...this.state.sortings.slice(0, i),
        ...this.state.sortings.slice(i + 1)
      ]
    });
  };

  byChange = (e, i) => {
    this.setState({
      sortings: [
        ...this.state.sortings.slice(0, i),
        {
          ...this.state.sortings[i],
          by: e.target.value
        },
        ...this.state.sortings.slice(i + 1)
      ]
    });
  };

  directionChange = (e, i) => {
    this.setState({
      sortings: [
        ...this.state.sortings.slice(0, i),
        {
          ...this.state.sortings[i],
          direction: e.target.value
        },
        ...this.state.sortings.slice(i + 1)
      ]
    });
  };

  render() {
    return (
      <div>
        <table>
          <tbody>
            {this.state.sortings.map((sorting, i) =>
              <tr key={sorting.by}>
                <td>
                  <button onClick={() => this.removeSorting(i)}>x</button>
                </td>
                <td>
                  {i ? "Then" : "Sort by"}
                </td>
                <td>
                  <select
                    value={sorting.by}
                    onChange={e => this.byChange(e, i)}
                  >
                    {this.props.colHeaders.map(colHeader =>
                      <option key={colHeader}>
                        {colHeader}
                      </option>
                    )}
                  </select>
                </td>
                <td>
                  <select
                    value={sorting.direction}
                    onChange={e => this.directionChange(e, i)}
                  >
                    <option>ascending</option>
                    <option>descending</option>
                  </select>
                </td>
              </tr>
            )}
          </tbody>
        </table>
        <div>
          <button onClick={this.addSorting}>Add a sorting</button>
          <button onClick={this.deleteSortings}>Delete</button>
          <button onClick={this.applySortings}>Apply</button>
        </div>
      </div>
    );
  }
}

export default TableSortingMenu;
