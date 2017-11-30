// @flow
import React from "react";
import styled from "styled-components";

const StyledDiv = styled.div`
  text-align: center;
  height: 100%;
  display: flex;
  button {
    background: #a1dab2;
    color: #fff;
    border: none;
    padding: 4px 8px;
    border-radius: 6px;
    margin-top: 8px;
    cursor: pointer;
  }
  div {
    width: 15px;
    height: 15px;
    background: #6a7d96;
    border-radius: 9999px;
    color: #fff;
    font-size: 10px;
    line-height: 15px;
    margin-top: 14px;
    margin-left: 8px;
    cursor: pointer;
  }
`;

type Props = {
  colIndex: number,
  addRow: (colIndex: number) => void,
  hideAdd: Function
};

class AddButtonCell extends React.Component<Props> {
  props: Props;
  render() {
    return (
      <StyledDiv>
        <button onClick={() => this.props.addRow(this.props.colIndex - 1)}>
          ADD
        </button>
        <div onClick={this.props.hideAdd}>x</div>
      </StyledDiv>
    );
  }
}

export default AddButtonCell;
