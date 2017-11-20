// @flow
export default (state = [], action) => {
  switch (action.type) {
    case "SELECT_TAG": {
      const { tags } = action;

      return [...state, tags];
    }
    default: {
      return state;
    }
  }
};
