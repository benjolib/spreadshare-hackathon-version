import { combineReducers } from 'redux';
import { routerReducer } from 'react-router-redux';
import table from '../containers/Table/reducer.js';
import topics from '../containers/TopicsSelect/reducer.js';

export default combineReducers({
  router: routerReducer,
  table,
  topics,
});