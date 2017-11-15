import { combineReducers } from 'redux';
import { routerReducer } from 'react-router-redux';
import table from '../containers/table/reducer.js';

export default combineReducers({
  router: routerReducer,
  table,
});