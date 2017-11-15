import { TABLE_RECEIVED } from './actions';

const initialState = {
  data: [
    [
      'some',
      'test',
    ],
    [
      'handsontable',
      'data',
    ],
  ],
};

export default (state = initialState, action) => {
  switch (action.type) {
    case TABLE_RECEIVED:
      return {
        ...state,
        table: action.payload.data,
      };
    default:
      return state;
  }
}