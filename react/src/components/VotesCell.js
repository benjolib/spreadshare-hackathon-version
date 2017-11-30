// @flow
import React from "react";
import styled from "styled-components";
import UpvoteIcon from "./icons/UpvoteIcon";
import { URL } from "../config";

const StyledDiv = styled.div`
  text-align: center;
  height: 100%;
  background: #f3f2f8;
  font-size: 10px;
  width: 45px;
  margin: 8px 8px;
  height: 20px;
  border-radius: 5px;
  cursor: pointer;
  ${props =>
    props.upvoted &&
    `
    background: #6a7c94;
    color: #FFFFFF;
  `};
`;

type Props = {
  rowId: string,
  votes: string,
  upvoted: boolean,
  voteRow: (rowId: string) => void,
  permission: string
};

class VotesCell extends React.Component<Props> {
  props: Props;
  render() {
    return (
      <StyledDiv
        upvoted={this.props.upvoted}
        onClick={() => {
          if (this.props.permission === "0") {
            window.open(`${URL}/login`);
            return;
          }
          this.props.voteRow(this.props.rowId);
        }}
      >
        <UpvoteIcon />
        {this.props.votes}
      </StyledDiv>
    );
  }
}

export default VotesCell;
