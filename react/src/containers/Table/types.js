// @flow

// Models

type Field = string;

export type Row = Array<Field>;

export type Rows = Array<Row>;

export type Table = {
  votes: Array<string>,
  columns: Array<string>,
  rows: Rows
};

export type TableDataWrapper = {
  loading: boolean,
  error: boolean,
  table: Table | false
};

// Reducers

export type TablesState = {
  [tableId: string]: TableDataWrapper
};

// Actions

export type TablesAction =
  | { type: "FETCH_TABLE_REQUEST", payload: { tableId: string } }
  | { type: "FETCH_TABLE_SUCCESS", payload: { tableId: string, table: Table } }
  | { type: "FETCH_TABLE_ERROR", payload: { tableId: string, error: Error } }
  | {
      type: "EDIT_ROW_REQUEST",
      payload: { tableId: string, rowIndex: number, rowData: Row }
    }
  | {
      type: "EDIT_ROW_SUCCESS",
      payload: { tableId: string, rowIndex: number, rowData: Row }
    }
  | {
      type: "EDIT_ROW_ERROR",
      payload: {
        tableId: string,
        rowIndex: number,
        rowData: Row,
        error: Error
      }
    }
  | {
      type: "VOTE_ROW_REQUEST",
      payload: { tableId: string, rowIndex: number }
    }
  | {
      type: "VOTE_ROW_SUCCESS",
      payload: { tableId: string, rowIndex: number }
    }
  | {
      type: "VOTE_ROW_ERROR",
      payload: {
        tableId: string,
        rowIndex: number,
        error: Error
      }
    };
