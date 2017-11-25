// @flow
import {
  TAGS_GET,
  TAGS_GET_FAILED,
  TAGS_GET_RECEIVED
} from "./actions";

const initialState = {
  all: [],
  isFetching: false
};

export default (state = initialState, action) => {
  switch (action.type) {
    case TAGS_GET:
    case TAGS_GET_FAILED:
      return {
        ...state,
        isFetching: true
      };
    case TAGS_GET_RECEIVED: {
      const all = [];
      action.payload.tags.forEach(tag => {
        all.push({
          label: tag.tagName,
          value: tag.id
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
