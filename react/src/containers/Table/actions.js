// @flow
import type { Dispatch, Action, ThunkAction } from "../../types";
import type { Table, Row, Cell } from "./types";
import { fetchDataApi, saveDataApi } from "../../api";
import fixInvalidData from "../../lib/fixInvalidData";
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

      const validData = fixInvalidData(data);

      dispatch(fetchTableSuccess(tableId, validData));
    });
  } else {
    setTimeout(() => {
      const validData = fixInvalidData(dummyTable);

      dispatch(fetchTableSuccess(tableId, validData));
    }, 500);
  }
};

// EDIT CELL ACTIONS

export const editCellRequest = (
  tableId: string,
  rowId: string,
  cellId: string,
  cell: Cell,
  permission: string,
  currentValue: string
): Action => ({
  type: "EDIT_CELL_REQUEST",
  payload: {
    tableId,
    rowId,
    cellId,
    cell,
    permission,
    currentValue
  }
});

export const editCellSuccess = (
  tableId: string,
  rowId: string,
  cellId: string,
  cell: Cell,
  permission: string,
  currentValue: string
): Action => ({
  type: "EDIT_CELL_SUCCESS",
  payload: {
    tableId,
    rowId,
    cellId,
    cell,
    permission,
    currentValue
  }
});

export const editCellError = (
  tableId: string,
  rowId: string,
  cellId: string,
  cell: Cell,
  permission: string,
  currentValue: string,
  error: Error
): Action => ({
  type: "EDIT_CELL_ERROR",
  payload: {
    tableId,
    rowId,
    cellId,
    cell,
    permission,
    currentValue,
    error
  }
});

// thunk

export const editCell = (
  tableId: string,
  rowId: string,
  cellId: string,
  cell: Cell,
  permission: string,
  currentValue: string
): ThunkAction => (dispatch: Dispatch) =>
  new Promise((resolve, reject) => {
    dispatch(
      editCellRequest(tableId, rowId, cellId, cell, currentValue, permission)
    );
    if (process.env.NODE_ENV === "production") {
      saveDataApi(`edit-cell/${tableId}`, {
        rowId,
        cellId,
        cell
      }).then(({ error }: { error: Error }) => {
        if (error) {
          dispatch(
            editCellError(
              tableId,
              rowId,
              cellId,
              cell,
              permission,
              currentValue,
              new Error(error)
            )
          );
          reject(new Error(error));
          return;
        }

        dispatch(
          editCellSuccess(
            tableId,
            rowId,
            cellId,
            cell,
            currentValue,
            permission
          )
        );
        resolve();
      });
    } else {
      setTimeout(() => {
        dispatch(
          editCellSuccess(
            tableId,
            rowId,
            cellId,
            cell,
            currentValue,
            permission
          )
        );
        resolve();
      }, 500);
    }
  });

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
  permission: string
): Action => ({
  type: "ADD_ROW_REQUEST",
  payload: {
    tableId,
    rowData,
    permission
  }
});

export const addRowSuccess = (
  tableId: string,
  rowData: Array<string>,
  permission: string,
  response: Object
): Action => ({
  type: "ADD_ROW_SUCCESS",
  payload: {
    tableId,
    rowData,
    permission,
    response
  }
});

export const addRowError = (
  tableId: string,
  rowData: Array<string>,
  permission: string,
  error: Error
): Action => ({
  type: "ADD_ROW_ERROR",
  payload: {
    tableId,
    rowData,
    permission,
    error
  }
});

// thunk

export const addRow = (
  tableId: string,
  rowData: Array<string>,
  permission: string
): ThunkAction => (dispatch: Dispatch) =>
  new Promise((resolve, reject) => {
    dispatch(addRowRequest(tableId, rowData, permission));
    if (process.env.NODE_ENV === "production") {
      saveDataApi(`add-row/${tableId}`, {
        rowData,
        insertAfterId: "0" // TODO: for now we just add row like this
      }).then(({ error, data }: { error: Error }) => {
        if (error) {
          dispatch(addRowError(tableId, rowData, permission, new Error(error)));
          reject();
          return;
        }

        dispatch(addRowSuccess(tableId, rowData, permission, data));
        resolve();
      });
    } else {
      setTimeout(() => {
        dispatch(addRowSuccess(tableId, rowData, permission, {}));
        resolve();
      }, 500);
    }
  });

// ADD COLUMN ACTIONS

export const addColRequest = (
  tableId: string,
  title: string,
  permission: string,
  insertBeforeId?: string,
  insertAfterId?: string
): Action => ({
  type: "ADD_COL_REQUEST",
  payload: {
    tableId,
    title,
    permission,
    insertBeforeId,
    insertAfterId
  }
});

export const addColSuccess = (
  tableId: string,
  title: string,
  permission: string,
  insertBeforeId?: string,
  insertAfterId?: string,
  response: Object
): Action => ({
  type: "ADD_COL_SUCCESS",
  payload: {
    tableId,
    title,
    permission,
    insertBeforeId,
    insertAfterId,
    response
  }
});

export const addColError = (
  tableId: string,
  title: string,
  permission: string,
  insertBeforeId?: string,
  insertAfterId?: string,
  error: Error
): Action => ({
  type: "ADD_COL_ERROR",
  payload: {
    tableId,
    title,
    permission,
    insertBeforeId,
    insertAfterId,
    error
  }
});

// thunk

export const addCol = (
  tableId: string,
  title: string,
  permission: string,
  insertBeforeId?: string,
  insertAfterId?: string
): ThunkAction => (dispatch: Dispatch) =>
  new Promise((resolve, reject) => {
    dispatch(addColRequest(tableId, title, permission));
    if (process.env.NODE_ENV === "production") {
      saveDataApi(`add-col/${tableId}`, {
        title,
        insertBeforeId,
        insertAfterId
      }).then(({ error, data }: { error: Error }) => {
        if (error) {
          dispatch(
            addColError(
              tableId,
              title,
              permission,
              insertBeforeId,
              insertAfterId,
              new Error(error)
            )
          );
          reject();
          return;
        }

        dispatch(
          addColSuccess(
            tableId,
            title,
            permission,
            insertBeforeId,
            insertAfterId,
            data
          )
        );
        resolve();
      });
    } else {
      setTimeout(() => {
        dispatch(
          addColSuccess(
            tableId,
            title,
            permission,
            insertBeforeId,
            insertAfterId,
            {}
          )
        );
        resolve();
      }, 500);
    }
  });

// EDIT COL ACTIONS

export const editColRequest = (
  tableId: string,
  colId: string,
  title: string,
  permission: string
): Action => ({
  type: "EDIT_COL_REQUEST",
  payload: {
    tableId,
    colId,
    title,
    permission
  }
});

export const editColSuccess = (
  tableId: string,
  colId: string,
  title: string,
  permission: string
): Action => ({
  type: "EDIT_COL_SUCCESS",
  payload: {
    tableId,
    colId,
    title,
    permission
  }
});

export const editColError = (
  tableId: string,
  colId: string,
  title: string,
  permission: string,
  error: Error
): Action => ({
  type: "EDIT_COL_ERROR",
  payload: {
    tableId,
    colId,
    title,
    permission,
    error
  }
});

// thunk

export const editCol = (
  tableId: string,
  colId: string,
  title: string,
  permission: string
): ThunkAction => (dispatch: Dispatch) =>
  new Promise((resolve, reject) => {
    dispatch(editColRequest(tableId, colId, title, permission));
    if (process.env.NODE_ENV === "production") {
      saveDataApi(`edit-column/${tableId}`, {
        title,
        columnId: colId
      }).then(({ error }: { error: Error }) => {
        if (error) {
          dispatch(
            editColError(tableId, colId, title, permission, new Error(error))
          );
          reject();
          return;
        }

        dispatch(editColSuccess(tableId, colId, title, permission));
        resolve();
      });
    } else {
      setTimeout(() => {
        dispatch(editColSuccess(tableId, colId, title, permission));
        resolve();
      }, 500);
    }
  });
