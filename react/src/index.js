// @flow
import "babel-polyfill";
import "whatwg-fetch";
import React from "react";
import { render } from "react-dom";
import { Provider } from "react-redux";
import "./globalStyles";
import configureStore from "./store";
import Table from "./containers/Table";
import TableSelect from "./containers/TableSelect";
import LocationSelect from "./containers/LocationSelect";
import TopicsSelect from "./containers/TopicsSelect";
import ContentTypeSelect from "./containers/ContentTypeSelect";
import TagsSelect from "./containers/TagsSelect";

const store = configureStore();

if (process.env.NODE_ENV === "production") {
  const componentRegister = {
    Table,
    LocationSelect,
    TopicsSelect,
    ContentTypeSelect,
    TagsSelect,
    TableSelect
  };

  const renderAppInDom = el => {
    const App = componentRegister[el.id];
    if (!App) {
      return;
    }

    const props = Object.assign({}, el.dataset);

    render(
      <Provider store={store}>
        <div>
          <App {...props} />
        </div>
      </Provider>,
      el
    );
  };

  document.querySelectorAll(".react-component").forEach(renderAppInDom);
} else {
  render(
    <Provider store={store}>
      <div>
        <div>
          <h1>LocationSelect</h1>
          <LocationSelect />
        </div>
        <div>
          <h1>TableSelect</h1>
          <TableSelect />
        </div>
        <div>
          <h1>TopicsSelect</h1>
          <TopicsSelect />
        </div>
        <div>
          <h1>ContentTypeSelect</h1>
          {/* <ContentTypeSelect /> */}
        </div>
        <div>
          <h1>TagsSelect</h1>
          <TagsSelect />
        </div>
        <div>
          <h1>Table</h1>
          <Table id="exampleTableId123" permission="2" />
        </div>
      </div>
    </Provider>,
    document.getElementById("root")
  );
}

export { store };
