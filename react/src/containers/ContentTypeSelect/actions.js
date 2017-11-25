// @flow
import { fetchDataApi } from "../../api";

export const CONTENT_TYPE_GET = "contentType/GET";
export const CONTENT_TYPE_GET_RECEIVED = "contentType/GET_RECEIVED";
export const CONTENT_TYPE_GET_FAILED = "contentType/GET_FAILED";

export const fetchContentType = () => dispatch => {
  dispatch({
    type: CONTENT_TYPE_GET
  });

  return fetchDataApi("types").then(response => {
    dispatch({
      type: CONTENT_TYPE_GET_RECEIVED,
      payload: {
        contentType: response.data
      }
    });
  });
};

export function fetchContentTypeFailed(message, devMessage, errorCode) {
  return {
    type: CONTENT_TYPE_GET_FAILED,
    payload: {
      message,
      devMessage,
      errorCode
    }
  };
}
