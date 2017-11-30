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
      if (action.payload.permission === "2") {
        return {
          ...state,
          [action.payload.tableId]: {
            ...state[action.payload.tableId],
            table: {
              ...state[action.payload.tableId].table,
              rows: state[action.payload.tableId].table.rows.map(
                row =>
                  row.id === action.payload.rowId
                    ? {
                        ...row,
                        content: row.content.map(
                          cell =>
                            cell.id === action.payload.cellId
                              ? {
                                  ...cell,
                                  content: action.payload.cell.content,
                                  link: action.payload.cell.link
                                }
                              : cell
                        )
                      }
                    : row
              )
            }
          }
        };
      }
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

    case "ADD_ROW_REQUEST": {
      // TODO: maybe show loader
      return state;
    }

    case "ADD_ROW_SUCCESS": {
      if (action.payload.permission === "2") {
        console.log(state);
        console.log(action);
        const blah = {
          ...state,
          [action.payload.tableId]: {
            ...state[action.payload.tableId],
            table: {
              ...state[action.payload.tableId].table,
              votes: [
                ...state[action.payload.tableId].table.votes,
                {
                  votes: "0",
                  upvoted: false,
                  rowId: action.payload.response.id
                }
              ],
              rows: [
                ...state[action.payload.tableId].table.rows,
                {
                  id: action.payload.response.id,
                  content: action.payload.response.cells
                }
              ]
            }
          }
        };
        console.log(blah);
        return blah;
      }
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
      if (action.payload.permission === "2") {
        return {
          ...state,
          [action.payload.tableId]: {
            ...state[action.payload.tableId],
            table: {
              ...state[action.payload.tableId].table,
              columns: [
                ...state[action.payload.tableId].table.columns,
                {
                  id: action.payload.response.id,
                  title: action.payload.title
                }
              ],
              rows: state[action.payload.tableId].table.rows.map(row => ({
                ...row,
                content: [
                  ...row.content,
                  {
                    id: action.payload.response.cells.find(
                      cell => cell.rowId === row.id
                    ).id,
                    content: "",
                    link: null
                  }
                ]
              }))
            }
          }
        };
      }
      return state;
    }

    case "ADD_COL_ERROR": {
      // TODO: show error
      return state;
    }

    case "EDIT_COL_REQUEST": {
      // TODO: maybe show loader
      return state;
    }

    case "EDIT_COL_SUCCESS": {
      // no approval needed since this is an admin action
      // TODO: we need a column id back or something and cell ids
      if (action.payload.permission === "2") {
        return {
          ...state,
          [action.payload.tableId]: {
            ...state[action.payload.tableId],
            table: {
              ...state[action.payload.tableId].table,
              columns: state[action.payload.tableId].table.columns.map(
                col =>
                  col.id === action.payload.colId
                    ? {
                        ...col,
                        title: action.payload.title
                      }
                    : col
              )
            }
          }
        };
      }
      return state;
    }

    case "EDIT_COL_ERROR": {
      // TODO: show error
      return state;
    }

    default: {
      return state;
    }
  }
};
