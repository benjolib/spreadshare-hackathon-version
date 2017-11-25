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

    case "EDIT_ROW_REQUEST": {
      // TODO: maybe some sort of optimistic update or loader here
      return state;
    }

    case "EDIT_ROW_SUCCESS": {
      console.log(action.payload);

      if (!state[action.payload.tableId].table) {
        return state;
      }

      // TODO: find a better way to do this (which still doesn't mutate), probably a util function
      return {
        ...state,
        [action.payload.tableId]: {
          ...state[action.payload.tableId],
          table: {
            ...state[action.payload.tableId].table,
            rows: [
              ...state[action.payload.tableId].table.rows.slice(
                0,
                action.payload.rowIndex
              ),
              action.payload.rowData,
              ...state[action.payload.tableId].table.rows.slice(
                action.payload.rowIndex + 1
              )
            ]
          }
        }
      };
    }

    case "EDIT_ROW_ERROR": {
      // TODO: maybe show error toast message or something
      return state;
    }

    case "VOTE_ROW_REQUEST": {
      // TODO: maybe some sort of optimistic update or loader here
      return state;
    }

    case "VOTE_ROW_SUCCESS": {
      console.log(action.payload);

      if (!state[action.payload.tableId].table) {
        return state;
      }

      // TODO: find a better way to do this (which still doesn't mutate), probably a util function
      return {
        ...state,
        [action.payload.tableId]: {
          ...state[action.payload.tableId],
          table: {
            ...state[action.payload.tableId].table,
            votes: [
              ...state[action.payload.tableId].table.votes.slice(
                0,
                action.payload.rowIndex
              ),
              (Number(
                state[action.payload.tableId].table.votes[
                  action.payload.rowIndex
                ]
              ) + 1).toString(),
              ...state[action.payload.tableId].table.votes.slice(
                action.payload.rowIndex + 1
              )
            ]
          }
        }
      };
    }

    case "VOTE_ROW_ERROR": {
      // TODO: maybe show error toast message or something
      return state;
    }

    default: {
      return state;
    }
  }
};
