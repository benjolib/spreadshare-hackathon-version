export default (state = [], action) => {
  switch (action.type) {
    case 'SELECT_TYPE':
      return {
        ...state,
        type: action.contentType
      };
    default:
      return state;
  }
}
