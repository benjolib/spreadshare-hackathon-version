// @flow
/* eslint-disable no-use-before-define */
// TODO: more actions via union type
import type { TablesAction, TablesState } from './containers/Table/types';

export type ReduxState = {
  tables: TablesState,
};

export type Action = TablesAction;

export type Dispatch = (
  action: Action | ThunkAction | PromiseAction | Array<Action>,
) => void;
export type GetState = () => ReduxState;
export type ThunkAction = (dispatch: Dispatch, getState?: GetState) => any;
export type PromiseAction = Promise<Action>;
