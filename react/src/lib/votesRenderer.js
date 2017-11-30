// @flow
import React from "react";
import { renderReactCell, MemoizedReactDomContainers } from "react-lru";
import VotesCell from "../components/VotesCell";

const memoizedContainers = new MemoizedReactDomContainers(1000);

const votesRenderer = data => (instance, td, row, col, prop, value) => {
  renderReactCell({
    memoizedContainers,
    td,
    row,
    col,
    jsx: (
      <VotesCell
        rowId={value.rowId}
        votes={value.votes}
        upvoted={value.upvoted}
        voteRow={data.voteRow}
        permission={data.permission}
      />
    )
  });

  return td;
};

export default votesRenderer;
