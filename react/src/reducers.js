// @flow
import { combineReducers } from 'redux';
import { tablesReducer } from './containers/Table/reducer';
import topicsReducer from './containers/TopicsSelect/reducer';
import contentTypeReducer from './containers/ContentTypeSelect/reducer';

const rootReducer = combineReducers({
  tables: tablesReducer,
  topics: topicsReducer,
  contentType: contentTypeReducer,
});

export default rootReducer;
