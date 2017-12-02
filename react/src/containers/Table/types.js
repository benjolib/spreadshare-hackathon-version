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

export type Column = {
  id: string,
  title: string
};

export type RowsWithVotes = Array<RowWithVote>;

export type Votes = Array<Vote>;
export type Columns = Array<Column>;
export type Rows = Array<Row>;

export type Table = {
  votes: Votes,
  columns: Columns,
  rows: Rows,
  fixedColumnsLeft: number,
  fixedRowsTop: number
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
        cell: Cell,
        permission: string
      }
    }
  | {
      type: "EDIT_CELL_SUCCESS",
      payload: {
        tableId: string,
        cellId: string,
        cell: Cell,
        permission: string
      }
    }
  | {
      type: "EDIT_CELL_ERROR",
      payload: {
        tableId: string,
        cellId: string,
        cell: Cell,
        permission: string,
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
      payload: {
        tableId: string,
        rowData: Array<string>,
        permission: string
      }
    }
  | {
      type: "ADD_ROW_SUCCESS",
      payload: {
        tableId: string,
        rowData: Array<string>,
        permission: string
      }
    }
  | {
      type: "ADD_ROW_ERROR",
      payload: {
        tableId: string,
        rowData: Array<string>,
        permission: string,
        error: Error
      }
    }
  | {
      type: "ADD_COL_REQUEST",
      payload: {
        tableId: string,
        permission: string,
        title: string
      }
    }
  | {
      type: "ADD_COL_SUCCESS",
      payload: {
        tableId: string,
        permission: string,
        title: string
      }
    }
  | {
      type: "ADD_COL_ERROR",
      payload: {
        tableId: string,
        permission: string,
        title: string,
        error: Error
      }
    }
  | {
      type: "EDIT_COL_REQUEST",
      payload: {
        tableId: string,
        colId: string,
        title: string,
        permission: string
      }
    }
  | {
      type: "EDIT_COL_SUCCESS",
      payload: {
        tableId: string,
        colId: string,
        title: string,
        permission: string
      }
    }
  | {
      type: "EDIT_COL_ERROR",
      payload: {
        tableId: string,
        colId: string,
        title: string,
        permission: string,
        error: Error
      }
    };
