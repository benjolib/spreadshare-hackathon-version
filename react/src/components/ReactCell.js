// @flow
import React from "react";
import styled from "styled-components";

const StyledDiv = styled.div`
  text-align: center;
  height: 100%;
`;

type Props = {
  row: number,
  col: number,
  data: {
    vote: (row: number) => void,
    searchedRows: Array<Array<string>>
  }
};

class ReactCell extends React.Component<Props> {
  props: Props;
  render() {
    return (
      <StyledDiv onClick={() => this.props.data.vote(this.props.row)}>
        {this.props.data.searchedRows[this.props.row][this.props.col]}
      </StyledDiv>
    );
  }
}

export default ReactCell;
