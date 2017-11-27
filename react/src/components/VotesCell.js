// @flow
import React from "react";
import styled from "styled-components";

const StyledDiv = styled.div`
  text-align: center;
  height: 100%;
`;

type Props = {
  rowId: string,
  votes: string,
  upvoted: boolean,
  voteRow: (rowId: string) => void
};

class VotesCell extends React.Component<Props> {
  props: Props;
  render() {
    return (
      <StyledDiv onClick={() => this.props.voteRow(this.props.rowId)}>
        {this.props.votes}
        {this.props.upvoted && "^"}
      </StyledDiv>
    );
  }
}

export default VotesCell;
