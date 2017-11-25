// @flow
import { combineReducers } from "redux";
import { tablesReducer } from "./containers/Table/reducer";
import topicsReducer from "./containers/TopicsSelect/reducer";
import contentTypeReducer from "./containers/ContentTypeSelect/reducer";
import tagsReducer from "./containers/TagsSelect/reducer";

const rootReducer = combineReducers({
  tables: tablesReducer,
  topics: topicsReducer,
  contentType: contentTypeReducer,
  tags: tagsReducer
});

export default rootReducer;
