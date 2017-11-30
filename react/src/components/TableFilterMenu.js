// @flow
import React from "react";
import styled from "styled-components";

const StyledDiv = styled.div`
  position: absolute;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
  top: -10px;
  left: ${props => (props.sortShown ? "420px" : "60px")};
  width: 400px;
  overflow: hidden;
  z-index: 1000;
  flex-direction: column;
  display: ${props => (props.hide ? "none" : "flex")};
  table {
    width: 100%;
    select {
      background: none;
      border: none;
    }
    td {
      padding: 4px 0;
    }
  }
`;

const Main = styled.div`
  padding: 10px;
  min-height: 100px;
`;

const Remove = styled.div`
  width: 15px;
  height: 15px;
  background: #6a7d96;
  border-radius: 9999px;
  color: #fff;
  font-size: 10px;
  line-height: 15px;
  margin-top: 2px;
  margin-left: 8px;
  text-align: center;
  cursor: pointer;
`;

const Footer = styled.div`
  background: #f8f7fc;
  margin-top: auto;
  display: flex;
  padding: 10px;
`;

const AddAFilterButton = styled.button`
  border: none;
  cursor: pointer;
  font-weight: 600;
  color: #7d8c9f;
`;

const DeleteButton = styled.button`
  cursor: pointer;
  border: none;
  color: #b7bec8;
  font-weight: 600;
  margin-left: auto;
`;

const ApplyButton = styled.button`
  background: #6a7c94;
  color: #ffffff;
  border: none;
  padding: 4px 24px;
  border-radius: 4px;
  margin-left: 8px;
  cursor: pointer;
`;

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
      <StyledDiv hide={this.props.hide} sortShown={this.props.sortShown}>
        <Main>
          <table>
            <tbody>
              {this.state.filters.map((filter, i) => (
                <tr key={filter.by}>
                  <td>
                    <Remove onClick={() => this.removeFilter(i)}>x</Remove>
                  </td>
                  <td>{i ? "And" : "Where"}</td>
                  <td>
                    <select
                      value={filter.by}
                      onChange={e => this.byChange(e, i)}
                    >
                      <option>{filter.by}</option>
                      {this.props.colHeaders
                        .filter(
                          colHeader => !this.state.usedColHeaders[colHeader]
                        )
                        .map(colHeader => (
                          <option key={colHeader}>{colHeader}</option>
                        ))}
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
              ))}
            </tbody>
          </table>
        </Main>
        <Footer>
          {unusedColHeader && (
            <AddAFilterButton onClick={this.addFilter}>
              Add a filter
            </AddAFilterButton>
          )}
          <DeleteButton onClick={this.deleteFilters}>Delete</DeleteButton>
          <ApplyButton onClick={this.applyFilters}>Apply</ApplyButton>
        </Footer>
      </StyledDiv>
    );
  }
}

export default TableFilterMenu;
