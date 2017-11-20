// @flow
/* eslint-disable no-use-before-define */
// TODO: more actions via union type
import type { TablesAction } from "./containers/Table/types";

export type Action = TablesAction;

export type Dispatch = (
  action: Action | ThunkAction | PromiseAction | Array<Action>
) => any;
export type GetState = () => Object;
export type ThunkAction = (dispatch: Dispatch, getState?: GetState) => any;
export type PromiseAction = Promise<Action>;
