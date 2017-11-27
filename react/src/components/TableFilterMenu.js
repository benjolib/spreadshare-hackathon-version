// @flow
import React from "react";

export type Filters = Array<{
  by: string,
  direction: "ascending" | "descending"
}>;

type Props = {
  onApply: Filters => void,
  colHeaders: Array<string>
};

type State = {
  usedColHeaders: {
    [string]: string
  },
  filters: Filters
};

class TableFilterMenu extends React.Component<Props, State> {
  state: State;

  state = {
    usedColHeaders: {},
    filters: []
  };

  getUnusedColHeader = () =>
    this.props.colHeaders.find(
      colHeader => !this.state.usedColHeaders[colHeader]
    );

  props: Props;

  applyFilters = () => {
    this.props.onApply(this.state.filters);
  };

  deleteFilters = () => {
    this.setState({
      usedColHeaders: {},
      filters: []
    });
    this.props.onApply([]);
  };

  addFilter = () => {
    const by = this.getUnusedColHeader();

    if (!by) {
      return;
    }

    this.setState({
      usedColHeaders: {
        ...this.state.usedColHeaders,
        [by]: by
      },
      filters: [
        ...this.state.filters,
        {
          by,
          direction: "ascending"
        }
      ]
    });
  };

  removeFilter = i => {
    this.setState({
      usedColHeaders: {
        ...this.state.usedColHeaders,
        [this.state.filters[i].by]: undefined
      },
      filters: [
        ...this.state.filters.slice(0, i),
        ...this.state.filters.slice(i + 1)
      ]
    });
  };

  byChange = (e, i) => {
    this.setState({
      usedColHeaders: {
        ...this.state.usedColHeaders,
        [this.state.filters[i].by]: undefined,
        [e.target.value]: e.target.value
      },
      filters: [
        ...this.state.filters.slice(0, i),
        {
          ...this.state.filters[i],
          by: e.target.value
        },
        ...this.state.filters.slice(i + 1)
      ]
    });
  };

  directionChange = (e, i) => {
    this.setState({
      filters: [
        ...this.state.filters.slice(0, i),
        {
          ...this.state.filters[i],
          direction: e.target.value
        },
        ...this.state.filters.slice(i + 1)
      ]
    });
  };

  render() {
    const unusedColHeader = this.getUnusedColHeader();
    return (
      <div>
        <table>
          <tbody>
            {this.state.filters.map((filter, i) =>
              <tr key={filter.by}>
                <td>
                  <button onClick={() => this.removeFilter(i)}>x</button>
                </td>
                <td>
                  {i ? "Where" : "And"}
                </td>
                <td>
                  <select value={filter.by} onChange={e => this.byChange(e, i)}>
                    <option>
                      {filter.by}
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
                    value={filter.direction}
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
            <button onClick={this.addFilter}>Add a filter</button>}
          <button onClick={this.deleteFilters}>Delete</button>
          <button onClick={this.applyFilters}>Apply</button>
        </div>
      </div>
    );
  }
}

export default TableFilterMenu;
