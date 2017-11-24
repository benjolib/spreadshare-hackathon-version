// @flow
import type { Dispatch, Action, ThunkAction } from "../../types";
import type { Table, Row } from "./types";
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

export const editRowRequest = (
  tableId: string,
  rowIndex: number,
  rowData: Row
): Action => ({
  type: "EDIT_ROW_REQUEST",
  payload: {
    tableId,
    rowIndex,
    rowData
  }
});

export const editRowSuccess = (
  tableId: string,
  rowIndex: number,
  rowData: Row
): Action => ({
  type: "EDIT_ROW_SUCCESS",
  payload: {
    tableId,
    rowIndex,
    rowData
  }
});

export const editRowError = (
  tableId: string,
  rowIndex: number,
  rowData: Row,
  error: Error
): Action => ({
  type: "EDIT_ROW_ERROR",
  payload: {
    tableId,
    rowIndex,
    rowData,
    error
  }
});

export const editRow = (
  tableId: string,
  rowIndex: number,
  rowData: Row
): ThunkAction => (dispatch: Dispatch) => {
  dispatch(editRowRequest(tableId, rowIndex, rowData));
  if (process.env.NODE_ENV === "production") {
    saveDataApi(`table/${tableId}/edit-row`, {
      tableId,
      rowIndex,
      rowData
    }).then(({ error }: { error: Error }) => {
      if (error) {
        dispatch(editRowError(tableId, rowIndex, rowData, new Error(error)));
        return;
      }

      dispatch(editRowSuccess(tableId, rowIndex, rowData));
    });
  } else {
    setTimeout(() => {
      dispatch(editRowSuccess(tableId, rowIndex, rowData));
    }, 500);
  }
};

// thunk
