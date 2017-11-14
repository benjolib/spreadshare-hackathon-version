import React from 'react';
import { render } from 'react-dom';
import { Provider } from 'react-redux';
import { ConnectedRouter } from 'react-router-redux';
import store, { history } from './store';
import Table from './containers/table';

import 'sanitize.css/sanitize.css';
import './index.css';

const componentRegister = {
  Table,
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