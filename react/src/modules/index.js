// @flow
import { combineReducers } from "redux";
import { routerReducer } from "react-router-redux";
import table from "../containers/Table/reducer";
import topics from "../containers/TopicsSelect/reducer";
import contentTypeReducer from "../containers/ContentTypeSelect/reducer";
import tagsReducer from "../containers/TagsSelect/reducer";

export default combineReducers({
  router: routerReducer,
  table,
  topics,
  contentTypeReducer,
  tagsReducer
});
