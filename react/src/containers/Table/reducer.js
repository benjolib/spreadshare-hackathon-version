// @flow
import type { Action } from "../../types";
import type { TablesState } from "./types";
import dummyTable from "./dummyTable";

const initialState = {
  exampleTableId123: {
    loading: false,
    error: false,
    table: dummyTable
  }
};

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

    default: {
      return state;
    }
  }
};
