// @flow

// Models

type Field = string;

export type Rows = Array<Array<Field>>;

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
      type: "EDIT_CELL_REQUEST",
      payload: { tableId: string, row: number, col: number, value: string }
    }
  | {
      type: "EDIT_CELL_SUCCESS",
      payload: { tableId: string, row: number, col: number, value: string }
    }
  | {
      type: "EDIT_CELL_ERROR",
      payload: {
        tableId: string,
        row: number,
        col: number,
        value: string,
        error: Error
      }
    };
