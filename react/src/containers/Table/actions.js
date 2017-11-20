// @flow
import type { Dispatch, Action, ThunkAction } from "../../types";
import type { Table } from "./types";
import { fetchDataApi } from "../../api";

// GET TABLE ACTIONS

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

// ASYNC/THUNK ACTIONS WHICH SEND OFF OTHER ACTIONS

export const fetchTable = (
  tableId: string,
  mockFetchDataApi?: typeof fetchDataApi
): ThunkAction => (dispatch: Dispatch) => {
  // send action to show we are requesting
  dispatch(fetchTableRequest(tableId));
  try {
    // use mock if it's passed in otherwise try to use native function
    const api = mockFetchDataApi || fetchDataApi;
    // call fetchTable function or mock
    api(`table/${tableId}`)
      .then(({ error, data }: { error: Error, data: Table }) => {
        if (error) {
          dispatch(fetchTableError(tableId, new Error(error)));
          return;
        }

        if (!data) {
          dispatch(fetchTableError(tableId, new Error("no table")));
          return;
        }

        dispatch(fetchTableSuccess(tableId, data));
      })
      .catch(err => {
        dispatch(fetchTableError(tableId, err));
      });
  } catch (err) {
    dispatch(fetchTableError(tableId, err));
  }
};
