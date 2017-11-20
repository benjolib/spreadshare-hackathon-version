// @flow

// Models

type Field = string;

export type Table = {
  votes: Array<number>,
  rows: Array<Array<Field>>
};

export type TableWrapper = {
  loading: boolean,
  error: boolean,
  table: Table | false
};

// Reducers

export type TablesState = {
  [tableId: string]: TableWrapper
};

// Actions

export type TablesAction =
  | { type: "FETCH_TABLE_REQUEST", payload: { tableId: string } }
  | { type: "FETCH_TABLE_SUCCESS", payload: { tableId: string, table: Table } }
  | { type: "FETCH_TABLE_ERROR", payload: { tableId: string, error: Error } };
