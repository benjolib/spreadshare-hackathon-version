import { combineReducers } from 'redux';
import { routerReducer } from 'react-router-redux';
import table from '../containers/table/reducer.js';
import counter from './counter';

export default combineReducers({
  router: routerReducer,
  counter, // counter is an example
  table,
});