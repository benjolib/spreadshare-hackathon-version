// @flow
import type { Action } from "../../types";
import type { TablesState } from "./types";

const initialState = {};

export const tablesReducer = (
  state: TablesState = initialState,
  action: Action
): TablesState => {
  switch (action.type) {
    case "FETCH_TABLE_REQUEST": {
      return {
        ...state,
        [action.payload.tableId]: {
          loading: true,
          error: false,
          table: false
        }
      };
    }

    case "FETCH_TABLE_SUCCESS": {
      return {
        ...state,
        [action.payload.tableId]: {
          loading: false,
          error: false,
          table: action.payload.table
        }
      };
    }

    case "FETCH_TABLE_ERROR": {
      return {
        ...state,
        [action.payload.tableId]: {
          loading: false,
          error: action.payload.error,
          table: false
        }
      };
    }

    case "EDIT_CELL_REQUEST": {
      // TODO: maybe show loader
      return state;
    }

    case "EDIT_CELL_SUCCESS": {
      // TODO: show message like (success, your edit is now awaiting approval)
      // TODO: if permission is admin edit instantly
      return state;
    }

    case "EDIT_CELL_ERROR": {
      // TODO: show error
      return state;
    }

    case "VOTE_ROW_REQUEST": {
      // TODO: maybe some sort of optimistic update or loader here
      if (!state[action.payload.tableId].table) {
        return state;
      }

      return {
        ...state,
        [action.payload.tableId]: {
          ...state[action.payload.tableId],
          table: {
            ...state[action.payload.tableId].table,
            votes: state[action.payload.tableId].table.votes.map(vote => {
              if (vote.rowId === action.payload.rowId) {
                if (vote.upvoted) {
                  return {
                    ...vote,
                    upvoted: !vote.upvoted,
                    votes: `${Number(vote.votes) - 1}`
                  };
                }
                return {
                  ...vote,
                  upvoted: !vote.upvoted,
                  votes: `${Number(vote.votes) + 1}`
                };
              }
              return vote;
            })
          }
        }
      };
    }

    case "VOTE_ROW_SUCCESS": {
      return state;
    }

    case "VOTE_ROW_ERROR": {
      if (!state[action.payload.tableId].table) {
        return state;
      }

      return {
        ...state,
        [action.payload.tableId]: {
          ...state[action.payload.tableId],
          table: {
            ...state[action.payload.tableId].table,
            votes: state[action.payload.tableId].table.votes.map(vote => {
              if (vote.rowId === action.payload.rowId) {
                if (!vote.upvoted) {
                  return {
                    ...vote,
                    upvoted: !vote.upvoted,
                    votes: `${Number(vote.votes) - 1}`
                  };
                }
                return {
                  ...vote,
                  upvoted: !vote.upvoted,
                  votes: `${Number(vote.votes) + 1}`
                };
              }
              return vote;
            })
          }
        }
      };
    }

    case "ADD_ROW_REQUEST": {
      // TODO: maybe show loader
      return state;
    }

    case "ADD_ROW_SUCCESS": {
      // TODO: show message like (success, your edit is now awaiting approval)
      // TODO: if permission is admin edit instantly
      return state;
    }

    case "ADD_ROW_ERROR": {
      // TODO: show error
      return state;
    }

    case "ADD_COL_REQUEST": {
      // TODO: maybe show loader
      return state;
    }

    case "ADD_COL_SUCCESS": {
      // no approval needed since this is an admin action
      // TODO: we need a column id back or something and cell ids
      return {
        ...state,
        [action.payload.tableId]: {
          ...state[action.payload.tableId],
          table: {
            ...state[action.payload.tableId].table,
            columns: [
              ...state[action.payload.tableId].table.columns,
              {
                id: "REPLACE",
                title: action.payload.title
              }
            ],
            rows: state[action.payload.tableId].table.rows.map(row => ({
              ...row,
              content: [
                ...row.content,
                {
                  id: "REPLACE",
                  content: ""
                }
              ]
            }))
          }
        }
      };
    }

    case "ADD_COL_ERROR": {
      // TODO: show error
      return state;
    }

    default: {
      return state;
    }
  }
};
