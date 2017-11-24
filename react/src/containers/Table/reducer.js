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
      // TODO: maybe some sort of optimistic update or loader here
      return state;
    }

    case "EDIT_CELL_SUCCESS": {
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
                action.payload.row
              ),
              [
                ...state[action.payload.tableId].table.rows[
                  action.payload.row
                ].slice(0, action.payload.col),
                action.payload.value,
                ...state[action.payload.tableId].table.rows[
                  action.payload.row
                ].slice(action.payload.col + 1)
              ],
              ...state[action.payload.tableId].table.rows.slice(
                action.payload.row + 1
              )
            ]
          }
        }
      };
    }

    case "EDIT_CELL_ERROR": {
      // TODO: maybe show error toast message or something
      return state;
    }

    default: {
      return state;
    }
  }
};
