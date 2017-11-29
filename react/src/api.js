// @flow
import fetchWrapper from "./lib/fetchWrapper";
import { URL } from "./config";

export const fetchDataApi = (method: string) =>
  fetchWrapper(`${URL}/api/v1/${method}`, {
    method: "GET"
  }).then(response => response.json());

export const saveDataApi = (method: string, body: Object) =>
  fetchWrapper(`${URL}/api/v1/${method}`, {
    method: "POST",
    body: JSON.stringify(body)
  }).then(response => response.json());
