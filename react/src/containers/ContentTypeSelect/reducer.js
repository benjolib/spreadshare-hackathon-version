// @flow
import { CONTENT_TYPE_GET, CONTENT_TYPE_GET_FAILED, CONTENT_TYPE_GET_RECEIVED } from "./actions";

const initialState = {
  all: [],
  isFetching: false
};

export default (state = initialState, action) => {
  switch (action.type) {
    case CONTENT_TYPE_GET:
    case CONTENT_TYPE_GET_FAILED:
      return {
        ...state,
        isFetching: true
      };
    case CONTENT_TYPE_GET_RECEIVED: {
      const all = [];
      action.payload.contentType.forEach(data => {
        all.push({
          label: data.title,
          value: data.id
        });
      });

      return {
        ...state,
        isFetching: false,
        all
      };
    }
    default: {
      return state;
    }
  }
};
