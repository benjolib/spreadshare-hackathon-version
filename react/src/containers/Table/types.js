// @flow

// Models

export type Cell = {
  id: string,
  content: string,
  link: string | null
};

export type Row = {
  id: string,
  content: Array<Cell>
};

export type Vote = {
  rowId: string,
  votes: string,
  upvoted: boolean
};

export type RowWithVote = {
  id: string,
  content: Array<Cell | Vote>
};

export type RowsWithVotes = Array<RowWithVote>;

export type Votes = Array<Vote>;
export type Columns = Array<string>;
export type Rows = Array<Row>;

export type Table = {
  votes: Array<Vote>,
  columns: Array<string>,
  rows: Array<Row>
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
      payload: {
        tableId: string,
        cellId: string,
        cell: Cell
      }
    }
  | {
      type: "EDIT_CELL_SUCCESS",
      payload: {
        tableId: string,
        cellId: string,
        cell: Cell
      }
    }
  | {
      type: "EDIT_CELL_ERROR",
      payload: {
        tableId: string,
        cellId: string,
        cell: Cell,
        error: Error
      }
    }
  | {
      type: "VOTE_ROW_REQUEST",
      payload: { tableId: string, rowId: string }
    }
  | {
      type: "VOTE_ROW_SUCCESS",
      payload: { tableId: string, rowId: string }
    }
  | {
      type: "VOTE_ROW_ERROR",
      payload: {
        tableId: string,
        rowId: string,
        error: Error
      }
    }
  | {
      type: "ADD_ROW_REQUEST",
      payload: { tableId: string, row: Array<string> }
    }
  | {
      type: "ADD_ROW_SUCCESS",
      payload: { tableId: string, row: Array<string> }
    }
  | {
      type: "ADD_ROW_ERROR",
      payload: {
        tableId: string,
        row: Array<string>,
        error: Error
      }
    };
