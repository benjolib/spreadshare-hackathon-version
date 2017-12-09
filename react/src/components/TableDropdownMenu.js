// @flow
import React from "react";
import swal from "sweetalert2";
import styled from "styled-components";
import { URL } from "../config";
import { addCol } from "../containers/Table/actions";

const StyledDiv = styled.div`
  position: absolute;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
  top: -10px;
  right: 10px;
  width: 200px;
  z-index: 1000;
  overflow: hidden;
  display: ${props => (props.hide ? "none" : "block")};
  a {
    display: block;
    padding: 8px 16px !important;
    color: #a8afbb;
    cursor: pointer;
    text-decoration: none;
    &:hover {
      background: #f3f3f3;
    }
  }
`;

type Props = {
  tableId: string,
  showAdd: Function,
  permission: string,
  addCol: typeof addCol
};

type State = {};

class TableDropdownMenu extends React.Component<Props, State> {
  state: State;

  state = {};

  props: Props;

  addColumn = () => {
    swal({
      title: "What is the title of the new column?",
      input: "text",
      text: "Please type the new column title.",
      showCancelButton: true,
      showLoaderOnConfirm: true,
      preConfirm: newValue => {
        if (typeof newValue !== "string") {
          return;
        }

        return this.props.addCol(
          this.props.tableId,
          newValue,
          this.props.permission
        );
      }
    })
      .then(result => {
        if (!result.value) {
          return;
        }
        if (this.props.permission === "1") {
          swal(
            "Success!",
            "The request to add this column is awaiting approval.",
            "success"
          );
        } else if (this.props.permission === "2") {
          swal({
            title: "Success!",
            type: "success",
            timer: 650,
            showConfirmButton: false
          });
        }
      })
      .catch(() => {
        swal("Oops", "Something has gone wrong!", "error");
      });
  };

  render() {
    return (
      <StyledDiv hide={this.props.hide}>
        {this.props.permission !== "0" && (
          <a onClick={this.props.showAdd}>Add new row</a>
        )}
        {this.props.permission === "2" && (
          <a onClick={this.addColumn}>Add new column</a>
        )}
        <a href={`${URL}/download/table/3/csv`}>Download as CSV</a>
      </StyledDiv>
    );
  }
}

export default TableDropdownMenu;
