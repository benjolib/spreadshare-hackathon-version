// @flow
import { TOPICS_GET, TOPICS_GET_FAILED, TOPICS_GET_RECEIVED } from './actions';

const initialState = {
  all: [],
  isFetching: false,
};

export default (state = initialState, action) => {
  switch (action.type) {
    case TOPICS_GET:
    case TOPICS_GET_FAILED:
      return {
        ...state,
        isFetching: true,
      };
    case TOPICS_GET_RECEIVED:

      const all = [];
      action.payload.topics.forEach((location) => {
        all.push({
          label: location.title,
          value: location.id,
        });
      });

      return {
        ...state,
        isFetching: false,
        all,
      };
    default:
      return state;
  }
}
