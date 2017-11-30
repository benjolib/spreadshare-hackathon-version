// @flow
import React from "react";
import styled from "styled-components";

const StyledDiv = styled.div`
  margin: 0 4px;
  height: 40px;
  background: #f2f2f8;
  width: 400px;
  display: flex;
  border-radius: 3px;
  & > button {
    border: 0;
    padding: 0;
    border-radius: 3px;
    width: 40px;
    height: 40px;
    flex-shrink: 0;
    background: #f2f2f8;
  }
  & > input {
    border: 0;
    padding: 0;
    padding-top: 4px;
    flex-grow: 1;
    border-radius: 3px;
    height: 40px;
    font-size: 16px;
    width: 100%;
    outline: none;
  }
`;

type Props = {
  onChange: (e: Event) => void
};

class TableAdminEditInput extends React.Component<Props> {
  state = {
    value: ""
  };

  editCell = e => {
    this.props.editCell(
      this.props.tableId,
      this.props.selectedCell.rowId,
      this.props.selectedCell.id,
      {
        ...this.props.selectedCell,
        content: this.state.value
      },
      this.props.permission
    );
  };

  componentWillReceiveProps(nextProps) {
    if (nextProps.selectedCell.id !== this.props.selectedCell.id) {
      this.setState({
        value: nextProps.selectedCell.content
      });
      console.log(this.nameInput);
      setTimeout(() => {
        this.nameInput.focus();
      }, 0);
    }
  }

  onChange = e => {
    this.setState({
      value: e.target.value
    });
  };

  handleKeyPress = e => {
    if (e.key === "Enter") {
      this.editCell();
    }
  };

  render() {
    return (
      <StyledDiv>
        <button>
          <img src="/assets/icons/search.svg" alt="" />
        </button>
        <input
          type="text"
          ref={input => {
            this.nameInput = input;
          }}
          placeholder="Edit Cell Content"
          value={this.state.value}
          onChange={this.onChange}
          onKeyPress={this.handleKeyPress}
        />
      </StyledDiv>
    );
  }
}

export default TableAdminEditInput;
