import React from 'react';
import { render } from 'react-dom';
import { Provider } from 'react-redux';
import { ConnectedRouter } from 'react-router-redux';
import store, { history } from './store';
import Table from './containers/Table';
import LocationSelect from './containers/LocationSelect';
import TopicsSelect from './containers/TopicsSelect';
import ContentTypeSelect from './containers/ContentTypeSelect';
import TagsSelect from './containers/TagsSelect';

import 'sanitize.css/sanitize.css';
import './index.css';

if (process.env.NODE_ENV === 'production') {
  const componentRegister = {
    Table,
    LocationSelect,
    TopicsSelect,
    ContentTypeSelect,
    TagsSelect
  };

  function renderAppInDom(el) {
    const App = componentRegister[el.id];
    if (!App) {
      return;
    }

    const props = Object.assign({}, el.dataset);

    render(
      <Provider store={store}>
        <ConnectedRouter history={history}>
          <div>
            <App {...props} />
          </div>
        </ConnectedRouter>
      </Provider>, el);
  }

  document
    .querySelectorAll('.react-component')
    .forEach(renderAppInDom);
}
else {
  render (
    <Provider store={store}>
      <ConnectedRouter history={history}>
        <div>
          <div>
            <h1>LocationSelect</h1>
            <LocationSelect />
          </div>
          <div>
            <h1>TopicsSelect</h1>
            <TopicsSelect />
          </div>
          <div>
            <h1>ContentTypeSelect</h1>
            <ContentTypeSelect />
          </div>
          <div>
            <h1>TagsSelect</h1>
            <TagsSelect />
          </div>
          <div>
            <h1>Table</h1>
            <Table />
          </div>
        </div>
      </ConnectedRouter>
    </Provider>, document.getElementById('root'));
}
