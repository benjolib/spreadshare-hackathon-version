// @flow
export const TABLE_GET = 'table/GET';
export const TABLE_RECEIVED = 'table/RECEIVED';
export const TABLE_RECEIVE_FAILED = 'table/RECEIVED';

export const tableReceived = (data) => {
  return dispatch => {
    dispatch({
      type: TABLE_RECEIVED,
      payload: {
        data,
      },
    });
  };
};
