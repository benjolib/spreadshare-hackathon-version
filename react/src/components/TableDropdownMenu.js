// @flow
import React from "react";
import styled from "styled-components";
import { URL } from "../config";
import { addCol } from "../containers/Table/actions";
import type { Columns } from "../containers/Table/types";

const StyledDiv = styled.div`
  position: absolute;
  background: #fff;
  box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.5);
  top: -10px;
  right: 10px;
  height: 200px;
  width: 200px;
  padding: 10px;
  z-index: 1000;
  display: ${props => (props.hide ? "none" : "block")};
  a {
    display: block;
  }
`;

type Props = {
  tableId: string,
  showAdd: Function,
  permission: string,
  addCol: typeof addCol,
  columns: Columns
};

type State = {};

class TableDropdownMenu extends React.Component<Props, State> {
  state: State;

  state = {};

  props: Props;

  addColumn = () => {
    const newTitle = prompt("What is the title of the new column?");

    if (!newTitle) {
      return;
    }

    this.props.addCol(this.props.tableId, newTitle);
  };

  render() {
    return (
      <StyledDiv hide={this.props.hide}>
        <a onClick={this.props.showAdd}>Add new row</a>
        {this.props.permission === "2" &&
          <a onClick={this.addColumn}>Add new column</a>}
        <a href={`${URL}/download/table/3/csv`}>Download as CSV</a>
      </StyledDiv>
    );
  }
}

export default TableDropdownMenu;
