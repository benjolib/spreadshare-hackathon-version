import { combineReducers } from 'redux';
import { routerReducer } from 'react-router-redux';
import table from '../containers/Table/reducer.js';
import topics from '../containers/TopicsSelect/reducer.js';
import contentTypeReducer from '../containers/ContentTypeSelect/reducer';
import tagsReducer from '../containers/TagsSelect/reducer';

export default combineReducers({
  router: routerReducer,
  table,
  topics,
  contentTypeReducer,
  tagsReducer
});
