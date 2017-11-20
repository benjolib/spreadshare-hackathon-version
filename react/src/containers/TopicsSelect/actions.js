// @flow
import { fetchDataApi } from '../../api';

export const TOPICS_GET = 'topics/GET';
export const TOPICS_GET_RECEIVED = 'topics/GET_RECEIVED';
export const TOPICS_GET_FAILED = 'topics/GET_FAILED';

export const fetchTopics = () => {
  return dispatch => {
    dispatch({
      type: TOPICS_GET,
    });

    return fetchDataApi('topics').then((response) => {
      dispatch({
        type: TOPICS_GET_RECEIVED,
        payload: {
          topics: response.data,
        },
      });
    });
  };
};

export function fetchTopicsFailed(message, devMessage, errorCode) {
  return {
    type: TOPICS_GET_FAILED,
    payload: {
      message,
      devMessage,
      errorCode,
    },
  };
}
