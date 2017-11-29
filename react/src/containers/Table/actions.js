// @flow
import type { Dispatch, Action, ThunkAction } from "../../types";
import type { Table, Row, Cell } from "./types";
import { fetchDataApi, saveDataApi } from "../../api";
import dummyTable from "./dummyTable";

// FETCH TABLE ACTIONS

export const fetchTableRequest = (tableId: string): Action => ({
  type: "FETCH_TABLE_REQUEST",
  payload: {
    tableId
  }
});

export const fetchTableSuccess = (tableId: string, table: Table): Action => ({
  type: "FETCH_TABLE_SUCCESS",
  payload: {
    tableId,
    table
  }
});

export const fetchTableError = (tableId: string, error: Error): Action => ({
  type: "FETCH_TABLE_ERROR",
  payload: {
    tableId,
    error
  }
});

// thunk

export const fetchTable = (tableId: string): ThunkAction => (
  dispatch: Dispatch
) => {
  dispatch(fetchTableRequest(tableId));
  if (process.env.NODE_ENV === "production") {
    fetchDataApi(
      `table/${tableId}`
    ).then(({ error, data }: { error: Error, data: Table }) => {
      if (error) {
        dispatch(fetchTableError(tableId, new Error(error)));
        return;
      }

      dispatch(fetchTableSuccess(tableId, data));
    });
  } else {
    setTimeout(() => {
      dispatch(fetchTableSuccess(tableId, dummyTable));
    }, 500);
  }
};

// EDIT CELL ACTIONS

export const editCellRequest = (
  tableId: string,
  rowId: string,
  cellId: string,
  cell: Cell
): Action => ({
  type: "EDIT_CELL_REQUEST",
  payload: {
    tableId,
    rowId,
    cellId,
    cell
  }
});

export const editCellSuccess = (
  tableId: string,
  rowId: string,
  cellId: string,
  cell: Cell
): Action => ({
  type: "EDIT_CELL_SUCCESS",
  payload: {
    tableId,
    rowId,
    cellId,
    cell
  }
});

export const editCellError = (
  tableId: string,
  rowId: string,
  cellId: string,
  cell: Cell,
  error: Error
): Action => ({
  type: "EDIT_CELL_ERROR",
  payload: {
    tableId,
    rowId,
    cellId,
    cell,
    error
  }
});

// thunk

export const editCell = (
  tableId: string,
  rowId: string,
  cellId: string,
  cell: Cell
): ThunkAction => (dispatch: Dispatch) => {
  dispatch(editCellRequest(tableId, rowId, cellId, cell));
  if (process.env.NODE_ENV === "production") {
    saveDataApi(`edit-cell/${tableId}`, {
      rowId,
      cellId,
      cell
    }).then(({ error }: { error: Error }) => {
      if (error) {
        dispatch(editCellError(tableId, rowId, cellId, cell, new Error(error)));
        return;
      }

      dispatch(editCellSuccess(tableId, rowId, cellId, cell));
    });
  } else {
    setTimeout(() => {
      dispatch(editCellSuccess(tableId, rowId, cellId, cell));
    }, 500);
  }
};

// VOTE ROW ACTIONS

export const voteRowRequest = (tableId: string, rowId: string): Action => ({
  type: "VOTE_ROW_REQUEST",
  payload: {
    tableId,
    rowId
  }
});

export const voteRowSuccess = (tableId: string, rowId: string): Action => ({
  type: "VOTE_ROW_SUCCESS",
  payload: {
    tableId,
    rowId
  }
});

export const voteRowError = (
  tableId: string,
  rowId: string,
  error: Error
): Action => ({
  type: "VOTE_ROW_ERROR",
  payload: {
    tableId,
    rowId,
    error
  }
});

// thunk

export const voteRow = (tableId: string, rowId: string): ThunkAction => (
  dispatch: Dispatch
) => {
  dispatch(voteRowRequest(tableId, rowId));
  if (process.env.NODE_ENV === "production") {
    saveDataApi(`vote-row/${tableId}`, {
      rowId
    }).then(({ error }: { error: Error }) => {
      if (error) {
        dispatch(voteRowError(tableId, rowId, new Error(error)));
        return;
      }

      dispatch(voteRowSuccess(tableId, rowId));
    });
  } else {
    setTimeout(() => {
      dispatch(voteRowSuccess(tableId, rowId));
    }, 500);
  }
};

// ADD ROW ACTIONS

export const addRowRequest = (
  tableId: string,
  rowData: Array<string>,
  insertAfterId: string
): Action => ({
  type: "ADD_ROW_REQUEST",
  payload: {
    tableId,
    rowData,
    insertAfterId
  }
});

export const addRowSuccess = (
  tableId: string,
  rowData: Array<string>,
  insertAfterId: string
): Action => ({
  type: "ADD_ROW_SUCCESS",
  payload: {
    tableId,
    rowData,
    insertAfterId
  }
});

export const addRowError = (
  tableId: string,
  rowData: Array<string>,
  insertAfterId: string,
  error: Error
): Action => ({
  type: "ADD_ROW_ERROR",
  payload: {
    tableId,
    rowData,
    insertAfterId,
    error
  }
});

// thunk

export const addRow = (
  tableId: string,
  rowData: Array<string>,
  insertAfterId: string
): ThunkAction => (dispatch: Dispatch) => {
  dispatch(addRowRequest(tableId, rowData, insertAfterId));
  if (process.env.NODE_ENV === "production") {
    saveDataApi(`add-row/${tableId}`, {
      rowData,
      insertAfterId
    }).then(({ error }: { error: Error }) => {
      if (error) {
        dispatch(
          addRowError(tableId, rowData, insertAfterId, new Error(error))
        );
        return;
      }

      dispatch(addRowSuccess(tableId, rowData, insertAfterId));
    });
  } else {
    setTimeout(() => {
      dispatch(addRowSuccess(tableId, rowData, insertAfterId));
    }, 500);
  }
};

// ADD COLUMN ACTIONS

export const addColRequest = (
  tableId: string,
  title: string,
  insertAfterId: string
): Action => ({
  type: "ADD_COL_REQUEST",
  payload: {
    tableId,
    title,
    insertAfterId
  }
});

export const addColSuccess = (
  tableId: string,
  title: string,
  insertAfterId: string
): Action => ({
  type: "ADD_COL_SUCCESS",
  payload: {
    tableId,
    title,
    insertAfterId
  }
});

export const addColError = (
  tableId: string,
  title: string,
  insertAfterId: string,
  error: Error
): Action => ({
  type: "ADD_COL_ERROR",
  payload: {
    tableId,
    title,
    insertAfterId,
    error
  }
});

// thunk

export const addCol = (
  tableId: string,
  title: string,
  insertAfterId: string
): ThunkAction => (dispatch: Dispatch) => {
  dispatch(addColRequest(tableId, title, insertAfterId));
  if (process.env.NODE_ENV === "production") {
    saveDataApi(`add-col/${tableId}`, {
      title,
      insertAfterId
    }).then(({ error }: { error: Error }) => {
      if (error) {
        dispatch(addColError(tableId, title, insertAfterId, new Error(error)));
        return;
      }

      dispatch(addColSuccess(tableId, title, insertAfterId));
    });
  } else {
    setTimeout(() => {
      dispatch(addColSuccess(tableId, title, insertAfterId));
    }, 500);
  }
};
