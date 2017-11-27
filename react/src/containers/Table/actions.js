// @flow
import type { Dispatch, Action, ThunkAction } from "../../types";
import type { Table, Cell } from "./types";
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

// EDIT ROW ACTIONS

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
