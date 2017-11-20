// @flow
import {
  LOCATIONS_GET,
  LOCATIONS_GET_FAILED,
  LOCATIONS_GET_RECEIVED
} from "./actions";

const initialState = {
  all: [],
  isFetching: false
};

export default (state = initialState, action) => {
  switch (action.type) {
    case LOCATIONS_GET:
    case LOCATIONS_GET_FAILED:
      return {
        ...state,
        isFetching: true
      };
    case LOCATIONS_GET_RECEIVED: {
      const all = [];
      action.payload.locations.forEach(location => {
        all.push({
          label: location.locationName,
          value: location.id
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
