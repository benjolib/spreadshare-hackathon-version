// @flow
import React from "react";

export type Sortings = Array<{
  by: string,
  direction: "ascending" | "descending"
}>;

type Props = {
  onApply: Sortings => void,
  colHeaders: Array<string>
};

type State = {
  usedColHeaders: {
    [string]: string
  },
  sortings: Sortings
};

class TableSortingMenu extends React.Component<Props, State> {
  state: State;

  state = {
    usedColHeaders: {},
    sortings: []
  };

  getUnusedColHeader = () =>
    this.props.colHeaders.find(
      colHeader => !this.state.usedColHeaders[colHeader]
    );

  props: Props;

  applySortings = () => {
    this.props.onApply(this.state.sortings);
  };

  deleteSortings = () => {
    this.setState({
      usedColHeaders: {},
      sortings: []
    });
    this.props.onApply([]);
  };

  addSorting = () => {
    const by = this.getUnusedColHeader();

    if (!by) {
      return;
    }

    this.setState({
      usedColHeaders: {
        ...this.state.usedColHeaders,
        [by]: by
      },
      sortings: [
        ...this.state.sortings,
        {
          by,
          direction: "ascending"
        }
      ]
    });
  };

  removeSorting = i => {
    this.setState({
      usedColHeaders: {
        ...this.state.usedColHeaders,
        [this.state.sortings[i].by]: undefined
      },
      sortings: [
        ...this.state.sortings.slice(0, i),
        ...this.state.sortings.slice(i + 1)
      ]
    });
  };

  byChange = (e, i) => {
    this.setState({
      usedColHeaders: {
        ...this.state.usedColHeaders,
        [this.state.sortings[i].by]: undefined,
        [e.target.value]: e.target.value
      },
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
    const unusedColHeader = this.getUnusedColHeader();
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
                    <option>
                      {sorting.by}
                    </option>
                    {this.props.colHeaders
                      .filter(
                        colHeader => !this.state.usedColHeaders[colHeader]
                      )
                      .map(colHeader =>
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
          {unusedColHeader &&
            <button onClick={this.addSorting}>Add a sorting</button>}
          <button onClick={this.deleteSortings}>Delete</button>
          <button onClick={this.applySortings}>Apply</button>
        </div>
      </div>
    );
  }
}

export default TableSortingMenu;
