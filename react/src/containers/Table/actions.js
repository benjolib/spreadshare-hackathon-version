// @flow
import type { Dispatch, Action, ThunkAction } from "../../types";
import type { Table } from "./types";
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
  row: number,
  col: number,
  value: string
): Action => ({
  type: "EDIT_CELL_REQUEST",
  payload: {
    tableId,
    row,
    col,
    value
  }
});

export const editCellSuccess = (
  tableId: string,
  row: number,
  col: number,
  value: string
): Action => ({
  type: "EDIT_CELL_SUCCESS",
  payload: {
    tableId,
    row,
    col,
    value
  }
});

export const editCellError = (
  tableId: string,
  row: number,
  col: number,
  value: string,
  error: Error
): Action => ({
  type: "EDIT_CELL_ERROR",
  payload: {
    tableId,
    row,
    col,
    value,
    error
  }
});

export const editCell = (
  tableId: string,
  row: number,
  col: number,
  value: string
): ThunkAction => (dispatch: Dispatch) => {
  dispatch(editCellRequest(tableId, row, col, value));
  if (process.env.NODE_ENV === "production") {
    saveDataApi(`table/${tableId}/edit-cell`, {
      tableId,
      row,
      col,
      value
    }).then(({ error }: { error: Error }) => {
      if (error) {
        dispatch(editCellError(tableId, row, col, value, new Error(error)));
        return;
      }

      dispatch(editCellSuccess(tableId, row, col, value));
    });
  } else {
    setTimeout(() => {
      dispatch(editCellSuccess(tableId, row, col, value));
    }, 500);
  }
};

// thunk
