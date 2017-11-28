// @flow
import React from "react";
import styled from "styled-components";

const StyledDiv = styled.div`
  text-align: center;
  height: 100%;
  display: flex;
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
        <button onClick={this.props.hideAdd}>x</button>{" "}
        <button onClick={() => this.props.addRow(this.props.colIndex - 1)}>
          Add
        </button>
      </StyledDiv>
    );
  }
}

export default AddButtonCell;
