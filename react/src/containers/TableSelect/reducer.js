// @flow
import {
  TABLE_GET,
  TABLE_GET_FAILED,
  TABLE_GET_RECEIVED
} from "./actions";

const initialState = {
  all: [],
  isFetching: false
};

export default (state = initialState, action) => {
  switch (action.type) {
    case TABLE_GET:
    case TABLE_GET_FAILED:
      return {
        ...state,
        isFetching: true
      };
    case TABLE_GET_RECEIVED: {
      const all = [];
      action.payload.tables.forEach(tag => {
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
