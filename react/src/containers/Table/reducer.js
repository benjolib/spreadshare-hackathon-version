import { TABLE_RECEIVED } from './actions';

// TODO: flow typing
// TODO: tests

const initialState = {
  data: [
    // TODO: real data
    [300, 'Timbuk2 Aviator Travel Backpack', '✓', '', '', '✓', '', 'Average', '✓', '', '22 x 12.5 x 9', '28', '', '4.4', '=K4/M4', '$178', '=O4/N4', '', ''],
    [250, 'Deuter ACT Trail 30 backpack', '✓',	'✗', '✓', '✓', '✗', '✓', '✓', '24.4 x 11.5 x 8.3', '30', '2.65', '11.32', '$129', '$11'],
    [100, '', -11, 14, 13],
    [50, '', 15, -12, 'readOnly'],
    [50, '', 15, -12, 'readOnly']
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
